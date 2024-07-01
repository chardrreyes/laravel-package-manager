<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Package Manager</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        /* I know Laravel uses tailwind style class, 
        but it might take me some time for refresher, so I just use css  */
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            line-height: 1.5;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        h1 {
            font-size: 2rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            font-size: 1rem;
        }
        button {
            background-color: #2563eb;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1d4ed8;
        }
        .error-list {
            background-color: #fee2e2;
            border: 1px solid #f87171;
            border-radius: 0.25rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .error-list ul {
            margin: 0;
            padding-left: 1rem;
        }
        .result {
            margin-top: 2rem;
            padding: 1rem;
            background-color: #ecfdf5;
            border: 1px solid #10b981;
            border-radius: 0.25rem;
        }
        .item {
            border: 1px solid #e5e7eb;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pack Boxes</h1>
        <form action="{{ route('box-pack.pack') }}" method="POST">
            @csrf
            <div id="items">
                <div class="item">
                    <div class="form-group">
                        <label for="product1_name">Product 1 Name:</label>
                        <input type="text" id="name" name="items[0][name]" required>
                    </div>
                    <div class="form-group">
                        <label for="product1_length">Length:</label>
                        <input type="number" id="length" name="items[0][length]" required>
                    </div>
                    <div class="form-group">
                        <label for="product1_width">Width:</label>
                        <input type="number" id="width" name="items[0][width]" required>
                    </div>
                    <div class="form-group">
                        <label for="product1_height">Height:</label>
                        <input type="number" id="height" name="items[0][height]" required>
                    </div>
                    <div class="form-group">
                        <label for="product1_weight">Weight:</label>
                        <input type="number" step="0.1" id="weight" name="items[0][weight]" required>
                    </div>
                    <div class="form-group">
                        <label for="product1_quantity">Quantity:</label>
                        <input type="number" id="quantity" name="items[0][quantity]" required>
                    </div>
                </div>
            </div>
            
            <button type="button" onclick="addProduct()">Add Product</button>
            <button type="submit">Pack Boxes</button>
        </form>

        @if ($errors->any())
            <div class="error-list">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (isset($result))
            <div class="result">
                <h2>Results</h2>
                @if (isset($result['error']))
                    <p>{{ $result['error'] }}</p>
                @else
                    @foreach ($result as $packedBox)
                        <p>Box: {{ $packedBox['box'] }}</p>
                        <ul>
                            @foreach ($packedBox['products'] as $productKey)
                                <li>Product {{ $productKey }}</li>
                            @endforeach
                        </ul>
                    @endforeach
                @endif
            </div>
        @endif
    </div>

    <script>
        let productIndex = 1;
        function addProduct() {
            productIndex++;
            const productsDiv = document.getElementById('items');
            const productDiv = document.createElement('div');
            productDiv.className = 'item';
            productDiv.innerHTML = `
                <div class="form-group">
                    <label for="product${productIndex}_name">Product ${productIndex} Name:</label>
                    <input type="text" id="name" name="items[${productIndex-1}][name]" required>
                </div>
                <div class="form-group">
                    <label for="product${productIndex}_length">Length:</label>
                    <input type="number" id="length" name="items[${productIndex-1}][length]" required>
                </div>
                <div class="form-group">
                    <label for="product${productIndex}_width">Width:</label>
                    <input type="number" id="width" name="items[${productIndex-1}][width]" required>
                </div>
                <div class="form-group">
                    <label for="product${productIndex}_height">Height:</label>
                    <input type="number" id="height" name="items[${productIndex-1}][height]" required>
                </div>
                <div class="form-group">
                    <label for="product${productIndex}_weight">Weight:</label>
                    <input type="number" step="0.1" id="weight" name="items[${productIndex-1}][weight]" required>
                </div>
                <div class="form-group">
                    <label for="product${productIndex}_quantity">Quantity:</label>
                    <input type="number" id="quantity" name="items[${productIndex-1}][quantity]" required>
                </div>
            `;
            productsDiv.appendChild(productDiv);
        }
    </script>
</body>
</html>