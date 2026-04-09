{{--
    Single comment item (recursive for replies)
    Variables: $comment, $depth (0 = root)
--}}
<div class="rounded-xl overflow-hidden {{ $depth > 0 ? 'ml-8 mt-3' : '' }}"
     style="background:var(--cx-card); border:1px solid var(--cx-border)">
    <div class="flex items-start gap-3 p-4">
        {{-- Avatar --}}
        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-xs uppercase"
             style="background:var(--cx-blue); color:#fff">
            {{ mb_substr($comment->user->name, 0, 1) }}
        </div>

        {{-- Body --}}
        <div class="flex-1 min-w-0">
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="font-semibold text-sm text-white">{{ $comment->user->name }}</span>
                @if($comment->user->is_admin)
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded"
                          style="background:rgba(232,57,42,.15); color:var(--cx-red); border:1px solid rgba(232,57,42,.3)">Staff</span>
                @endif
                <span class="text-xs" style="color:#4b5568">
                    {{ $comment->created_at->diffForHumans() }}
                </span>
            </div>
            <p class="text-sm leading-relaxed" style="color:#8899aa">{{ $comment->body }}</p>

            {{-- Actions --}}
            <div class="flex items-center gap-3 mt-2">
                @auth
                    @if($depth === 0)
                        <button type="button"
                                @click="startReply({{ $comment->id }}, '{{ addslashes($comment->user->name) }}')"
                                class="text-xs transition-colors flex items-center gap-1"
                                style="color:#4b5568"
                                onmouseenter="this.style.color='#00d4ff'" onmouseleave="this.style.color='#4b5568'">
                            <i class="fa-solid fa-reply text-[9px]"></i> Responder
                        </button>
                    @endif

                    @if(auth()->id() === $comment->user_id || auth()->user()->is_admin)
                        <form method="POST" action="{{ route('comments.destroy', $comment) }}"
                              onsubmit="return confirm('¿Eliminar este comentario?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs transition-colors flex items-center gap-1"
                                    style="color:#4b5568"
                                    onmouseenter="this.style.color='#e8392a'" onmouseleave="this.style.color='#4b5568'">
                                <i class="fa-solid fa-trash text-[9px]"></i> Eliminar
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    {{-- Replies --}}
    @if($comment->replies->isNotEmpty() && $depth === 0)
        <div class="pb-4 px-4 space-y-0">
            @foreach($comment->replies as $reply)
                @include('components.comment-item', ['comment' => $reply, 'depth' => 1])
            @endforeach
        </div>
    @endif
</div>
