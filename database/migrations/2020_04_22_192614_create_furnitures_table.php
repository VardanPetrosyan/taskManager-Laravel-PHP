<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFurnituresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('furnitures', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('code', 191)->nullable();
			$table->string('image', 191)->nullable();
			$table->string('description', 191)->nullable();
			$table->char('status', 50)->default('in_use');
			$table->integer('count')->default(0);
			$table->boolean('approved')->default(0);
			$table->integer('user_id');
			$table->integer('ordered_from_categoryStructure_id')->nullable();
			$table->integer('sended_to_categoryStructure_id')->nullable();
			$table->integer('categoryStructure_id');
			$table->integer('category_id');
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
		Schema::drop('furnitures');
	}

}
