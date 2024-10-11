<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    use HasFactory;

    protected $table = 'capitales';
    protected $fillable = ['pais_id', 'nombre_capital'];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id'); 
    }
}



