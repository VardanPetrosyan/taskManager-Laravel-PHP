<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFurnHistoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('furn_histories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('receiver_categoryStructure_id')->nullable();
			$table->integer('categoryStructure_id');
			$table->integer('user_id');
			$table->string('name', 191);
			$table->integer('count');
			$table->char('type', 50);
			$table->text('description', 65535);
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
		Schema::drop('furn_histories');
	}

}
