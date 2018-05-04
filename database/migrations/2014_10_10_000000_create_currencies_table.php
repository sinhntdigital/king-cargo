<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	/**
	 * Class CreateCurrenciesTable
	 */
	class CreateCurrenciesTable extends Migration {
		
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			Schema::create('currencies', function(Blueprint $table) {
				$table->char('id', 3);
				$table->char('name', 50);
				$table->primary('id');
			});
			
			\DB::table('currencies')->insert(
				[
					[
						'id'   => 'USD',
						'name' => 'US Dollar',
					],
					[
						'id'   => 'VND',
						'name' => 'Vietnam Dong',
					],
				]
			);
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			Schema::dropIfExists('currencies');
		}
	}
