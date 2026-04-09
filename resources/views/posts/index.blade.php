@extends('layouts.app')
@section('title', __('ui.posts_title'))

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    {{-- Header --}}
    <div class="mb-8">
        <p class="cx-section-title mb-2">{{ __('ui.home_latest_label') }}</p>
        <h1 class="cx-heading text-3xl font-black text-white">{{ __('ui.posts_heading') }}</h1>
        <div class="h-[3px] w-20 mt-2" style="background:var(--cx-red)"></div>
    </div>

    {{-- Category filters --}}
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('posts.index') }}"
           class="px-4 py-1.5 text-sm font-semibold rounded-full border transition-all
                  {{ !request('cat') ? 'bg-[#00d4ff] text-[#060910] border-[#00d4ff]' : 'border-[#1e2a3a] text-gray-400 hover:border-[#00d4ff] hover:text-[#00d4ff]' }}">
            {{ __('ui.filter_all') }}
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('categories.show', $cat->slug) }}"
               class="px-4 py-1.5 text-sm font-semibold rounded-full border border-[#1e2a3a] text-gray-400 hover:text-white transition-all"
               style="hover:border-color: {{ $cat->color }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    {{-- Grid --}}
    @if($posts->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($posts as $post)
                @include('components.post-card', ['post' => $post])
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-5xl mb-4">📰</p>
            <p class="text-gray-400">{{ __('ui.no_posts') }}</p>
        </div>
    @endif
</div>
@endsection
