@extends('layouts.app')
@section('title', $category->name . ' — Corex-Dev')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-white" style="color:{{ $category->color ?? '#00d4ff' }}">
            {{ strtoupper($category->name) }}
        </h1>
        <div class="h-1 w-16 mt-2" style="background-color:{{ $category->color ?? '#00d4ff' }}"></div>
        @if($category->description)
            <p class="text-gray-400 mt-2">{{ $category->description }}</p>
        @endif
    </div>

    @if($posts->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($posts as $post)
                @include('components.post-card', ['post' => $post])
            @endforeach
        </div>
        <div class="mt-10">{{ $posts->links() }}</div>
    @else
        <p class="text-gray-500 text-center py-20">{{ __('ui.no_category_posts') }}</p>
    @endif
</div>
@endsection
