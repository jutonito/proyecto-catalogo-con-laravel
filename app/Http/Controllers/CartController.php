<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // Agregar al carrito
    public function addToCart(Request $request)
{
    $cart = session()->get('cart', []);
    $productId = $request->input('product_id');
    $quantity = $request->input('quantity');
    $product = [
        'id' => $productId,
        'name' => $request->input('name'),
        'price' => $request->input('price'),
        'image' => $request->input('image'),
        'quantity' => $quantity,
    ];

    // Si el producto ya está en el carrito, actualizamos la cantidad
    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $quantity;
    } else {
        $cart[$productId] = $product;
    }

    // Calcular el total y la cantidad de productos
    $cartCount = 0;


    foreach ($cart as $item) {
        $cartCount += $item['quantity'];

    }

    // Guardamos el carrito, total y cantidad en la sesión
    session()->put('cart', $cart);
    session()->put('cartCount', $cartCount);


    return redirect()->route('dashboard')->with('success', 'Producto agregado al carrito');
}



    // Eliminar producto del carrito
    public function removeFromCart(Request $request)
{
    // Recuperamos el carrito de la sesión o inicializamos un array vacío si no existe
    $cart = session()->get('cart', []);

    // Filtrar el producto por su ID, eliminando el producto que tiene el ID proporcionado
    $cart = array_filter($cart, function ($item) use ($request) {
        return $item['id'] != $request->product_id;
    });

    // Reindexamos el arreglo para que las claves sean consecutivas
    $cart = array_values($cart);

    // Guardamos el carrito actualizado en la sesión
    session()->put('cart', $cart);

    // Redirigimos al usuario al carrito o a la página deseada
    return redirect()->route('dashboard')->with('success', 'Producto eliminado del carrito');
}




}

    



