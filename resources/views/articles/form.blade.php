@extends('layouts.app')

@section('content')

    <div class="col-span-full">
        <a href="{{ route('articles.index') }}"
            class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white transition-all rounded-lg bg-gradient-to-r from-purple-500 to-pink-600 shadow-lg hover:shadow-xl hover:from-purple-600 hover:to-pink-700 transform hover:-translate-y-1">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Articles
        </a>
    </div>

    <h1 class="text-2xl font-semibold text-center mb-6 text-gray-900 dark:text-white">
        {{ isset($article) ? 'Edit' : 'Create' }} Articles</h1>

    <!-- Menampilkan pesan error jika ada -->
    @if ($errors->any())
        <div
            class="bg-red-100 text-red-700 border border-red-300 p-4 rounded mb-6 dark:bg-red-900 dark:text-red-300 dark:border-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($article) ? route('articles.update', $article->id) : route('articles.store') }}" method="POST">
        @csrf
        @if (isset($article))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
            <input type="text" id="slug" name="slug" value="{{ old('slug', $article->slug ?? '') }}" required
                class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">
        </div>

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $article->title ?? '') }}" required
                class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">
        </div>

        <div class="mb-4">
            <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image URL</label>
            <input type="text" id="image_url" name="image_url" value="{{ old('image_url', $article->image_url ?? '') }}"
                class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">
        </div>

        <div class="mb-4">
            <label for="keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keywords</label>
            <input type="text" id="keywords" name="keywords" value="{{ old('keywords', $article->keywords ?? '') }}"
                class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">
        </div>

        <div class="mb-4">
            <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta
                Description</label>
            <input type="text" id="meta_description" name="meta_description"
                value="{{ old('meta_description', $article->meta_description ?? '') }}"
                class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">
        </div>

        <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
            <textarea id="content" name="content" rows="5" required
                class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">{{ old('content', $article->content ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Excerpt</label>
            <textarea id="excerpt" name="excerpt" rows="3"
                class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date Of
                Issue</label>
            <input type="datetime-local" id="published_at" name="published_at"
                value="{{ old('published_at', isset($article) ? $article->published_at->format('Y-m-d\TH:i') : '') }}"
                class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">
        </div>

        <div class="mb-4">
            <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Author</label>
            <input type="text" id="author" name="author" value="{{ old('author', $article->author ?? '') }}"
                class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">
        </div>

        <div class="mb-4 flex items-center">
            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                {{ old('is_featured', $article->is_featured ?? false) ? 'checked' : '' }}
                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">
            <label for="is_featured" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Show as
                Featured</label>
        </div>

        <div class="mb-4">
            <label for="read_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Read Time
                (menit)</label>
            <input type="number" id="read_time" name="read_time" value="{{ old('read_time', $article->read_time ?? '') }}"
                class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">
        </div>

        <button type="submit"
            class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 dark:bg-indigo-700 dark:hover:bg-indigo-600">
            {{ isset($article) ? 'Update' : 'Save' }} Article
        </button>
    </form>
    </div>
@endsection
