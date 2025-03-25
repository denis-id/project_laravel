@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-8">
        <h1
            class="text-4xl font-extrabold text-center mb-8 bg-gradient-to-r from-black to-blue-600 text-transparent bg-clip-text animate-pulse dark:text-white">
            Users List
        </h1>

        <!-- Display Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 mb-4 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 mb-4 rounded-lg shadow-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Search Form -->
        <div class="flex justify-center mt-4">
            <form method="GET" action="{{ route('users.index') }}"
                class="flex bg-white dark:bg-gray-800 shadow-md rounded-full overflow-hidden border border-gray-300 dark:border-gray-700 max-w-lg w-full">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                    class="w-full p-3 border-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-gray-500 outline-none bg-transparent text-gray-800 dark:text-white">
                <button type="submit"
                    class="bg-blue-500 text-white px-6 py-3 hover:bg-blue-600 transition-all duration-300 rounded-r-full">
                    🔍 Search
                </button>
            </form>
        </div>
        <br>
        <!-- Customer List Table -->
        <div
            class="bg-gradient-to-br from-blue-100 to-blue-300 dark:from-gray-800 dark:to-gray-900 shadow-2xl rounded-2xl overflow-hidden transform transition duration-500 border border-gray-300 dark:border-gray-700">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-400 to-indigo-500 text-white dark:from-gray-700 dark:to-gray-800">
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase">ID</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Name</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Email</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Role</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Created At</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr
                            class="bg-white dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-300">
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
                                {{ $user->role }}</td>
                            <td
                                class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                {{ $user->created_at->format('d M Y H:i') }}</td>
                            <td
                                class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="text-blue-500 hover:text-blue-700 transition-all duration-300">Edit</a>
                                <button class="text-red-500 hover:text-red-700 ml-2 delete-btn transition-all duration-300"
                                    data-id="{{ $user->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Floating Add Button -->
        <a href="{{ route('users.create') }}"
            class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-lg transform hover:scale-110 transition-all duration-300 flex items-center">
            <span class="text-xl font-bold">+</span>
            <span class="ml-2">Add User</span>
        </a>
    </div>
@endsection
