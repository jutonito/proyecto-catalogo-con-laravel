@extends('layouts.app')

@section('content')
    <h1>Catálogo de Productos</h1>
    @if(isset($products) && $products->count())
        <div class="catalog">
            @foreach($products as $product)
                <div class="product">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ $product->description }}</p>
                    <span>{{ $product->price }}</span>
                    <!-- Aquí puedes agregar más detalles del producto -->
                </div>
            @endforeach
        </div>
    @else
        <p>No hay productos disponibles.</p>
    @endif
@endsection
