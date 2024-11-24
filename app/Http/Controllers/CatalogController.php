<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        // Obtener todos los productos de la base de datos
        $products = Product::all();  // Aquí puedes ajustar la consulta si es necesario

        // Pasar los productos a la vista 'welcome'
        return view('welcome', compact('products'));
    }

    // Función para mostrar el catálogo en el dashboard
    public function indexForDashboard()
    {
        // Obtener todos los productos de la base de datos
        $products = Product::all();

        // Pasar los productos a la vista 'dashboard'
        return view('dashboard', compact('products'));
    }

}
