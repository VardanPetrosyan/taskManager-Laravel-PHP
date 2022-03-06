<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatTaskSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('task_id');
            $table->unsignedInteger('setting_id');
            $table->unsignedInteger('user_id');
            $table->json('setting')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('setting_id')->references('id')->on('tasks_helper')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('task_users');
        Schema::table('task_settings', function (Blueprint $table) {
            $table->dropForeign(['task_id']);
            $table->dropForeign(['setting_id']);
            $table->dropForeign(['user_id']);
            $table->dropIfExists('task_settings');
        });
    }
}
