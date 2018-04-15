<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function(Blueprint $table) {
            $table->increments('id');
            $table->string('sku', 50);
            $table->string('slug', 100);
            $table->string('title', 191);
            $table->string('author', 191);
            $table->string('publisher', 191);
            $table->integer('price');
            $table->string('img_url', 191);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }
}
