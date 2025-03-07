<!DOCTYPE html>
<html>

<head>
    <title>Product PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        .info {
            margin: 20px auto;
            width: 50%;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }

        .info img {
            display: block;
            margin: 0 auto 20px auto;
            max-width: 100px;
            border-radius: 8px;
        }

        .variant {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Product Details</h1>
    <div class="info">
        <img src="{{ $product->image }}" alt="{{ $product->name }}">
        <p><strong>Name:</strong> {{ $product->name }}</p>
        <p><strong>Status:</strong> {{ $product->is_active ? 'Active' : 'Inactive' }}</p>
        <p><strong>Category:</strong> {{ $product->category->name }} (ID: {{ $product->category->id }})</p>
        <p><strong>Price:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        <p><strong>Description:</strong> {{ $product->description }}</p>

        @foreach ($product->variants as $variant)
            <div class="variant">
                <h3>Variants:</h3>
                <p><strong>Size:</strong> {{ $variant['size'] }}</p>
                <p><strong>Stock:</strong> {{ $variant['stock'] }}</p>
            </div>
        @endforeach
    </div>
</body>

</html>
