<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaisesTable extends Migration
{
    public function up()
    {
        Schema::create('paises', function (Blueprint $table) {
            $table->id(); // Campo 'id' como llave primaria
            $table->string('nombre_pais'); // Campo para el nombre del país
            $table->timestamps(); // Campos para las marcas de tiempo
        });
    }

    public function down()
    {
        Schema::dropIfExists('paises');
    }
}

