@extends('layouts.app')
@section('content')
    <div
        class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-lg transition-transform duration-300 hover:scale-105 max-w-full overflow-hidden">
        <div class="px-5 py-4 sm:px-6 sm:py-5 bg-gradient-to-r from-blue-500 to-purple-500 rounded-t-2xl">
            <h3 class="text-base font-medium text-white">Categories</h3>
        </div>
        <div class="border-t border-gray-100 p-5 dark:border-gray-800 sm:p-6">
            <div class="max-w-full overflow-x-auto">
                <div class="min-w-[600px]">

                    <!-- table header start -->
                    <div class="grid grid-cols-4 px-5 py-3 sm:px-6">
                        <div class="flex items-center">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Name</p>
                        </div>
                        <div class="flex items-center">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Description</p>
                        </div>
                        <div class="flex items-center">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Status</p>
                        </div>
                        <div class="flex items-center">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Actions</p>
                        </div>
                    </div>
                    <!-- table header end -->

                    @foreach ($categories as $category)
                        <div class="grid grid-cols-4 border-t border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6">
                            <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                                {{ $category->name }}</p>
                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                {{ $category->description }}</p>
                            <p
                                class="rounded-full px-2 py-0.5 text-theme-xs font-medium {{ $category->is_active ? 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500' : 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </p>
                            <form method="POST" class="btn-category-delete"
                                action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                <a href="{{ route('categories.edit', $category->id) }}"
                                    class="text-blue-600 hover:text-blue-800">Edit</a>
                                •
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>
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
