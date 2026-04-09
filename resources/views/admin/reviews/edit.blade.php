@extends('layouts.admin')
@section('title', 'Editar Reseña — Admin')

@section('breadcrumb', 'Rese�as � Editar')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-white">Editar Reseña</h1>
        <a href="{{ route('admin.reviews.index') }}" class="text-gray-500 text-xs hover:text-[#00d4ff]">← Volver</a>
    </div>
    @if($errors->any())
        <div class="bg-red-900/40 border border-red-700 text-red-300 rounded-xl p-4 mb-6 text-sm">
            <ul>@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <form method="POST" action="{{ route('admin.reviews.update', $review) }}" enctype="multipart/form-data"
          class="bg-[#111827] border border-[#1e2a3a] rounded-xl p-6 space-y-5">
        @csrf @method('PATCH')

        {{-- Shared fields (game metadata) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-gray-400 text-sm mb-1">Juego *</label>
                <input type="text" name="game" value="{{ old('game', $review->game) }}" required
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ffd700] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Puntuación *</label>
                <input type="number" name="score" value="{{ old('score', $review->score) }}" min="0" max="10" step="0.1" required
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ffd700] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Plataforma</label>
                <input type="text" name="platform" value="{{ old('platform', $review->platform) }}"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ffd700] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Categoría *</label>
                <select name="category_id" required
                        class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ffd700] focus:outline-none">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $review->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Desarrollador</label>
                <input type="text" name="developer" value="{{ old('developer', $review->developer) }}"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ffd700] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Publisher</label>
                <input type="text" name="publisher" value="{{ old('publisher', $review->publisher) }}"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ffd700] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Fecha de lanzamiento</label>
                <input type="date" name="release_date" value="{{ old('release_date', $review->release_date?->format('Y-m-d')) }}"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ffd700] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Imagen</label>
                @if($review->image)
                    <img src="{{ asset('storage/' . $review->image) }}" class="w-24 h-16 object-cover rounded mb-2">
                @endif
                <input type="file" name="image" accept="image/*"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-gray-400 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Estado *</label>
                <select name="status" required
                        class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ffd700] focus:outline-none">
                    <option value="draft"     {{ old('status', $review->status) === 'draft'     ? 'selected' : '' }}>Borrador</option>
                    <option value="published" {{ old('status', $review->status) === 'published' ? 'selected' : '' }}>Publicado</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $review->is_featured) ? 'checked' : '' }}
                           class="rounded border-[#1e2a3a] bg-[#0a0e1a] text-[#ffd700]">
                    <span class="text-gray-300 text-sm"><i class="fa-solid fa-star text-[#ffd700] mr-1"></i> Destacar</span>
                </label>
            </div>
        </div>

        {{-- Language Tabs (translatable fields: title, excerpt, content) --}}
        @php $enTrans = $review->translations->firstWhere('locale', 'en'); @endphp
        <div x-data="{ tab: 'es', enTitle: '{{ old('trans_en.title', $enTrans?->title ?? '') }}' }" class="space-y-5">

        {{-- Tab buttons --}}
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
                <span x-show="enTitle.trim().length > 0" class="w-1.5 h-1.5 rounded-full bg-[#ffd700]"></span>
            </button>
        </div>

        {{-- ES Tab --}}
        <div x-show="tab === 'es'" class="space-y-5">
            <div class="flex items-center gap-2 pb-2" style="border-bottom:1px solid #1e2a3a;">
                <span class="text-lg">🇪🇸</span>
                <span class="text-white font-bold text-sm">Contenido en Español</span>
                <span class="text-red-400 text-xs">(requerido)</span>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Título *</label>
                <input type="text" name="title" value="{{ old('title', $review->title) }}" required
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ffd700] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Extracto</label>
                <textarea name="excerpt" rows="2"
                          class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ffd700] focus:outline-none resize-none">{{ old('excerpt', $review->excerpt) }}</textarea>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Contenido *</label>
                <textarea id="content-editor" name="content" required>{{ old('content', $review->content) }}</textarea>
            </div>
        </div>

        {{-- EN Tab --}}
        <div x-show="tab === 'en'" class="space-y-5">
            <div class="flex items-center gap-2 pb-2" style="border-bottom:1px solid #1e2a3a;">
                <span class="text-lg">🇬🇧</span>
                <span class="text-white font-bold text-sm">English Content</span>
                <span class="text-gray-500 text-xs">(optional — clear Title to remove EN version)</span>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Title</label>
                <input type="text" name="trans_en[title]" value="{{ old('trans_en.title', $enTrans?->title ?? '') }}"
                       x-model="enTitle"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ffd700] focus:outline-none"
                       placeholder="English title...">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Excerpt</label>
                <textarea name="trans_en[excerpt]" rows="2"
                          class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ffd700] focus:outline-none resize-none"
                          placeholder="Short English summary...">{{ old('trans_en.excerpt', $enTrans?->excerpt ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Content</label>
                <textarea id="content-editor-en" name="trans_en[content]">{{ old('trans_en.content', $enTrans?->content ?? '') }}</textarea>
            </div>
        </div>

        </div>{{-- end language tabs Alpine --}}

        {{-- Pros / Cons --}}
        @php
            $enHighlights = $review->highlights->groupBy('type')->map(function($g) {
                return $g->map(function($h) {
                    $t = $h->translations->firstWhere('locale', 'en');
                    return $t?->text ?? '';
                })->values();
            })->toArray();
        @endphp
        <div class="border border-[#1e2a3a] rounded-xl p-5 space-y-4"
             x-data="highlightsEditor({{ json_encode($review->highlights->groupBy('type')->map(fn($g) => $g->pluck('text')->values())->toArray()) }}, {{ json_encode($enHighlights) }})">
            <h3 class="text-white font-bold text-sm flex items-center gap-2">
                <i class="fa-solid fa-table-list text-[#ffd700]"></i>
                Lo Bueno &amp; Lo Malo
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- ES Pros --}}
                <div>
                    <p class="text-green-400 text-xs font-bold uppercase tracking-widest mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-plus"></i> Lo Bueno (ES)
                    </p>
                    <div class="space-y-2">
                        <template x-for="(item, i) in pros" :key="i">
                            <div class="flex gap-2">
                                <input type="text" :name="'pros[' + i + ']'" x-model="pros[i]"
                                       placeholder="Punto positivo..."
                                       class="flex-1 bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-green-500 focus:outline-none">
                                <button type="button" @click="removePro(i)" class="text-gray-600 hover:text-red-400 transition-colors px-1">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="addPro()"
                            class="mt-2 text-green-400 text-xs font-semibold hover:text-green-300 flex items-center gap-1 transition-colors">
                        <i class="fa-solid fa-plus"></i> Agregar pro
                    </button>
                </div>
                {{-- ES Cons --}}
                <div>
                    <p class="text-red-400 text-xs font-bold uppercase tracking-widest mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-minus"></i> Lo Malo (ES)
                    </p>
                    <div class="space-y-2">
                        <template x-for="(item, i) in cons" :key="i">
                            <div class="flex gap-2">
                                <input type="text" :name="'cons[' + i + ']'" x-model="cons[i]"
                                       placeholder="Punto negativo..."
                                       class="flex-1 bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-red-500 focus:outline-none">
                                <button type="button" @click="removeCon(i)" class="text-gray-600 hover:text-red-400 transition-colors px-1">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="addCon()"
                            class="mt-2 text-red-400 text-xs font-semibold hover:text-red-300 flex items-center gap-1 transition-colors">
                        <i class="fa-solid fa-plus"></i> Agregar contra
                    </button>
                </div>
                {{-- EN Pros --}}
                <div>
                    <p class="text-green-300 text-xs font-bold uppercase tracking-widest mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-plus"></i> Pros (EN)
                    </p>
                    <div class="space-y-2">
                        <template x-for="(item, i) in enPros" :key="i">
                            <div class="flex gap-2">
                                <input type="text" :name="'trans_en[pros][' + i + ']'" x-model="enPros[i]"
                                       placeholder="Positive point..."
                                       class="flex-1 bg-[#0a0e1a] border border-[#1e3a1a] text-white rounded-lg px-3 py-2 text-sm focus:border-green-500 focus:outline-none">
                                <button type="button" @click="removeEnPro(i)" class="text-gray-600 hover:text-red-400 transition-colors px-1">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="addEnPro()"
                            class="mt-2 text-green-300 text-xs font-semibold hover:text-green-200 flex items-center gap-1 transition-colors">
                        <i class="fa-solid fa-plus"></i> Add pro
                    </button>
                </div>
                {{-- EN Cons --}}
                <div>
                    <p class="text-red-300 text-xs font-bold uppercase tracking-widest mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-minus"></i> Cons (EN)
                    </p>
                    <div class="space-y-2">
                        <template x-for="(item, i) in enCons" :key="i">
                            <div class="flex gap-2">
                                <input type="text" :name="'trans_en[cons][' + i + ']'" x-model="enCons[i]"
                                       placeholder="Negative point..."
                                       class="flex-1 bg-[#0a0e1a] border border-[#3a1e1e] text-white rounded-lg px-3 py-2 text-sm focus:border-red-500 focus:outline-none">
                                <button type="button" @click="removeEnCon(i)" class="text-gray-600 hover:text-red-400 transition-colors px-1">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="addEnCon()"
                            class="mt-2 text-red-300 text-xs font-semibold hover:text-red-200 flex items-center gap-1 transition-colors">
                        <i class="fa-solid fa-plus"></i> Add con
                    </button>
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#ffd700] text-[#060910] font-bold text-sm rounded-lg hover:bg-yellow-300 transition-all">
                Actualizar Reseña
            </button>
            <a href="{{ route('admin.reviews.index') }}" class="px-6 py-2.5 bg-[#1e2a3a] text-gray-300 font-semibold text-sm rounded-lg hover:bg-[#243447] transition-all">
                Cancelar
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
const TINY_CFG_R = {
    skin: 'oxide-dark',
    content_css: 'dark',
    plugins: 'anchor autolink codesample image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks | bold italic underline strikethrough | link image | numlist bullist | table | codesample | removeformat',
    promotion: false,
    branding: false,
    menubar: false,
    resize: true,
    content_style: 'body { background:#0a0e1a; color:#d1d8e4; font-family:Inter,sans-serif; font-size:14px; padding:1rem; line-height:1.75; } h1,h2,h3,h4 { color:#fff; font-family:Rajdhani,sans-serif; font-weight:700; } a { color:#3b9edd; } blockquote { border-left:3px solid #e8392a; padding-left:1rem; color:#8899aa; } pre { background:#060810; padding:1rem; border-radius:6px; font-size:13px; } img { max-width:100%; border-radius:6px; }',
};
tinymce.init({
    ...TINY_CFG_R,
    selector: '#content-editor',
    height: 500,
    setup: function(editor) {
        editor.on('change input', function() { editor.save(); });
        editor.on('init', function() {
            editor.getElement().form.addEventListener('submit', function() {
                tinymce.triggerSave();
            });
        });
    }
});
tinymce.init({ ...TINY_CFG_R, selector: '#content-editor-en', height: 500,
    setup(ed) { ed.on('change input', () => ed.save()); }
});
</script>
<script>
function highlightsEditor(existing, existingEn) {
    existingEn = existingEn || {};
    return {
        pros:   (existing.pro  && existing.pro.length)          ? [...existing.pro,  ''] : [''],
        cons:   (existing.con  && existing.con.length)          ? [...existing.con,  ''] : [''],
        enPros: (existingEn.pro && existingEn.pro.length)       ? [...existingEn.pro, ''] : [''],
        enCons: (existingEn.con && existingEn.con.length)       ? [...existingEn.con, ''] : [''],
        addPro()       { this.pros.push(''); },
        addCon()       { this.cons.push(''); },
        addEnPro()     { this.enPros.push(''); },
        addEnCon()     { this.enCons.push(''); },
        removePro(i)   { this.pros.splice(i, 1);   if (!this.pros.length)   this.pros.push(''); },
        removeCon(i)   { this.cons.splice(i, 1);   if (!this.cons.length)   this.cons.push(''); },
        removeEnPro(i) { this.enPros.splice(i, 1); if (!this.enPros.length) this.enPros.push(''); },
        removeEnCon(i) { this.enCons.splice(i, 1); if (!this.enCons.length) this.enCons.push(''); },
    };
}
</script>
@endpush
@endsection
