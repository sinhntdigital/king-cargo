<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up () {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->char('iso', 2)->nullable();
            $table->string('name', 80)->nullable();
            $table->string('nicename', 80)->nullable();
            $table->char('iso3', 2)->nullable();
            $table->integer('numcode')->nullable();
            $table->integer('phonecode')->nullable();
            $table->integer('zipcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down () {
        Schema::dropIfExists('countries');
    }
}
