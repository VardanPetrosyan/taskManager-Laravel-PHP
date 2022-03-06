<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->integer('category')->nullable();
			$table->timestamp('created')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('image', 191)->nullable();
			$table->string('description', 191)->nullable();
			$table->float('price')->default(0.00);
			$table->char('status', 50)->default('passive');
			$table->string('top', 191)->default('0');
			$table->integer('count')->default(0);
			$table->integer('ordered')->default(0);
			$table->integer('unit')->nullable();
			$table->string('code', 191)->nullable()->unique();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
