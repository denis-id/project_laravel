@extends('layouts.app')
@section('content')

    <div class="gap-6 grid grid-cols-1 sm:grid-cols-2">
        <!-- Tombol Back to Products -->
        <div class="col-span-full">
            <a href="{{ route('products.index') }}"
                class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white transition-all rounded-lg bg-gradient-to-r from-purple-500 to-pink-600 shadow-lg hover:shadow-xl hover:from-purple-600 hover:to-pink-700 transform hover:-translate-y-1">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Products
            </a>
        </div>

        <!-- Form Section -->
        <div
            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3
                    class="text-2xl font-bold bg-gradient-to-r from-purple-500 to-pink-600 text-transparent bg-clip-text dark:text-white/90">
                    Products Form
                </h3>
            </div>

            @if (session('error'))
                <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

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
                        <input value="{{ old('name', $product->name ?? '') }}" type="text" name="name"
                            placeholder="Product Name"
                            class="dark:bg-gray-800 h-12 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-purple-500 focus:ring focus:ring-purple-500/20 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-purple-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price Field -->
                    {{-- <div class="mb-5">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Price
                        </label>
                        <div class="relative w-full">
                            <span
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-800 dark:text-white/90">Rp</span>
                            <input type="number" id="price" placeholder="0" name="price"
                                value="{{ $product->price ?? '' }}"
                                class="dark:bg-gray-800 h-12 w-full rounded-lg border border-gray-300 bg-transparent pl-10 pr-4 py-3 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-purple-500 focus:ring focus:ring-purple-500/20 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-purple-500">
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div> --}}

                    <!-- Category Field -->
                    <div class="mb-5">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Category
                        </label>
                        <select name="category_id"
                            class="dark:bg-gray-800 h-12 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-3 pr-11 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-purple-500 focus:ring focus:ring-purple-500/20 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-purple-500">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ (isset($product) && $product->category_id == $category->id) || old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Field -->
                    <div class="mb-5">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Active
                        </label>
                        <select name="is_active"
                            class="dark:bg-gray-800 h-12 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-3 pr-11 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-purple-500 focus:ring focus:ring-purple-500/20 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-purple-500">
                            <option value="1"
                                {{ (isset($product) && $product->is_active) || old('is_active', 1) == 1 ? 'selected' : '' }}>
                                Yes</option>
                            <option value="0"
                                {{ (isset($product) && !$product->is_active) || old('is_active', 1) == 0 ? 'selected' : '' }}>
                                No</option>
                        </select>
                        @error('is_active')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
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
                                                class="dark:bg-gray-800 h-12 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-purple-500 focus:ring focus:ring-purple-500/20 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-purple-500">
                                            <input type="number" name="variants[{{ $index }}][stock]"
                                                placeholder="Stock" value="{{ $variant->stock }}"
                                                class="dark:bg-gray-800 h-12 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-purple-500 focus:ring focus:ring-purple-500/20 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-purple-500">
                                            <input type="number" placeholder="Rp" id="price"
                                                name="variants[{{ $index }}][price]" value="{{ $variant->price }}"
                                                class="dark:bg-gray-800 h-12 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-purple-500 focus:ring focus:ring-purple-500/20 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-purple-500">
                                            <button type="button"
                                                class="remove-variant bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-200">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="variant-item mb-4">
                                    <div class="flex gap-4">
                                        <input type="text" name="variants[0][size]" placeholder="Size"
                                            class="dark:bg-gray-800 h-12 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-purple-500 focus:ring focus:ring-purple-500/20 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-purple-500">
                                        <input type="number" name="variants[0][stock]" placeholder="Stock"
                                            class="dark:bg-gray-800 h-12 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-purple-500 focus:ring focus:ring-purple-500/20 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-purple-500">
                                        <input type="number" id="price" name="variants[0][price]" placeholder="Rp"
                                            class="dark:bg-gray-800 h-12 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-purple-500 focus:ring focus:ring-purple-500/20 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-purple-500">
                                        <button type="button"
                                            class="remove-variant bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-200">Remove</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-variant"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-2 hover:bg-blue-600 transition-colors duration-200">Add
                            Variant</button>
                    </div>

                    <!-- Description Field -->
                    <div class="mb-6">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Description
                        </label>
                        <textarea rows="6" placeholder="Description" name="description"
                            class="dark:bg-gray-800 h-12 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-purple-500 focus:ring focus:ring-purple-500/20 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-purple-500">{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload Section -->
                    <div class="flex flex-col gap-5">
                        <div>
                            <div
                                class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-lg hover:shadow-2xl transition-shadow duration-300 ease-in-out transform hover:scale-105">
                                <div
                                    class="border-b border-stroke px-6.5 py-4 flex items-center justify-between dark:border-strokedark">
                                    <h3 class="font-medium text-black dark:text-white text-lg tracking-wide">
                                        Add Images
                                    </h3>
                                </div>

                                <div class="flex justify-center py-6">
                                    <label for="imageUpload"
                                        class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105">
                                        Choose Images
                                    </label>
                                    <input type="file" accept="image/*" id="imageUpload" name="images[]" class="hidden"
                                        multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="imagePreview" class="grid grid-cols-2 gap-5.5 p-6.5">
                        @if (isset($product) && $product->images)
                            @foreach ($product->images as $image)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $image) }}"
                                        class="rounded-lg object-cover aspect-square" alt="Product Image" width="100">
                                    <button type="button"
                                        class="delete-image-button bg-red-500 hover:bg-red-600 py-2 px-3.5 text-white rounded-full absolute -top-2 -right-2 transition-colors duration-200">
                                        <i class="fa-solid fa-x"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button type="submit"
                            class="c-btn h-btn mt-6 py-3 px-6 rounded-lg bg-gradient-to-r from-purple-500 to-pink-600 text-white shadow-lg transform transition-all duration-500 hover:scale-105 hover:shadow-xl">
                            Submit
                        </button>
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addVariantBtn = document.getElementById('add-variant');
            const variantsContainer = document.getElementById('variants-container');

            let variantIndex = document.querySelectorAll('.variant-item').length;

            addVariantBtn.addEventListener('click', function() {
                addVariant();
            });

            variantsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variant')) {
                    e.target.closest('.variant-item').remove();
                }
            });

            function addVariant() {
                const variantHtml = `
              <div class="variant-item mb-4">
                <div class="flex gap-4">
                    <input type="text" name="variants[${variantIndex}][size]" placeholder="Size" class="dark:bg-dark-900 h-11 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                    <input type="number" name="variants[${variantIndex}][stock]" placeholder="Stock" class="dark:bg-dark-900 h-11 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                    <input type="number" name="variants[${variantIndex}][price]" placeholder="Rp" class="dark:bg-dark-900 h-11 w-1/2 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                    <button type="button" class="remove-variant bg-red-500 text-white px-4 py-2 rounded-lg">Remove</button>
                </div>
            </div>
        `;
                variantsContainer.insertAdjacentHTML('beforeend', variantHtml);
                variantIndex++;
            }

            // Image Upload and Preview
            const newImages = [];
            const deleteImageArray = [];

            document.getElementById('imageUpload').addEventListener('change', function(event) {
                const files = event.target.files;
                if (files) {
                    Array.from(files).forEach(file => newImages.push(file));
                    displayImages();
                }
            });

            function displayImages() {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.innerHTML = '';
                if (!newImages.length) {
                    imagePreview.innerHTML = '<p class="text-center w-full">No images uploaded</p>';
                    return;
                }

                newImages.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageHtml = `
                    <div class="relative">
                        <img class="rounded-lg object-cover aspect-square" alt="Image Preview" src="${e.target.result}" />
                        <button data-index="${index}" class="delete-image-button bg-red-500 hover:bg-red-600 py-2 px-3.5 text-white rounded-full absolute -top-2 -right-2">&times;</button>
                    </div>
                `;
                        imagePreview.insertAdjacentHTML('beforeend', imageHtml);
                    };
                    reader.readAsDataURL(file);
                });
            }

            document.getElementById('imagePreview').addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-image-button')) {
                    const index = e.target.getAttribute('data-index');
                    newImages.splice(index, 1);
                    displayImages();
                }
            });

            // Form Submission
            const productForm = document.getElementById('productForm');
            if (productForm) {
                productForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const formData = new FormData(productForm);

                    newImages.forEach(file => formData.append('new_images[]', file));
                    deleteImageArray.forEach(image => formData.append('deleted_images[]', image));

                    fetch(productForm.getAttribute('action'), {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire('Success', data.message, 'success').then(() => {
                                window.location.href = data.redirect;
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            }
        });
    </script>
@endsection
