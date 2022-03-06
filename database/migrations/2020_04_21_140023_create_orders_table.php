<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('categoryStructure_id')->nullable();
			$table->char('status', 50)->default('pending');
			$table->integer('user_id');
			$table->integer('product_id');
			$table->boolean('urgent')->default(0);
			$table->string('reason', 191)->nullable();
			$table->string('exploiter', 191)->nullable();
			$table->string('edu_obj', 191)->nullable();
			$table->integer('details_id');
			$table->float('count');
			$table->float('approved')->nullable();
			$table->integer('storage')->default(0);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
