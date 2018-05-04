<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up () {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id', 65)->index();
            $table->primary('id');
            $table->string('package_id', 65)->index();
            $table->string('name', 255);
            $table->decimal('weight', 8, 0);
            $table->decimal('fee', 18, 2);
            $table->foreign('package_id')->references('id')->on('packages')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     *
     * Reverse the migrations.
     * @return void
     */
    public function down () {
        Schema::dropIfExists('products');
    }
}
