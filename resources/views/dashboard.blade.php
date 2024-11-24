<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">Catálogo de Productos</h3>

                    <div class="product-container">
                        @foreach ($products as $product)
                            <div class="product-card">
                                <!-- Imagen del producto -->
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-image">
                                

                                <div class="product-body">
                                    <h5 class="product-title">{{ $product->name }}</h5>
                                    <p class="product-description text-muted">{{ $product->description }}</p>
                                    <p class="product-price">{{ '$' . number_format($product->price, 2) }}</p>

                                    <!-- Formulario para agregar al carrito -->
                                    <form action="{{ route('addToCart') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="name" value="{{ $product->name }}">
                                        <input type="hidden" name="price" value="{{ $product->price }}">
                                        <input type="hidden" name="image" value="{{ $product->image_path }}">

                                        <div class="mb-3" style="color: black">
                                            <label for="quantity-{{ $product->id }}" class="form-label">Cantidad</label>
                                            <input type="number" id="quantity-{{ $product->id }}" name="quantity" class="form-control" value="1" min="1" required>
                                        </div>

                                        <!-- Botón para agregar al carrito -->
                                        <button type="submit" class="add-to-cart-btn">
                                            Agregar al carrito
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .product-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .product-card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .product-body {
        padding: 16px;
    }

    .product-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .product-description {
        color: #555;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
    }

    .add-to-cart-btn {
        margin-top: 12px;
        padding: 8px 16px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .add-to-cart-btn:hover {
        background-color: #0056b3;
    }

    .form-control {
        color: #000; /* Número en color negro */
        padding: 10px;
        width: 100%;
        margin-top: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .form-control:focus {
        border-color: #007bff;
        outline: none;
    }

    .product-title{
        color: black;
    }
</style>
