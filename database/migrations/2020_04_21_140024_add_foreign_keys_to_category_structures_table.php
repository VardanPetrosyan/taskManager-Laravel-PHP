<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCategoryStructuresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('category_structures', function(Blueprint $table)
		{
			$table->foreign('parent_category_id')->references('id')->on('category_structures')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('category_structures', function(Blueprint $table)
		{
			$table->dropForeign('category_structures_parent_category_id_foreign');
		});
	}

}
