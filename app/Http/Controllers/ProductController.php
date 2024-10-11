<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Capital;
use App\Models\Pais;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $paises = Pais::all();
        $capitales = Capital::all();

        return view('products.index',compact('products','paises','capitales'));
    }

    public function getCities($id_pais)
    {
    
        $pais = Pais::find($id_pais);
    
        if (!$pais) {
            return response()->json(['message' => 'Country not found'], 404);
        }
    
        $capitales = $pais->capitales;
    
      
        if ($capitales->isEmpty()) {
            return response()->json(['message' => 'No capitals found for this country'], 404);
        }
    
      
        return response()->json($capitales);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $paises = Pais::all();
        $capitales = Capital::all();



        return view('products.create',compact('products','paises','capitales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required','integer','min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'] // Validación de la imagen
        ]);
    
        // Subida de imagen
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = null; // Si no se sube imagen, se deja en null
        }
    
        // Crear el producto
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath, // Almacenar la ruta de la imagen
        ]);
    
        // Redirigir o devolver respuesta
        return redirect()->back()->with('success', 'Producto creado exitosamente');
    }
    

    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
