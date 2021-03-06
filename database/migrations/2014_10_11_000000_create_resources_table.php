<?php
    
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;
    
    class CreateResourcesTable extends Migration {
        /**
         * Run the migrations.
         * @return void
         */
        public function up() {
            Schema::create('resources', function(Blueprint $table) {
                $table->string('id', 65)->index();
                $table->string('full_name', 255)->nullable();
                $table->string('representative', 255)->nullable(); // Người đại diện
                $table->dateTime('birthday')->nullable();
                $table->string('address', 255)->nullable();
                $table->string('country_id', 255)->nullable();
                $table->string('phone_number', 25)->nullable();
                $table->string('email', 65)->nullable();
                $table->string('identify', 25)->nullable();
                $table->enum('class', ['customer', 'employee'])->default('customer');
                $table->enum('type', ['personal', 'company'])->default('personal');
                $table->enum('status', ['enable', 'disable'])->default('enable');
                $table->string('creator_id', 65)->nullable();
                $table->timestamps();
                $table->primary('id');
            });
            
            \Db::table('resources')
               ->insert([
                            'id'        => \Helpers::generateId(),
                            'full_name' => 'Gấu Mập',
                            'class'     => 'employee',
                            'email'     => 'triet.nguyen207@gmail.com',
                        ]);
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        public function down() {
            Schema::dropIfExists('resources');
        }
    }
