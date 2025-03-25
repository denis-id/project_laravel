@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-4 px-4 relative">
        <h1
            class="text-4xl font-extrabold text-center mb-8 bg-gradient-to-r from-black to-blue-600 text-transparent bg-clip-text animate-pulse dark:text-white">
            Articles List</h1>
        <br>
        <!-- Search Bar -->
        <form method="GET" action="{{ route('articles.index') }}" class="mb-4 flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}"
                class="w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-white dark:border-gray-600"
                placeholder="Search Articles...">
            <button type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-600 transition">
                Search
            </button>
        </form>
        @if ($articles->isEmpty())
            <div
                class="mt-4 p-4 bg-yellow-100 text-yellow-700 border border-yellow-300 rounded-lg dark:bg-yellow-900 dark:text-yellow-400">
                No Articles Found.
            </div>
        @else
            <div class="overflow-x-auto mt-6">
                <table class="w-full table-auto border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg">
                    <thead>
                        <tr class="bg-blue-500 text-white dark:bg-blue-800">
                            <th class="px-4 py-3 text-left text-sm font-semibold">No</th>
                            <th class="px-4 py-3 w 1/6 text-left text-sm font-semibold">Image</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Title</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Slug</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Author</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Publish Date</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Featured</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Content</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $index => $article)
                            <tr
                                class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 w 1/6">
                                    @if ($article->image_url)
                                        <img src="{{ $article->image_url }}" alt="Image for {{ $article->title }}"
                                            class="w-14 h-14 object-cover rounded-md border border-gray-300 dark:border-gray-600">
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">No Image</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-300">{{ $article->title }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-300">{{ $article->slug }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-300">
                                    {{ $article->author ?? 'Tidak Diketahui' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-300">
                                    {{ $article->published_at ? $article->published_at->format('d M Y') : 'Belum Diterbitkan' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-300">
                                    {{ $article->is_featured ? 'Yes' : 'No' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-300 max-w-xs">
                                    <div
                                        class="h-16 overflow-y-auto p-2 border border-gray-300 dark:border-gray-600 rounded bg-gray-50 dark:bg-gray-800">
                                        {{ Str::limit($article->content, 100, '...') }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm flex space-x-2">
                                    <a href="{{ route('articles.show', $article->id) }}"
                                        class="text-blue-500 hover:text-blue-700 transition">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('articles.edit', $article->id) }}"
                                        class="text-yellow-500 hover:text-yellow-700 transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <a href="{{ route('articles.create') }}"
            class="fixed bottom-4 right-6 hover:scale-105 px-5 py-3 bg-green-500 text-white rounded-full shadow-lg hover:bg-green-600 dark:bg-green-700 dark:hover:bg-green-600 transition">
            + Add New Article
        </a>
    </div>
@endsection
