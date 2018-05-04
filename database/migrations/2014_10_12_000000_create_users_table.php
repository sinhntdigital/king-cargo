<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up () {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 65)->index();
            $table->string('resource_id', 65)->index();
            $table->string('name', 65)->unique();
            $table->string('email', 65)->unique();
            $table->string('password', 500);
            $table->dateTime('last_login')->nullable();
            $table->tinyInteger('role')->default(0); // 9 is admin, 0 is member
            $table->enum('status', ['enable', 'disable', 'banned'])->default('disable');
            $table->rememberToken();
            $table->timestamps();
            $table->primary('id');
            $table->foreign('resource_id')->references('id')->on('resources')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down () {
        Schema::dropIfExists('users');
    }
}
