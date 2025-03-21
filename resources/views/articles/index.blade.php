@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-4 px-4 relative">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">Daftar Artikel</h1>

        @if ($articles->isEmpty())
            <div
                class="mt-4 p-4 bg-yellow-100 text-yellow-700 border border-yellow-300 rounded-lg dark:bg-yellow-900 dark:text-yellow-400">
                No Articles Found.
            </div>
        @else
            <table class="w-full mt-6 table-auto border-collapse border border-gray-200 dark:border-gray-700">
                <thead>
                    <tr class="bg-blue-200 dark:bg-blue-900">
                        <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-200">No</th>
                        <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Image</th>
                        <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Title</th>
                        <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Slug</th>
                        <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Author</th>
                        <th class="px-2 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Publish Date
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Featured
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Content</th>
                        <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-200">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $index => $article)
                        <tr class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-300">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-300">
                                @if ($article->image_url)
                                    <img src="{{ $article->image_url }}" alt="Image for {{ $article->title }}"
                                        class="w-16 h-16 object-cover rounded-md">
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">No Image</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-300">{{ $article->title }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-300">{{ $article->slug }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-300">
                                {{ $article->author ?? 'Tidak Diketahui' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-300">
                                {{ $article->published_at ? $article->published_at->format('d M Y') : 'Belum Diterbitkan' }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-300">
                                {{ $article->is_featured ? 'Yes' : 'No' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-300 max-w-xs overflow-hidden">
                                <div
                                    class="h-16 overflow-y-auto p-2 border border-gray-300 dark:border-gray-600 rounded bg-gray-50 dark:bg-gray-800">
                                    {{ $article->content }}
                                </div>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-300 flex space-x-2">
                                <a href="{{ route('articles.show', $article->id) }}"
                                    class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('articles.edit', $article->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('articles.create') }}"
            class="absolute top-4 right-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 dark:bg-green-700 dark:hover:bg-green-600">
            + Add New Article
        </a>
    </div>
@endsection
