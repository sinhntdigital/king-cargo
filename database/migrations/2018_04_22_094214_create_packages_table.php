<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up () {
        Schema::create('packages', function (Blueprint $table) {
            $table->string('id', 65)->index();
            $table->string('info', 65)->index();
            $table->primary('id');
            $table->string('package_code', 65)->index();
            $table->enum('type', [
                'door_to_door',
                'airport',
                'vietnam_branch_store',
            ])->nullable();
            $table->string('shipper_id', 65)->index();
            $table->dateTime('ship_date');
            $table->string('recipient_id', 65)->index();
            $table->dateTime('recipient_date');
            $table->decimal('declared_value', 18, 2);
            $table->decimal('shipping_price', 18, 2);
            $table->decimal('insurance', 18, 2);
            $table->decimal('total_price', 18, 2);
            $table->string('creator_id', 65)->index();
            $table->timestamps();
            $table->foreign('shipper_id')->references('id')->on('resources')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('recipient_id')->references('id')->on('resources')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down () {
        Schema::dropIfExists('packages');
    }
}
