<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapitalesTable extends Migration
{
    public function up()
    {
        Schema::create('capitales', function (Blueprint $table) {
            $table->id(); // Campo 'id' como llave primaria
            $table->foreignId('pais_id')->constrained('paises')->onDelete('cascade'); // Relación con 'paises'
            $table->string('nombre_capital'); // Campo para el nombre de la capital
            $table->timestamps(); // Campos para las marcas de tiempo
        });
    }

    public function down()
    {
        Schema::dropIfExists('capitales');
    }
}
