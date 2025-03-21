@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8 px-4">
        <!-- Back to Articles Button -->
        <div class="col-span-full">
            <a href="{{ route('articles.index') }}"
                class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white transition-all rounded-lg bg-gradient-to-r from-purple-500 to-pink-600 shadow-lg hover:shadow-xl hover:from-purple-600 hover:to-pink-700 transform hover:-translate-y-1">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Articles
            </a>
        </div>

        <!-- Article Header -->
        <div class="max-w-3xl mx-auto mt-8">
            <h1 class="text-4xl font-semibold text-gray-800 dark:text-white">{{ $article->title }}</h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">
                <strong>Penulis:</strong> {{ $article->author ?? 'Tidak Diketahui' }} |
                <strong>Tanggal Terbit:</strong>
                {{ $article->published_at ? $article->published_at->format('d M Y') : 'Belum Diterbitkan' }}
            </p>
        </div>

        <!-- Article Image (Smaller Size) -->
        @if ($article->image_url)
            <div class="mt-6 max-w-3xl mx-auto">
                <img src="{{ $article->image_url }}" alt="Image for {{ $article->title }}"
                    class="w-full max-w-md mx-auto object-cover rounded-lg shadow-md">
            </div>
        @else
            <div class="mt-6 text-center text-gray-500 dark:text-gray-400">Tidak ada gambar untuk artikel ini</div>
        @endif

        <!-- Article Excerpt -->
        @if ($article->excerpt)
            <div class="max-w-3xl mx-auto mt-8 text-gray-700 dark:text-gray-300">
                <h2 class="text-2xl font-semibold">Excerpt:</h2>
                <p>{{ $article->excerpt }}</p>
            </div>
        @endif

        <!-- Article Content -->
        <div class="max-w-3xl mx-auto mt-8 text-gray-700 dark:text-gray-300">
            <div class="prose prose-lg dark:prose-dark">
                <h2 class="text-2xl font-semibold">Content:</h2>
                {!! $article->content !!}
            </div>
        </div>

        <!-- Featured Status -->
        <div class="max-w-3xl mx-auto mt-8">
            <p class="text-lg text-gray-700 dark:text-gray-300">
                <strong>Status Featured:</strong> {{ $article->is_featured ? 'Ya' : 'Tidak' }}
            </p>
        </div>
    </div>
@endsection
