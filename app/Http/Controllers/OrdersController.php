<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    // Muestra la lista de órdenes
    public function index()
    {
        $orders = Order::with('user')->get(); // Cargar la relación user
        return view('orders.index', compact('orders'));
    }

    // Método para cancelar una orden
    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        // Eliminar la orden
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Orden cancelada exitosamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array', // Asegúrate de que `items` sea un arreglo
            'total_price' => 'required|numeric'
        ]);

        // Crea la orden y guarda el usuario autenticado
        $order = Order::create([
            'user_id' => Auth::id(), // Obtener el ID del usuario autenticado
            'total_price' => $request->total_price,
            'status' => 'pending', // Puedes cambiar el estado según sea necesario
        ]);

        // Guardar productos en la tabla pivote
        foreach ($request->items as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item['id'], // Asegúrate de que estás pasando el ID del producto
                'quantity' => $item['quantity'], // También asegúrate de que estás pasando la cantidad
                'price' => $item['price'], // Precio del producto
            ]);
        }

        return response()->json(['order_id' => $order->id], 201);
    }

    // Método para editar el estado de una orden
    public function edit($id)
    {
        $order = Order::findOrFail($id);
    
        // Verifica si el usuario tiene el rol de admin
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('orders.index')->with('error', 'No tienes permiso para editar esta orden.');
        }
    
        return view('orders.edit', compact('order'));
    }
    

    // Método para actualizar el estado de una orden
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        // Verifica si el usuario tiene el rol de admin
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('orders.index')->with('error', 'No tienes permiso para editar esta orden.');
        }

        // Valida y actualiza el estado
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Estado de la orden actualizado exitosamente.');
    }
}
