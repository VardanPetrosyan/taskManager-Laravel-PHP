<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrasexanNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grasexan_names', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('grasexan_id');
            $table->string('name');
            $table->string('slug');
            $table->string('unit');
            $table->string('add_prop')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('grasexan_id')->references('id')->on('grasexans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grasexan_names');
    }
}
