@extends('components.layouts.app')

@section('title', 'Tag: ' . $tag->name)

@section('content')
    <div class="container py-4">
        <h2 class="text-2xl font-bold mb-4">Post dengan Tag: {{ $tag->name }}</h2>
        @if ($posts->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    <div class="bg-white shadow rounded p-4">
                        <a href="{{ route('post.show', $post->slug) }}"
                            class="text-lg font-semibold hover:text-blue-600">{{ $post->title }}</a>
                        <p class="text-sm text-gray-500 mb-2">{{ $post->published_at->format('d M Y') }}</p>
                        <div class="mb-2">{!! $post->excerpt !!}</div>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($post->tags as $t)
                                <a href="{{ route('post.tag', $t->slug) }}"
                                    class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">#{{ $t->name }}</a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 flex justify-center">
                {{ $posts->links('livewire.posts.tagdesain') }}
            </div>
        @else
            <p>Tidak ada postingan dengan tag ini.</p>
        @endif
    </div>
@endsection
