{{--
    Comments Section Component
    Usage: @include('components.comments', ['post' => $post, 'comments' => $comments])
--}}
@php
    $commentCount = $comments->total();
@endphp

<section id="comments" class="mt-12" x-data="commentsSection()">

    <div class="flex items-center gap-3 mb-6">
        <i class="fa-solid fa-comments" style="color:var(--cx-blue)"></i>
        <h3 class="cx-heading font-black text-white text-xl">
            Comentarios
            <span class="text-sm font-normal ml-1" style="color:#4b5568">({{ $commentCount }})</span>
        </h3>
    </div>

    {{-- Flash message --}}
    @if(session('comment_success'))
        <div class="flex items-center gap-2 text-sm rounded-lg px-4 py-3 mb-6"
             style="background:rgba(0,212,255,.08); border:1px solid rgba(0,212,255,.25); color:#00d4ff">
            <i class="fa-solid fa-circle-check text-xs"></i>
            {{ session('comment_success') }}
        </div>
    @endif

    {{-- ── Comment form ──────────────────────────────────────────── --}}
    @auth
        <div class="rounded-xl p-5 mb-8" style="background:var(--cx-card); border:1px solid var(--cx-border)">
            <h4 class="text-white font-semibold text-sm mb-3">Deja un comentario</h4>
            <form method="POST" action="{{ route('comments.store', $post) }}" x-ref="mainForm">
                @csrf
                <input type="hidden" name="parent_id" x-model="replyTo">

                <div x-show="replyTo" class="flex items-center gap-2 text-xs rounded-lg px-3 py-2 mb-3"
                     style="background:rgba(0,212,255,.06); border:1px solid rgba(0,212,255,.2); color:#00d4ff">
                    <i class="fa-solid fa-reply text-[10px]"></i>
                    <span>Respondiendo a <strong x-text="replyToName"></strong></span>
                    <button type="button" @click="cancelReply()" class="ml-auto hover:text-white">
                        <i class="fa-solid fa-xmark text-[10px]"></i>
                    </button>
                </div>

                <textarea name="body" rows="3" required maxlength="2000"
                    placeholder="Escribe tu comentario..."
                    class="w-full text-sm rounded-lg px-3 py-2.5 resize-none focus:outline-none focus:border-[#00d4ff] transition-colors"
                    style="background:#0a0e1a; border:1px solid var(--cx-border); color:#d1d8e4"
                >{{ old('body') }}</textarea>

                @error('body')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror

                <div class="flex items-center justify-between mt-3">
                    <span class="text-xs" style="color:#4b5568">
                        Comentando como <strong style="color:#8899aa">{{ auth()->user()->name }}</strong>
                    </span>
                    <button type="submit"
                            class="flex items-center gap-2 text-sm font-semibold px-4 py-2 rounded-lg transition-all"
                            style="background:var(--cx-blue); color:#fff"
                            onmouseenter="this.style.opacity='.85'" onmouseleave="this.style.opacity='1'">
                        <i class="fa-solid fa-paper-plane text-xs"></i> Enviar
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="rounded-xl px-5 py-4 mb-8 text-sm" style="background:var(--cx-card); border:1px solid var(--cx-border); color:#8899aa">
            <a href="{{ route('login') }}" class="font-semibold hover:underline" style="color:var(--cx-blue)">Inicia sesión</a>
            o
            <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color:var(--cx-blue)">regístrate</a>
            para dejar un comentario.
        </div>
    @endauth

    {{-- ── Comment list ──────────────────────────────────────────── --}}
    @if($comments->isEmpty())
        <div class="text-center py-12" style="color:#4b5568">
            <i class="fa-regular fa-comments text-3xl mb-3 block"></i>
            <p class="text-sm">Sé el primero en comentar.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($comments as $comment)
                @include('components.comment-item', ['comment' => $comment, 'depth' => 0])
            @endforeach
        </div>

        <div class="mt-6">
            {{ $comments->links() }}
        </div>
    @endif

</section>

@push('scripts')
<script>
function commentsSection() {
    return {
        replyTo: null,
        replyToName: '',
        startReply(id, name) {
            this.replyTo = id;
            this.replyToName = name;
            this.$nextTick(() => {
                this.$refs.mainForm.querySelector('textarea').focus();
                this.$refs.mainForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        },
        cancelReply() {
            this.replyTo = null;
            this.replyToName = '';
        },
    };
}
</script>
@endpush
