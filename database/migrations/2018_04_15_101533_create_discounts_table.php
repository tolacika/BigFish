<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('discounts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('sku', 50);
            $table->string('discount_type', 50);
            $table->string('discount_amount', 50)->nullable()->default(null);
            $table->string('target_type', 50);
            $table->string('target_reference', 50);
            $table->tinyInteger('active');
            $table->dateTime('valid_from');
            $table->dateTime('valid_to');
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
        Schema::dropIfExists('discounts');
    }
}
