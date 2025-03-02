@extends('layouts.app')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2
            class="text-xl font-semibold bg-gradient-to-r from-purple-400 to-pink-500 text-transparent bg-clip-text dark:text-white/90">
            Category Form</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-pink-500 transition duration-300 dark:text-gray-400"
                        href="index.html">
                        Category
                        <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="currentColor" stroke-width="1.2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90">Create</li>
            </ol>
        </nav>
    </div>

    <div class="flex items-center justify-center">
        <div class="w-full max-w-lg space-y-6">
            <div
                class="rounded-2xl border border-gray-200 bg-gradient-to-br from-blue-50 to-purple-100 dark:border-gray-800 dark:bg-white/[0.03] shadow-lg transform transition duration-500 hover:scale-105">
                <form
                    action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}"
                    method="POST" class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @csrf
                    @if (isset($category))
                        @method('PUT')
                    @endif
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Name</label>
                        <input value="{{ isset($category) ? $category->name : old('name') }}" name="name" type="text"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm  shadow-lg placeholder:text-gray-400 focus:border-pink-300 focus:outline-none focus:ring focus:ring-pink-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-sm font-medium text-black dark:text-white"
                            placeholder="name">
                        @error('name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Is Active</label>
                        <select name="is_active"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-lg placeholder:text-gray-400 focus:border-pink-300 focus:outline-none focus:ring focus:ring-pink-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-pink-800">
                            <option value="1"
                                {{ (isset($category) && $category->is_active == 1) || old('is_active') == 1 ? 'selected' : '' }}>
                                Active</option>
                            <option value="0"
                                {{ (isset($category) && $category->is_active == 0) || old('is_active') == 0 ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Description</label>
                        <textarea name="description" placeholder="Enter a description..." rows="6"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-lg placeholder:text-gray-400 focus:border-pink-300 focus:outline-none focus:ring focus:ring-pink-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-pink-800">{{ old('description', $category->description ?? '') }}</textarea>
                    </div>

                    <center>
                        <button type="submit"
                            class="c-btn h-btn mt-3 py-3 px-5 rounded-pill bg-gradient-to-r from-purple-400 to-pink-500 text-white shadow-lg transform transition duration-500 hover:scale-110 hover:shadow-xl">
                            Submit
                        </button>
                    </center>
                </form>
            </div>
        </div>
    </div>
@endsection
