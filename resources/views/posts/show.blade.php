@extends('layouts.app')
@section('title', $post->title . ' — Corex-Dev')
@section('description', $post->excerpt)

@push('styles')
<style>
    /* Guide TOC active state */
    .toc-link.active { color: var(--cx-amber) !important; }
    .toc-link.active::before { opacity:1 !important; }
    /* Guide section anchor offset for sticky nav */
    .guide-section { scroll-margin-top: 80px; }
    /* Prose overrides for CX */
    .cx-prose h2 { color:#fff; font-size:1.4rem; font-weight:800; margin:1.5rem 0 .6rem; font-family:'Rajdhani',sans-serif; }
    .cx-prose h3 { color:#fff; font-size:1.15rem; font-weight:700; margin:1.2rem 0 .5rem; }
    .cx-prose p  { color:#8899aa; line-height:1.8; margin-bottom:.9rem; }
    .cx-prose img { border-radius:8px; margin:1rem 0; width:100%; border:1px solid var(--cx-border); }
    .cx-prose a  { color:var(--cx-blue); text-decoration:underline; }
    .cx-prose ul, .cx-prose ol { color:#8899aa; padding-left:1.4rem; margin-bottom:.9rem; }
    .cx-prose li { margin-bottom:.35rem; }
    .cx-prose blockquote { border-left:3px solid var(--cx-amber); padding-left:1rem; color:#6b7280; margin:1rem 0; }
    .cx-prose pre { background:#060810; padding:1rem; border-radius:6px; overflow-x:auto; font-size:13px; }
    .cx-prose strong { color:#d1d8e4; }
    .cx-prose code { color:var(--cx-blue); font-size:.875em; }
    .cx-prose table { width:100%; border-collapse:collapse; margin:1rem 0; }
    .cx-prose th { background:var(--cx-surf); color:#fff; padding:.5rem .75rem; text-align:left; font-size:.8rem; font-weight:700; text-transform:uppercase; border:1px solid var(--cx-border); }
    .cx-prose td { padding:.5rem .75rem; color:#8899aa; border:1px solid var(--cx-border); font-size:.875rem; }
    .cx-prose tr:nth-child(even) td { background:rgba(255,255,255,.02); }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════ GUIDE LAYOUT ═══════════════════════════════ --}}
@if($post->type === 'guide' && $sections->isNotEmpty())

<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-[11px] mb-6" style="color:#4b5568">
        <a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ __('ui.breadcrumb_home') }}</a>
        <i class="fa-solid fa-chevron-right text-[8px]"></i>
        <a href="{{ route('guides.index') }}" class="hover:text-white transition-colors">{{ __('ui.nav_guides') }}</a>
        @if($post->category)
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <a href="{{ route('categories.show', $post->category->slug) }}" class="hover:text-white transition-colors">{{ $post->category->name }}</a>
        @endif
        <i class="fa-solid fa-chevron-right text-[8px]"></i>
        <span class="text-[#8899aa] truncate max-w-[200px]">{{ $post->title }}</span>
    </nav>

    {{-- Guide hero header --}}
    <div class="rounded-lg overflow-hidden mb-8" style="border:1px solid var(--cx-border)">
        @if($post->image)
            <div class="relative" style="max-height:320px; overflow:hidden">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                     class="w-full object-cover" style="max-height:320px">
                <div class="absolute inset-0" style="background:linear-gradient(to bottom, transparent 40%, var(--cx-card) 100%)"></div>
            </div>
        @endif
        <div class="p-6" style="background:var(--cx-card)">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="cx-badge" style="background:rgba(139,92,246,.15); color:#a78bfa; border:1px solid rgba(139,92,246,.3)">
                    <i class="fa-solid fa-book text-[8px]"></i> {{ __('ui.post_badge_guide') }}
                </span>
                @if($post->category)
                    <span class="cx-badge" style="background:{{ $post->category->color ?? '#3b9edd' }}20; color:{{ $post->category->color ?? '#3b9edd' }}; border:1px solid {{ $post->category->color ?? '#3b9edd' }}40">
                        {{ $post->category->name }}
                    </span>
                @endif
                @foreach($post->tags as $tag)
                    <span class="cx-badge" style="background:var(--cx-surf); color:#4b5568">#{{ $tag->name }}</span>
                @endforeach
            </div>
            <h1 class="cx-heading font-black text-3xl text-white leading-tight mb-3">{{ $post->title }}</h1>
            @if($post->excerpt)
                <p class="text-base mb-4" style="color:#8899aa">{{ $post->excerpt }}</p>
            @endif
            <div class="flex flex-wrap items-center gap-4 text-xs" style="color:#4b5568">
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-user text-[9px]"></i> {{ $post->user?->name ?? __('ui.author_default') }}
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-calendar text-[9px]"></i> {{ $post->published_at?->format('d M Y') }}
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-eye text-[9px]"></i> {{ number_format($post->views) }} {{ __('ui.views_label') }}
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-list-ol text-[9px]"></i> {{ $sections->count() }} {{ __('ui.guide_sections_label') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Main grid: TOC + content --}}
    <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-8 items-start">

        {{-- ── Sticky TOC ─────────────────────────────────────────── --}}
        <nav id="guide-toc" class="lg:sticky lg:top-20 rounded-lg overflow-hidden flex-shrink-0" style="border:1px solid var(--cx-border)">
            <div class="px-4 py-3 flex items-center gap-2" style="background:var(--cx-surf); border-bottom:1px solid var(--cx-border)">
                <i class="fa-solid fa-list-ul text-[10px]" style="color:var(--cx-amber)"></i>
                <span class="text-white font-black text-sm cx-heading tracking-wide">{{ __('ui.guide_toc_label') }}</span>
            </div>
            <div style="background:var(--cx-card)">
                <ul class="py-2">
                    @foreach($sections as $i => $section)
                        <li>
                            <a href="#section-{{ $i + 1 }}"
                               class="toc-link flex items-center gap-3 px-4 py-2.5 text-sm transition-all relative group"
                               style="color:#8899aa"
                               onmouseenter="this.style.color='#d1d8e4'; this.style.background='rgba(255,255,255,.03)'"
                               onmouseleave="if(!this.classList.contains('active')){this.style.color='#8899aa'; this.style.background='transparent'}"
                               data-section="{{ $i + 1 }}">
                                {{-- Left accent --}}
                                <span class="absolute left-0 top-0 bottom-0 w-0.5 opacity-0 transition-opacity"
                                      style="background:var(--cx-amber)"></span>
                                <span class="w-5 h-5 rounded flex items-center justify-center text-xs font-bold flex-shrink-0"
                                      style="background:var(--cx-surf); color:#4b5568">{{ $i + 1 }}</span>
                                <span class="leading-snug line-clamp-2">{{ $section->title }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </nav>

        {{-- ── Sections content ───────────────────────────────────── --}}
        <div class="space-y-10 min-w-0">
            @foreach($sections as $i => $section)
                <article id="section-{{ $i + 1 }}" class="guide-section rounded-lg overflow-hidden"
                         style="border:1px solid var(--cx-border)">
                    {{-- Section header --}}
                    <div class="flex items-center gap-3 px-5 py-4" style="background:var(--cx-surf); border-bottom:1px solid var(--cx-border)">
                        <span class="w-8 h-8 rounded flex items-center justify-center font-black text-sm flex-shrink-0"
                              style="background:var(--cx-red); color:#fff">{{ $i + 1 }}</span>
                        <h2 class="cx-heading font-black text-white text-xl leading-tight">{{ $section->title }}</h2>
                    </div>
                    {{-- Section body --}}
                    @if($section->content)
                        <div class="cx-prose p-6" style="background:var(--cx-card)">
                            {!! $section->content !!}
                        </div>
                    @endif
                    {{-- Section nav --}}
                    <div class="flex items-center justify-between px-5 py-3" style="background:var(--cx-surf); border-top:1px solid var(--cx-border)">
                        @if($i > 0)
                            <a href="#section-{{ $i }}" class="flex items-center gap-2 text-xs transition-colors" style="color:#4b5568"
                               onmouseenter="this.style.color='#d1d8e4'" onmouseleave="this.style.color='#4b5568'">
                                <i class="fa-solid fa-chevron-left text-[9px]"></i> {{ $sections[$i-1]->title }}
                            </a>
                        @else
                            <span></span>
                        @endif
                        @if($i < $sections->count() - 1)
                            <a href="#section-{{ $i + 2 }}" class="flex items-center gap-2 text-xs transition-colors" style="color:#4b5568"
                               onmouseenter="this.style.color='#d1d8e4'" onmouseleave="this.style.color='#4b5568'">
                                {{ $sections[$i+1]->title }} <i class="fa-solid fa-chevron-right text-[9px]"></i>
                            </a>
                        @else
                            <span class="text-xs flex items-center gap-1.5" style="color:var(--cx-amber)">
                                <i class="fa-solid fa-check text-[9px]"></i> {{ __('ui.guide_end_label') }}
                            </span>
                        @endif
                    </div>
                </article>
            @endforeach

            {{-- Tags --}}
            @if($post->tags->isNotEmpty())
                <div class="flex flex-wrap gap-2 pt-4" style="border-top:1px solid var(--cx-border)">
                    <span class="text-xs" style="color:#4b5568; line-height:2">{{ __('ui.tags_label') }}</span>
                    @foreach($post->tags as $tag)
                        <span class="cx-badge" style="background:var(--cx-surf); color:#4b5568; border:1px solid var(--cx-border)">#{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Related guides --}}
    @if($related->isNotEmpty())
        <section class="mt-12">
            <h3 class="cx-section-title mb-5">{{ __('ui.related_guides') }}</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($related as $rp)
                    @include('components.post-card', ['post' => $rp])
                @endforeach
            </div>
        </section>
    @endif

    {{-- Comments --}}
    <div class="max-w-3xl">
        @include('components.comments', ['post' => $post, 'comments' => $comments])
    </div>
</div>

@push('scripts')
<script>
(function() {
    const tocLinks = document.querySelectorAll('.toc-link');
    const sections = document.querySelectorAll('.guide-section');
    if (!sections.length) return;

    function setActive(index) {
        tocLinks.forEach((l, i) => {
            const accent = l.querySelector('span:first-child');
            if (i === index) {
                l.classList.add('active');
                l.style.color = 'var(--cx-amber)';
                l.style.background = 'rgba(245,158,11,.05)';
                if (accent) accent.style.opacity = '1';
            } else {
                l.classList.remove('active');
                l.style.color = '#8899aa';
                l.style.background = 'transparent';
                if (accent) accent.style.opacity = '0';
            }
        });
    }

    // Smooth scroll for TOC links
    tocLinks.forEach(l => {
        l.addEventListener('click', e => {
            e.preventDefault();
            const target = document.querySelector(l.getAttribute('href'));
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    // Intersection observer for active section
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute('id');
                const idx = parseInt(id.replace('section-', '')) - 1;
                setActive(idx);
            }
        });
    }, { rootMargin: '-20% 0px -70% 0px' });

    sections.forEach(s => observer.observe(s));
    setActive(0);
})();
</script>
@endpush

{{-- ═══════════════════════════════ NEWS LAYOUT ════════════════════════════════ --}}
@else

<div class="max-w-4xl mx-auto px-4 py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-[11px] mb-6" style="color:#4b5568">
        <a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ __('ui.breadcrumb_home') }}</a>
        <i class="fa-solid fa-chevron-right text-[8px]"></i>
        <a href="{{ route('posts.index') }}" class="hover:text-white transition-colors">{{ __('ui.nav_news') }}</a>
        @if($post->category)
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <a href="{{ route('categories.show', $post->category->slug) }}" class="hover:text-white transition-colors">{{ $post->category->name }}</a>
        @endif
        <i class="fa-solid fa-chevron-right text-[8px]"></i>
        <span class="text-[#8899aa] truncate max-w-[200px]">{{ $post->title }}</span>
    </nav>

    <article>
        {{-- Category & Meta --}}
        <div class="flex flex-wrap items-center gap-2 mb-4">
            @if($post->category)
                <span class="cx-badge" style="background:{{ $post->category->color ?? 'var(--cx-blue)' }}20; color:{{ $post->category->color ?? 'var(--cx-blue)' }}; border:1px solid {{ $post->category->color ?? 'var(--cx-blue)' }}40">
                    {{ $post->category->name }}
                </span>
            @endif
            @if($post->type === 'guide')
                <span class="cx-badge" style="background:rgba(139,92,246,.15); color:#a78bfa; border:1px solid rgba(139,92,246,.3)">
                    <i class="fa-solid fa-book text-[8px]"></i> {{ __('ui.post_badge_article') }}
                </span>
            @endif
            <span class="text-xs" style="color:#4b5568">{{ $post->published_at?->format('d M Y') }}</span>
            <span class="text-xs" style="color:#4b5568">{{ __('ui.by_author') }}{{ $post->user?->name ?? __('ui.author_default') }}</span>
            <span class="text-xs" style="color:#4b5568">· {{ number_format($post->views) }} {{ __('ui.views_label') }}</span>
        </div>

        <h1 class="cx-heading font-black text-3xl md:text-4xl text-white leading-tight mb-6">{{ $post->title }}</h1>

        @if($post->excerpt)
            <p class="text-base border-l-3 pl-4 mb-6 italic" style="color:#8899aa; border-left:3px solid var(--cx-blue)">{{ $post->excerpt }}</p>
        @endif

        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                 class="w-full rounded-lg mb-8 object-cover" style="max-height:400px; border:1px solid var(--cx-border)">
        @endif

        <div class="cx-prose">
            {!! $post->content !!}
        </div>

        @if($post->tags->isNotEmpty())
            <div class="flex flex-wrap gap-2 mt-8 pt-6" style="border-top:1px solid var(--cx-border)">
                <span class="text-xs" style="color:#4b5568; line-height:2">{{ __('ui.tags_label') }}</span>
                @foreach($post->tags as $tag)
                    <span class="cx-badge" style="background:var(--cx-surf); color:#4b5568; border:1px solid var(--cx-border)">#{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif
    </article>

    @if($related->isNotEmpty())
        <section class="mt-12">
            <h3 class="cx-section-title mb-5">{{ __('ui.related_articles') }}</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($related as $rp)
                    @include('components.post-card', ['post' => $rp])
                @endforeach
            </div>
        </section>
    @endif

    {{-- Comments --}}
    @include('components.comments', ['post' => $post, 'comments' => $comments])
</div>

@endif
@endsection
