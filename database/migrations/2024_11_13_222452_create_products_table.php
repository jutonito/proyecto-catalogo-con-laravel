<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->decimal('price', 40, 5);
        $table->string('image_path'); // Almacenar la ruta de la imagen
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('products');
}
};
