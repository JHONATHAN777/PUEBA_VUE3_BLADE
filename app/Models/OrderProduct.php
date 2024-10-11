<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_product'; // Nombre de la tabla pivote

    // Definir los campos que son "fillable" (que pueden ser asignados en masa)
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * Relación con la tabla `Order` (Un producto en un pedido pertenece a un pedido).
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relación con la tabla `Product` (Un producto en un pedido pertenece a un producto).
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
