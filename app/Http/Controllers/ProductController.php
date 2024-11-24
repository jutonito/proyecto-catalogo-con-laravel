<?php

// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Mostrar formulario para agregar un producto
    public function create()
    {
        return view('admin.create');
    }

    // Guardar un nuevo producto en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $imagePath = $request->file('image')->store('product_images', 'public');

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Producto añadido con éxito');
    }

    public function index() { // Obtener todos los productos 
        $products = Product::all(); // Pasar los productos a la vista 
        return view('admin.dashboard', compact('products')); }
    // Eliminar un producto
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_path) {
            Storage::delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Producto eliminado con éxito');
    }

    
}


