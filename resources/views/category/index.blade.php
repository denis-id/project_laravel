@extends('layouts.app')

@section('content')
    <div
        class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-lg transition-transform duration-300 hover:scale-105 max-w-full overflow-hidden">
        <div
            class="px-5 py-4 sm:px-6 sm:py-5 bg-gradient-to-r from-blue-500 to-purple-500 rounded-t-2xl flex flex-col sm:flex-row justify-between items-center">
            <h3 class="text-base font-medium text-white mb-4 sm:mb-0">Categories</h3>
            <a href="{{ route('categories.create') }}"
                class="bg-green-500 hover:bg-green-600 text-white font-medium px-4 py-2 rounded-lg shadow-md transition">+
                Add Category</a>
        </div>
        <div class="border-t border-gray-100 p-5 dark:border-gray-800 sm:p-6">
            <div class="max-w-full overflow-x-auto">
                @if (session('success'))
                    <div class="text-green-500">{{ session('success') }}</div>
                @endif
                <table class="min-w-full bg-white dark:bg-gray-900">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Name</th>

                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td class="px-4 py-4 text-sm font-bold text-gray-800 dark:text-white/90">
                                    {{ $category->name }}
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <span
                                        class="rounded-full px-2 py-0.5 text-xs font-medium {{ $category->is_active ? 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500' : 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <form method="POST" class="btn-category-delete"
                                        action="{{ route('categories.destroy', $category->id) }}">
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        •
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-category-delete').on('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure you want to delete this category?',
                    text: 'You will not be able to recover this category.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.value) {
                        this.submit();
                    }
                })
            })
        })
    </script>
@endsection
