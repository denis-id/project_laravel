@extends('layouts.app')

@section('content')
    <div
        class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-lg max-w-lg mx-auto overflow-hidden">
        <div class="px-5 py-4 sm:px-6 sm:py-5 bg-gradient-to-r from-blue-500 to-purple-500 rounded-t-2xl text-center">
            <h3 class="text-base font-medium text-white">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h3>
        </div>
        <div class="p-5 dark:bg-gray-900">
            @if ($errors->any())
                <div class="text-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST"
                action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}">
                @csrf
                @if (isset($category))
                    @method('PUT')
                @endif
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category
                        Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm"
                        required placeholder="category name">
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <label for="is_active" class="inline-flex items-center">
                        <select id="is_active" name="is_active"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm">
                            <option value="1"
                                {{ old('is_active', $category->is_active ?? '') == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0"
                                {{ old('is_active', $category->is_active ?? '') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </label>
                </div>
                <div class="text-center">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium px-4 py-2 rounded-lg shadow-md transition">
                        {{ isset($category) ? 'Update' : 'Create' }}
                    </button>
                    <a href="{{ route('categories.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded-lg shadow-md transition ml-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
