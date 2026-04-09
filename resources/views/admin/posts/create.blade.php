@extends('layouts.admin')
@section('title', 'Nuevo Artículo — Admin')

@section('breadcrumb', 'Noticias → Nueva')
@section('content')
<div class="max-w-4xl mx-auto" x-data="postFormEditor('{{ old('type', 'news') }}')">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Nuevo Artículo</h1>
            <a href="{{ route('admin.posts.index') }}" class="text-gray-500 text-xs hover:text-[#00d4ff]">← Volver a artículos</a>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-900/40 border border-red-700 text-red-300 rounded-xl p-4 mb-6 text-sm">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data"
          class="bg-[#111827] border border-[#1e2a3a] rounded-xl p-6 space-y-5"
          @submit="syncEditors">
        @csrf

        {{-- Language Tabs --}}
        <div class="flex gap-1 p-1 rounded-lg" style="background:#0a0e1a; border:1px solid #1e2a3a; width:fit-content;">
            <button type="button" @click="tab = 'es'"
                    :class="tab === 'es' ? 'bg-[#1e2a3a] text-white' : 'text-gray-500 hover:text-gray-300'"
                    class="flex items-center gap-2 px-4 py-1.5 rounded-md text-sm font-semibold transition-all">
                🇪🇸 Español
            </button>
            <button type="button" @click="tab = 'en'"
                    :class="tab === 'en' ? 'bg-[#1e2a3a] text-white' : 'text-gray-500 hover:text-gray-300'"
                    class="flex items-center gap-2 px-4 py-1.5 rounded-md text-sm font-semibold transition-all">
                🇬🇧 English
                <span x-show="enHasContent" class="w-1.5 h-1.5 rounded-full bg-[#00d4ff]"></span>
            </button>
        </div>

        {{-- Shared fields --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-gray-400 text-sm mb-1">Categoría *</label>
                <select name="category_id" required
                        class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none">
                    <option value="">Seleccionar...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Tipo *</label>
                <select name="type" required x-model="postType" @change="onTypeChange"
                        class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none">
                    <option value="news">Noticia</option>
                    <option value="guide">Guía</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Imagen de portada</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-gray-400 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Estado *</label>
                <select name="status" required
                        class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none">
                    <option value="draft"     {{ old('status', 'draft') === 'draft'     ? 'selected' : '' }}>Borrador</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publicado</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-400 text-sm mb-1">Etiquetas</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                   class="rounded border-[#1e2a3a] bg-[#0a0e1a] text-[#00d4ff]">
                            <span class="text-gray-400 text-sm">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="md:col-span-2 flex flex-wrap gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                           class="rounded border-[#1e2a3a] bg-[#0a0e1a] text-[#ff6b00]">
                    <span class="text-gray-300 text-sm">⭐ Destacado en home</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_slider" value="1" {{ old('is_slider') ? 'checked' : '' }}
                           class="rounded border-[#1e2a3a] bg-[#0a0e1a] text-[#00d4ff]">
                    <span class="text-gray-300 text-sm">◉ Mostrar en slider</span>
                </label>
            </div>
        </div>

        {{-- ── ES TAB ──────────────────────────────────────── --}}
        <div x-show="tab === 'es'" class="space-y-5">
            <div class="flex items-center gap-2 pb-2" style="border-bottom:1px solid #1e2a3a;">
                <span class="text-lg">🇪🇸</span>
                <span class="text-white font-bold text-sm">Contenido en Español</span>
                <span class="text-red-400 text-xs">(requerido)</span>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Título *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Extracto</label>
                <textarea name="excerpt" rows="2"
                          class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none resize-none">{{ old('excerpt') }}</textarea>
            </div>
            <div x-show="postType === 'news'">
                <label class="block text-gray-400 text-sm mb-1">Contenido *</label>
                <textarea id="content-editor" name="content">{{ old('content') }}</textarea>
            </div>

        {{-- ES Guide sections --}}
            <div x-show="postType === 'guide'" class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-white font-bold flex items-center gap-2">
                        <i class="fa-solid fa-list-ol" style="color:var(--cx-red)"></i>
                        Secciones de la guía
                    </h3>
                    <button type="button" @click="addSection()"
                            class="flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-semibold transition-all"
                            style="background:var(--cx-red); color:#fff">
                        <i class="fa-solid fa-plus text-xs"></i> Agregar sección
                    </button>
                </div>
                <div class="space-y-3">
                    <template x-for="(sec, i) in sections" :key="sec.uid">
                        <div class="rounded-lg overflow-hidden" style="border:1px solid var(--cx-border)">
                            <div class="flex items-center gap-3 px-4 py-2.5" style="background:var(--cx-surf); border-bottom:1px solid var(--cx-border)">
                                <span class="w-6 h-6 rounded flex items-center justify-center text-xs font-black flex-shrink-0"
                                      style="background:var(--cx-red); color:#fff" x-text="i + 1"></span>
                                <input type="text" :name="'sections[' + i + '][title]'"
                                       x-model="sec.title" placeholder="Título de la sección..."
                                       class="flex-1 bg-transparent border-0 text-white text-sm font-semibold focus:outline-none placeholder-gray-600">
                                <input type="hidden" :name="'sections[' + i + '][sort_order]'" :value="i">
                                <div class="flex items-center gap-1">
                                    <button type="button" @click="moveUp(i)" :disabled="i === 0"
                                            class="w-7 h-7 rounded flex items-center justify-center transition-all disabled:opacity-30"
                                            style="color:#4b5568" onmouseenter="this.style.color='#d1d8e4'" onmouseleave="this.style.color='#4b5568'">
                                        <i class="fa-solid fa-chevron-up text-xs"></i>
                                    </button>
                                    <button type="button" @click="moveDown(i)" :disabled="i === sections.length - 1"
                                            class="w-7 h-7 rounded flex items-center justify-center transition-all disabled:opacity-30"
                                            style="color:#4b5568" onmouseenter="this.style.color='#d1d8e4'" onmouseleave="this.style.color='#4b5568'">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </button>
                                    <button type="button" @click="removeSection(i)"
                                            class="w-7 h-7 rounded flex items-center justify-center transition-all"
                                            style="color:#4b5568" onmouseenter="this.style.color='#ef4444'" onmouseleave="this.style.color='#4b5568'">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            <div style="background:var(--cx-card)">
                                <textarea :id="sec.uid" :name="'sections[' + i + '][content]'"></textarea>
                            </div>
                        </div>
                    </template>
                </div>
                <p x-show="sections.length === 0" class="text-sm text-center py-8" style="color:#4b5568">
                    <i class="fa-solid fa-circle-info mr-1"></i> Agrega al menos una sección para la guía.
                </p>
            </div>
        </div>{{-- end ES tab --}}

        {{-- ── EN TAB ──────────────────────────────────────── --}}
        <div x-show="tab === 'en'" class="space-y-5">
            <div class="flex items-center gap-2 pb-2" style="border-bottom:1px solid #1e2a3a;">
                <span class="text-lg">🇬🇧</span>
                <span class="text-white font-bold text-sm">English Content</span>
                <span class="text-gray-500 text-xs">(optional — leave Title empty to skip EN version)</span>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Title</label>
                <input type="text" name="trans_en[title]" value="{{ old('trans_en.title') }}"
                       x-model="enTitle"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none"
                       placeholder="English title...">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Excerpt</label>
                <textarea name="trans_en[excerpt]" rows="2"
                          class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none resize-none"
                          placeholder="Short English summary...">{{ old('trans_en.excerpt') }}</textarea>
            </div>
            <div x-show="postType === 'news'">
                <label class="block text-gray-400 text-sm mb-1">Content</label>
                <textarea id="content-editor-en" name="trans_en[content]">{{ old('trans_en.content') }}</textarea>
            </div>

            {{-- EN Guide sections (mirrors ES section structure) --}}
            <div x-show="postType === 'guide'" class="space-y-4">
                <h3 class="text-white font-bold flex items-center gap-2">
                    <i class="fa-solid fa-list-ol" style="color:#00d4ff"></i>
                    Guide Sections
                    <span class="text-gray-500 text-xs font-normal">(structure follows ES tab)</span>
                </h3>
                <template x-for="(sec, i) in sections" :key="'en-' + sec.uid">
                    <div class="rounded-lg overflow-hidden" style="border:1px solid #1e3a5f">
                        <div class="flex items-center gap-3 px-4 py-2.5" style="background:#0a1628; border-bottom:1px solid #1e3a5f">
                            <span class="w-6 h-6 rounded flex items-center justify-center text-xs font-black flex-shrink-0"
                                  style="background:#00d4ff; color:#060910" x-text="i + 1"></span>
                            <span class="text-gray-500 text-xs mr-1">ES:</span>
                            <span class="text-gray-400 text-sm italic truncate flex-1" x-text="sec.title || '(sin título)'"></span>
                        </div>
                        <div class="px-4 py-2" style="background:#0a0e1a">
                            <input type="text" :name="'trans_en[sections][' + i + '][title]'"
                                   :value="enSections[i] ? enSections[i].title : ''"
                                   @input="enSections[i] && (enSections[i].title = $event.target.value)"
                                   placeholder="English section title..."
                                   class="w-full bg-transparent border-0 border-b text-white text-sm font-semibold focus:outline-none placeholder-gray-700 pb-1 mb-2"
                                   style="border-color:#1e2a3a">
                        </div>
                        <div style="background:var(--cx-card)">
                            <textarea :id="'en-' + sec.uid" :name="'trans_en[sections][' + i + '][content]'"></textarea>
                        </div>
                    </div>
                </template>
                <p x-show="sections.length === 0" class="text-sm text-center py-8" style="color:#4b5568">
                    <i class="fa-solid fa-circle-info mr-1"></i> Add sections in the ES tab first.
                </p>
            </div>
        </div>{{-- end EN tab --}}

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="px-6 py-2.5 bg-[#00d4ff] text-[#060910] font-bold text-sm rounded-lg hover:bg-cyan-300 transition-all">
                Guardar Artículo
            </button>
            <a href="{{ route('admin.posts.index') }}"
               class="px-6 py-2.5 bg-[#1e2a3a] text-gray-300 font-semibold text-sm rounded-lg hover:bg-[#243447] transition-all">
                Cancelar
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
const TINY_CFG = {
    skin: 'oxide-dark', content_css: 'dark',
    plugins: 'anchor autolink codesample image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks | bold italic underline strikethrough | link image | numlist bullist | table | codesample | removeformat',
    promotion: false, branding: false, menubar: false, resize: true,
    content_style: 'body { background:#0a0e1a; color:#d1d8e4; font-family:Inter,sans-serif; font-size:14px; padding:1rem; line-height:1.75; } h1,h2,h3,h4 { color:#fff; font-family:Rajdhani,sans-serif; font-weight:700; } a { color:#3b9edd; } blockquote { border-left:3px solid #e8392a; padding-left:1rem; color:#8899aa; } pre { background:#060810; padding:1rem; border-radius:6px; } img { max-width:100%; border-radius:6px; }',
};

function initSecEditor(uid, content) {
    tinymce.init({ ...TINY_CFG, selector: '#' + uid, height: 380,
        setup(ed) { ed.on('init', () => { if (content) ed.setContent(content); }); }
    });
}

tinymce.init({ ...TINY_CFG, selector: '#content-editor', height: 500,
    setup(ed) { ed.on('change input', () => ed.save()); }
});
tinymce.init({ ...TINY_CFG, selector: '#content-editor-en', height: 500,
    setup(ed) { ed.on('change input', () => ed.save()); }
});

function postFormEditor(initialType) {
    return {
        postType: initialType,
        tab: 'es',
        enTitle: '{{ old('trans_en.title', '') }}',
        sections: [],
        enSections: [],
        _uidCtr: 0,

        get enHasContent() { return this.enTitle.trim().length > 0; },

        init() {
            @if(old('sections'))
            const oldSecs = @json(old('sections', []));
            const oldEnSecs = @json(old('trans_en.sections', []));
            oldSecs.forEach((s, idx) => {
                const uid = 'gse-cr-' + (this._uidCtr++);
                this.sections.push({ uid, title: s.title ?? '', content: s.content ?? '' });
                this.enSections.push({ title: oldEnSecs[idx]?.title ?? '', content: oldEnSecs[idx]?.content ?? '' });
                this.$nextTick(() => {
                    initSecEditor(uid, s.content ?? '');
                    initSecEditor('en-' + uid, oldEnSecs[idx]?.content ?? '');
                });
            });
            @endif
        },

        onTypeChange() {
            if (this.postType === 'guide' && this.sections.length === 0) this.addSection();
        },

        addSection() {
            const uid = 'gse-cr-' + (this._uidCtr++);
            this.sections.push({ uid, title: '', content: '' });
            this.enSections.push({ title: '', content: '' });
            this.$nextTick(() => {
                initSecEditor(uid, '');
                initSecEditor('en-' + uid, '');
            });
        },

        removeSection(i) {
            const uid = this.sections[i].uid;
            [tinymce.get(uid), tinymce.get('en-' + uid)].forEach(ed => ed && ed.remove());
            this.sections.splice(i, 1);
            this.enSections.splice(i, 1);
        },

        moveUp(i) {
            if (i > 0) {
                [this.sections[i-1], this.sections[i]] = [this.sections[i], this.sections[i-1]];
                [this.enSections[i-1], this.enSections[i]] = [this.enSections[i], this.enSections[i-1]];
            }
        },

        moveDown(i) {
            if (i < this.sections.length - 1) {
                [this.sections[i], this.sections[i+1]] = [this.sections[i+1], this.sections[i]];
                [this.enSections[i], this.enSections[i+1]] = [this.enSections[i+1], this.enSections[i]];
            }
        },

        syncEditors() { tinymce.triggerSave(); }
    };
}
</script>
@endpush('scripts')
@endsection