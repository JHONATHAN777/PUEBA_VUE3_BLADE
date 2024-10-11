<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    protected $table = 'paises';
    protected $fillable = ['nombre_pais'];

    public function capitales()
    {
        return $this->hasMany(Capital::class, 'pais_id'); // Relación uno a muchos
    }
}

