<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->text('description', 65535)->nullable();
			$table->string('website', 191);
			$table->smallInteger('year_founded')->unsigned();
			$table->string('address_line1', 191);
			$table->string('address_line2', 191)->nullable();
			$table->string('address_city', 191);
			$table->string('address_state', 191);
			$table->string('address_country', 191);
			$table->string('address_zip', 191);
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
		Schema::drop('companies');
	}

}
