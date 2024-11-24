<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            /* Estilos básicos de la página */
            body {
                font-family: 'Figtree', sans-serif;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 800px;
                margin: 0 auto;
                margin-top: 5rem;
                padding: 20px;
                background-color: white;
                border-radius: 1rem;
            }

            .alert-success {
                background-color: #28a745;
                color: white;
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 5px;
            }

            .form-label {
                font-weight: bold;
                margin-bottom: 10px;
                display: block;
            }

            .form-control {
                width: 100%;
                padding: 10px;
                margin-bottom: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-sizing: border-box;
                font-size: 16px;
            }

            .form-control:focus {
                border-color: #5f6368;
                outline: none;
            }

            .btn {
                background-color: #007bff;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .btn:hover {
                background-color: #0056b3;
            }

            
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigationn')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="container py-4"> <!-- Aquí agregué la clase "container" para usar Bootstrap -->
                <h2>Crear Nuevo Producto</h2>
            
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre del Producto:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción:</label>
                        <textarea id="description" name="description" class="form-control" required></textarea>
                    </div>
            
                    <div class="mb-3">
                        <label for="price" class="form-label">Precio:</label>
                        <input type="number" id="price" name="price" class="form-control" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="image" class="form-label">Imagen:</label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                    </div>
            
                    <div>
                        <button type="submit" class="btn btn-primary">Añadir Producto</button>
                    </div>
                </form>



</main>
</body>
</html>
