<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->json('images');
            $table->integer('quantity');
            $table->integer('import_price');
            $table->integer('price');
            $table->text('description');
            $table->unsignedBigInteger('manufacturer_id');
            $table->foreign('manufacturer_id')
                  ->references('id')
                  ->on('manufacturers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
