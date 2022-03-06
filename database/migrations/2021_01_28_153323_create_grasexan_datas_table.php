<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrasexanDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grasexan_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('grasexan_name_id');
            $table->unsignedInteger('data_name_id');
            $table->unsignedInteger('add_prop_id')->nullable();
            $table->integer('counter_number');
            $table->string('date');
            $table->integer('unit_price');
            $table->integer('total_payment');
            $table->integer('paid')->default(0);
            $table->integer('debt')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('grasexan_name_id')->references('id')->on('grasexan_names')->onDelete('cascade');
            $table->foreign('data_name_id')->references('id')->on('grasexan_data_names')->onDelete('cascade');
            $table->foreign('add_prop_id')->references('id')->on('grasexan_additional_properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grasexan_datas');
    }
}
