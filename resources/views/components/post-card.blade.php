<a href="{{ route('posts.show', $post->slug) }}"
   class="relative rounded-lg overflow-hidden group cx-card flex flex-col"
   onmouseenter="this.style.borderColor='rgba(232,57,42,.35)'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 28px rgba(0,0,0,.4)'"
   onmouseleave="this.style.borderColor='var(--cx-border)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">

    {{-- Image --}}
    <div class="relative overflow-hidden h-44 flex-shrink-0">
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center cx-grid-bg" style="background:var(--cx-card)">
                <span class="text-4xl opacity-15">🎮</span>
            </div>
        @endif

        {{-- Bottom gradient fade --}}
        <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(22,27,35,.95) 0%, rgba(22,27,35,.2) 50%, transparent 100%)"></div>

        {{-- Top badges --}}
        <div class="absolute top-2 left-2 right-2 flex items-start justify-between gap-1">
            <div class="flex flex-col gap-1">
                @if($post->type === 'guide')
                    <span class="cx-badge self-start" style="background:rgba(59,158,221,.9)">Guía</span>
                @endif
            </div>
            <div>
                @if($post->is_featured)
                    <span class="cx-badge cx-badge-red">Destacado</span>
                @endif
            </div>
        </div>

        {{-- Category --}}
        @if($post->category)
            <div class="absolute bottom-2 left-2">
                <span class="cx-badge cx-badge-red">{{ $post->category->name }}</span>
            </div>
        @endif
    </div>

    {{-- Body --}}
    <div class="p-4 flex flex-col flex-1">
        <h3 class="cx-heading text-[#d1d8e4] font-bold text-sm leading-snug group-hover:text-white transition-colors line-clamp-3 flex-1">
            {{ $post->title }}
        </h3>
        <div class="flex items-center justify-between mt-3 pt-3" style="border-top:1px solid var(--cx-border)">
            <span class="text-[#4b5568] text-xs">{{ $post->published_at?->diffForHumans() }}</span>
            <span class="flex items-center gap-1 text-[11px]" style="color:#2d3748">
                <i class="fa fa-eye text-[9px]"></i>
                {{ number_format($post->views) }}
            </span>
        </div>
    </div>
</a>
