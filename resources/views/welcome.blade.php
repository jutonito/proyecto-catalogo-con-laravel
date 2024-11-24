<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <!-- Puedes agregar aquí tu propio CSS si es necesario -->
        @endif

        <!-- Estilos personalizados -->
        <style>
            /* Cambiar color del fondo general */
            body {
                background-color: #111827; /* Fondo oscuro para el cuerpo */
            }

            /* Cambiar color del header */
            header {
                background-color: #333; /* Fondo oscuro para el header */
            }

            /* Cambiar color de la barra de navegación */
            .navbar {
                background-color: #1f2937; /* Color de fondo azul */
            }

            .navbar-brand {
                color: #1f2937; /* Texto blanco en el logo */
            }

            .navbar-light .navbar-nav .nav-link {
                color: #ffffff; /* Enlaces de la navegación en blanco */
            }

            .navbar-light .navbar-nav .nav-link:hover {
                color: #999999; /* Enlaces en amarillo al pasar el mouse */
            }

            /* Cambiar color de los enlaces de login y register */
            .nav-link {
                color: #cbcdd6; /* Color de texto para login y register */
            }

            .nav-link:hover {
                color: #999999; /* Color de texto al pasar el mouse */
            }

            /* Cambiar color del contenedor del catálogo */
            .container.bg-slate-600 {
                background-color: #1f2937; /* Fondo gris oscuro */
            }

            /* Cambiar colores de los botones */
            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
            }

            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #004085;
            }
        </style>
    </head>
    <body class="bg-slate-500">
        <header>
            <!-- Barra de navegación de Bootstrap -->
            <nav class="navbar navbar-expand-lg navbar-light ">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">( ͡👁️ ͜ʖ ͡👁️)</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            @if (Route::has('login'))
                                @auth
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">Log in</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                                        </li>
                                    @endif
                                @endauth
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Contenido principal -->
        <main class="mt-6">
            
            <h1 class="h3 text-center mb-4 text-white">Catálogo de Productos</h1>
            <!-- Contenedor con fondo blanco, borde, márgenes y centrado -->
            <div class="container bg-slate-600 border rounded-3 shadow-sm py-4 px-4 my-4 mx-auto">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach ($products as $product)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-muted">{{ $product->description }}</p>
                                    <p class="h5">{{ '$' . number_format($product->price, 2) }}</p>

                                    <!-- Formulario para agregar al carrito -->
                                    
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        <!-- Input para la cantidad -->
                                        <div class="mb-3">
                                            <label for="quantity-{{ $product->id }}" class="form-label">Cantidad</label>
                                            <input type="number" name="quantity" id="quantity-{{ $product->id }}" class="form-control" value="1" min="1" required>
                                        </div>
                                        <a class="nav-link" href="{{ route('login') }}">
                                        <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                                        </a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </main>

        <!-- Bootstrap JS (Agregar al final para que cargue más rápido) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
