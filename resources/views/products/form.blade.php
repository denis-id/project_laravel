@extends('layouts.app')
@section('content')
    <div class="gap-6 grid grid-cols-1 sm:grid-cols-2">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3
                    class="text-xl font-semibold bg-gradient-to-r from-purple-400 to-pink-500 text-transparent bg-clip-text dark:text-white/90">
                    Products Form
                </h3>
            </div>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6.5">
                    <div class="mb-5 flex flex-col gap-6 xl:flex-row">
                        <div class="w-full xl:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Name
                            </label>
                            <input type="text" placeholder="Name" name="name" value="{{ old('name') }}"
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                            @error('name')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full xl:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Price
                            </label>
                            <input type="text" id="price" placeholder="Rp 0" name="price"
                                value="{{ 'Rp ' . number_format($product->price ?? old('price'), 0, ',', '.') }}"
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                                oninput="formatRupiah(this)">
                        </div>
                    </div>

                    <div class="mb-5.5 flex flex-col gap-6 xl:flex-row">
                        <div class="w-full xl:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Variant
                            </label>
                            <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent dark:bg-form-input">
                                <select name="variant_name"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                    <option value="">Select Variant</option>
                                    @foreach ($variants as $variantName => $size)
                                        <option value="{{ $variantName }}"
                                            {{ isset($product) && $product->variants->first()->variant_name == $variantName ? 'selected' : '' }}>
                                            {{ $variantName }} ({{ $size }})
                                        </option>
                                    @endforeach
                                </select>
                                <span class="absolute right-4 top-1/2 z-30 -translate-y-1/2">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g opacity="0.8">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                fill=""></path>
                                        </g>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="w-full xl:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Active
                            </label>
                            <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent dark:bg-form-input">
                                <select name="is_active"
                                    class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                    <option value="1"
                                        {{ (isset($product) ? $product->is_active : old('active', 1)) == 1 ? 'selected' : '' }}
                                        class="text-body">Yes</option>
                                    <option value="0"
                                        {{ (isset($product) ? $product->is_active : old('active', 1)) == 0 ? 'selected' : '' }}
                                        class="text-body">No</option>

                                </select>
                                <span class="absolute right-4 top-1/2 z-30 -translate-y-1/2">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g opacity="0.8">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                fill=""></path>
                                        </g>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5.5">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Stock
                        </label>
                        <input type="number" placeholder="Stock" name="stock"
                            value="{{ $productVariant->stock ?? old('stock') }}"
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                    </div>

                    <div class="mb-5.5">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Category
                        </label>
                        <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent dark:bg-form-input">
                            <select name="category_id"
                                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">

                                @foreach ($categories as $category)
                                    <option
                                        {{ $product->category_id ?? old('category_id') == $category->id ? 'selected' : '' }}
                                        value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                            <span class="absolute right-4 top-1/2 z-30 -translate-y-1/2">
                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g opacity="0.8">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                            fill=""></path>
                                    </g>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Description
                        </label>
                        <textarea rows="6" placeholder="Description" name="description"
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">{{ $product->description ?? old('description') }}</textarea>
                    </div>
                    <center>
                        <button type="submit"
                            class="c-btn h-btn mt-3 py-3 px-5 rounded-pill bg-gradient-to-r from-purple-400 to-pink-500 text-white shadow-lg transform transition duration-500 hover:scale-110 hover:shadow-xl">
                            Submit
                        </button>
                    </center>
                </div>
            </form>
        </div>
        <div class="flex flex-col gap-5">
            <div>
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div
                        class="border-b border-stroke px-6.5 py-4 flex items-center justify-between dark:border-strokedark">
                        <h3 class="font-medium text-black dark:text-white">
                            Images
                        </h3>
                        <button id="addImageBtn"
                            class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">Add
                            Image</button>
                    </div>

                    <div>
                        <input type="file" accept="image/*" id="imageUpload" class="hidden">
                    </div>

                    <div id="imagePreview" class="grid grid-cols-2 gap-5.5 p-6.5">

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection

<script>
    function formatRupiah(input) {
        let value = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
        let formatted = new Intl.NumberFormat('id-ID').format(value); // Format as Rupiah
        input.value = value ? 'Rp ' + formatted : ''; // Add 'Rp' prefix
    }
</script>

@section('scripts')
    <script>
        $(document).ready(function() {
            const token = document.head.querySelector('meta[name="csrf-token"]').content;
            const variants = [];
            const deleteImageArray = [];
            const newImages = [];

            // Image Upload and Preview
            $('#addImageBtn').click(() => $('#imageUpload').click());

            $('#imageUpload').change(event => {
                const files = event.target.files;
                if (files) {
                    Array.from(files).forEach(file => newImages.push(file));
                    displayImages();
                }
            });

            function displayImages() {
                $('#imagePreview').empty();
                if (!newImages.length) {
                    $('#imagePreview').append('<p class="text-center w-full">No images uploaded</p>');
                    return;
                }

                newImages.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = e => $('#imagePreview').append(`
                    <div class="relative">
                        <img class="rounded-lg object-cover aspect-square" alt="Image Preview" src="${e.target.result}" />
                        <button data-index="${index}" class="delete-image-button bg-red-500 hover:bg-red-500/90 py-2 px-3.5 text-white rounded-full absolute -top-2 -right-2">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </div>
                `);
                    reader.readAsDataURL(file);
                });
            }

            // Delete Image
            $(document).on('click', '.delete-image-button', function() {
                const index = $(this).data('index');
                newImages.splice(index, 1);
                displayImages();
            });

            // Form Submission
            $('#productForm').submit(function(event) {
                event.preventDefault();
                const formData = new FormData(this);

                // Append new images
                newImages.forEach((file, index) => {
                    formData.append('new_images[]', file);
                });

                // Append deleted images
                deleteImageArray.forEach(image => {
                    formData.append('deleted_images[]', image);
                });

                // Submit via AJAX
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire('Success', response.message, 'success').then(() => {
                            window.location.href = '{{ route('products.index') }}';
                        });
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        $('.error-message').remove();
                        $.each(errors, function(key, value) {
                            $(`[name="${key}"]`).after(
                                `<p class="error-message text-red-500">${value[0]}</p>`
                            );
                        });
                    }
                });
            });

            window.deleteImages = (index, type) => {
                type === 'old' ? deleteImageArray.push(images.splice(index, 1)[0]) : newImages.splice(index,
                    1);
                displayImages();
            };

            displayImages();
            renderInputSize()
        });
    </script>
@endsection
