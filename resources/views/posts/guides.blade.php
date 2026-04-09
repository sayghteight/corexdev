@extends('layouts.app')
@section('title', __('ui.guides_title'))

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-white">{{ __('ui.guides_heading') }}</h1>
        <div class="h-1 w-12 bg-[#8b5cf6] mt-2"></div>
        <p class="text-gray-400 mt-2">{{ __('ui.guides_desc') }}</p>
    </div>

    @if($posts->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($posts as $post)
                @include('components.post-card', ['post' => $post])
            @endforeach
        </div>
        <div class="mt-10">{{ $posts->links() }}</div>
    @else
        <div class="text-center py-20">
            <p class="text-5xl mb-4">📖</p>
            <p class="text-gray-400">{{ __('ui.no_guides_yet') }}</p>
        </div>
    @endif
</div>
@endsection
