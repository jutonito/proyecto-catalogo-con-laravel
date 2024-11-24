<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product; // Asegúrate de importar el modelo Product

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Obtener los productos
        $products = Product::all(); // O ajusta la consulta según sea necesario

        // Pasar los productos a la vista
        return view('layouts.app', compact('products'));
    }
}
