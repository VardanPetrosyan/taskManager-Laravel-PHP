<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrasexanDataNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grasexan_data_names', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('grasexan_name_id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('grasexan_name_id')->references('id')->on('grasexan_names')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grasexan_data_names');
    }
}
