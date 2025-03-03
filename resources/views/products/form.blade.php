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

            <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($product))
                    @method('PUT')
                @endif

                <div class="p-6.5">
                    <!-- Name Field -->
                    <div class="mb-5">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Name
                        </label>
                        <input type="text" placeholder="Name" name="name"
                            value="{{ old('name', $product->name ?? '') }}"
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        @error('name')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price Field -->
                    <div class="mb-5">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Price
                        </label>
                        <div class="relative w-full">
                            <span
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-800 dark:text-white/90">Rp</span>
                            <input type="number" id="price" placeholder="0" name="price"
                                value="{{ old('price', $product->price ?? 0) }}"
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent pl-10 pr-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                            @error('price')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Category Field -->
                    <div class="mb-5">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Category
                        </label>
                        <select name="category_id"
                            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ (isset($product) && $product->category_id == $category->id) || old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Field -->
                    <div class="mb-5">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Active
                        </label>
                        <select name="is_active"
                            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                            <option value="1"
                                {{ (isset($product) && $product->is_active) || old('is_active', 1) == 1 ? 'selected' : '' }}>
                                Yes</option>
                            <option value="0"
                                {{ (isset($product) && !$product->is_active) || old('is_active', 1) == 0 ? 'selected' : '' }}>
                                No</option>
                        </select>
                        @error('is_active')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Variants Section -->
                    <div class="mb-5">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Variants
                        </label>
                        <div id="variants-container">
                            @if (isset($product) && $product->variants->count() > 0)
                                @foreach ($product->variants as $index => $variant)
                                    <div class="variant-item mb-4">
                                        <div class="flex gap-4">
                                            <input type="text" name="variants[{{ $index }}][size]"
                                                placeholder="Size" value="{{ $variant->size }}"
                                                class="dark:bg-dark-900 h-11 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                            <input type="number" name="variants[{{ $index }}][stock]"
                                                placeholder="Stock" value="{{ $variant->stock }}"
                                                class="dark:bg-dark-900 h-11 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                            <button type="button"
                                                class="remove-variant bg-red-500 text-white px-4 py-2 rounded-lg">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="variant-item mb-4">
                                    <div class="flex gap-4">
                                        <input type="text" name="variants[0][size]" placeholder="Size"
                                            class="dark:bg-dark-900 h-11 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                        <input type="number" name="variants[0][stock]" placeholder="Stock"
                                            class="dark:bg-dark-900 h-11 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                        <button type="button"
                                            class="remove-variant bg-red-500 text-white px-4 py-2 rounded-lg">Remove</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-variant" class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-2">Add
                            Variant</button>
                    </div>

                    <!-- Description Field -->
                    <div class="mb-6">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Description
                        </label>
                        <textarea rows="6" placeholder="Description" name="description"
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <center>
                        <button type="submit"
                            class="c-btn h-btn mt-3 py-3 px-5 rounded-pill bg-gradient-to-r from-purple-400 to-pink-500 text-white shadow-lg transform transition duration-500 hover:scale-110 hover:shadow-xl">
                            Submit
                        </button>
                    </center>
                </div>
            </form>
        </div>

        <!-- Image Upload Section -->
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
                        <input type="file" accept="image/*" id="imageUpload" class="hidden" multiple>
                    </div>

                    <div id="imagePreview" class="grid grid-cols-2 gap-5.5 p-6.5">
                        @if (isset($product) && $product->images)
                            @foreach ($product->images as $image)
                                <div class="relative">
                                    <img class="rounded-lg object-cover aspect-square" alt="Image Preview"
                                        src="{{ asset('storage/' . $image) }}" />
                                    <button type="button"
                                        class="delete-image-button bg-red-500 hover:bg-red-500/90 py-2 px-3.5 text-white rounded-full absolute -top-2 -right-2">
                                        <i class="fa-solid fa-x"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
