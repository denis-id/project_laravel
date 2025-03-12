@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-8">
        <h1
            class="text-4xl font-extrabold text-center mb-8 bg-gradient-to-r from-black to-blue-600 text-transparent bg-clip-text animate-pulse dark:text-white">
            User List
        </h1>

        <!-- Display Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Search Form -->
        <div class="mb-8 flex justify-between">
            <form method="GET" action="{{ route('users.index') }}" class="flex">
                <input type="text" name="search" placeholder="Search Users..." value="{{ request('search') }}"
                    class="w-1/3 p-2 rounded-l-2xl border-2 border-blue-400 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-gray-500">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-r-2xl hover:bg-blue-600 transition">Search</button>
            </form>

            <a href="{{ route('users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Add
                User</a>
        </div>

        <!-- User List Table -->
        <div
            class="bg-gradient-to-br from-blue-100 to-blue-300 dark:from-gray-800 dark:to-gray-900 shadow-2xl rounded-2xl overflow-hidden transform hover:scale-105 transition duration-500">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-400 to-indigo-500 text-white dark:from-gray-700 dark:to-gray-800">
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase">ID</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Name</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Email</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Created At</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr
                            class="bg-white dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors duration-300">
                            <td
                                class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                {{ $user->id }}</td>
                            <td
                                class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                {{ $user->name }}</td>
                            <td
                                class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                {{ $user->email }}</td>
                            <td
                                class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                {{ $user->created_at->format('d M Y H:i') }}</td>
                            <td
                                class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="text-blue-500 hover:text-blue-700">Edit</a>
                                <button class="text-red-500 hover:text-red-700 ml-2 delete-btn"
                                    data-id="{{ $user->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- SweetAlert and Axios Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Mengatur CSRF token untuk permintaan AJAX
        axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';

        // Menangani klik tombol delete
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');

                // Menampilkan SweetAlert konfirmasi
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mengirim permintaan DELETE dengan Axios
                        axios.delete(`/admin/users/${userId}`)
                            .then(response => {
                                Swal.fire(
                                    'Deleted!',
                                    'The user has been deleted.',
                                    'success'
                                ).then(() => {
                                    location
                                .reload(); // Reload halaman setelah penghapusan sukses
                                });
                            })
                            .catch(error => {
                                // Menangani error jika terjadi
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the user.',
                                    'error'
                                );
                                console.error(error); // Untuk debugging
                            });
                    }
                });
            });
        });
    </script>
@endsection
