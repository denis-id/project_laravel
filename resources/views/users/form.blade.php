@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-8">
        <h1
            class="text-4xl font-extrabold text-center mb-8 bg-gradient-to-r from-black to-blue-600 text-transparent bg-clip-text animate-pulse dark:text-white">
            {{ isset($user) ? 'Edit User' : 'Tambah User' }}
        </h1>

        <div
            class="bg-gradient-to-br from-blue-100 to-blue-300 dark:from-gray-800 dark:to-gray-900 shadow-2xl rounded-2xl p-8 transform hover:scale-105 transition duration-500">
            <form id="user-form" method="POST"
                action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required
                        class="w-full p-3 rounded-2xl border-2 border-blue-400 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-gray-500">
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}"
                        required
                        class="w-full p-3 rounded-2xl border-2 border-blue-400 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-gray-500">
                </div>

                <div class="mb-6 relative">
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-3 rounded-2xl border-2 border-blue-400 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-gray-500">
                    <span onclick="togglePassword('password')" class="absolute right-4 top-10 cursor-pointer">👁️</span>
                    @if (isset($user))
                        <small class="text-gray-500 dark:text-gray-400">*Harus diisi jika ingin mengubah data, sesuaikan
                            dengan password awal saat dibuat</small>
                    @endif
                    <div id="password-strength" class="text-sm mt-2"></div>
                </div>

                <div class="mb-6 relative">
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full p-3 rounded-2xl border-2 border-blue-400 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-gray-500">
                    <span onclick="togglePassword('password_confirmation')"
                        class="absolute right-4 top-10 cursor-pointer">👁️</span>
                    <div id="password-match" class="text-sm mt-2"></div>
                </div>

                <div class="flex justify-center space-x-4">
                    <a href="{{ route('users.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">Batal</a>
                    <button type="button" onclick="submitForm()"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">{{ isset($user) ? 'Update' : 'Simpan' }}</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.0/sweetalert2.all.min.js"></script>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }

        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthEl = document.getElementById('password-strength');

            if (password.length > 15) {
                strengthEl.textContent = 'Kekuatan: Kuat';
                strengthEl.className = 'text-green-500';
            } else if (password.length > 10) {
                strengthEl.textContent = 'Kekuatan: Sedang';
                strengthEl.className = 'text-yellow-500';
            } else if (password.length > 0) {
                strengthEl.textContent = 'Kekuatan: Lemah';
                strengthEl.className = 'text-red-500';
            } else {
                strengthEl.textContent = '';
            }
        });

        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;

            const matchEl = document.getElementById('password-match');

            if (password === confirmPassword && confirmPassword !== '') {
                matchEl.textContent = 'Password cocok';
                matchEl.className = 'text-green-500';
            } else {
                matchEl.textContent = 'Password tidak cocok';
                matchEl.className = 'text-red-500';
            }
        });

        function submitForm() {
            const form = document.getElementById('user-form');
            const formData = new FormData(form);
            console.log(...formData);

            fetch(form.action, {
                    method: form.method,
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire('Berhasil!', 'Data pengguna berhasil disimpan.', 'success').then(() => {
                        window.location.href = '{{ route('users.index') }}';
                    });
                })
                .catch(() => {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan data.', 'error');
                });
        }
    </script>
@endsection
