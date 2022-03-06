<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryStructuresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_structures', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_category_id')->unsigned()->nullable()->index('category_structures_parent_category_id_foreign');
			$table->string('category', 191);
			$table->char('is_deleted', 50)->default('false');
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
		Schema::drop('category_structures');
	}

}
