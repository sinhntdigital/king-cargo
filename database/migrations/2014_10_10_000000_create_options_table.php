<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	/**
	 * Class CreateOptionsTable
	 */
	class CreateOptionsTable extends Migration {
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			Schema::create('options', function(Blueprint $table) {
				$table->string('id', 65)->index();
				$table->string('user_id', 65)->nullable();
				$table->string('key', 65)->nullable();
				$table->mediumText('value')->nullable();
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			Schema::dropIfExists('options');
		}
	}
