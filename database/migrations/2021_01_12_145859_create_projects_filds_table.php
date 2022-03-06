<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsFildsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('setting_id');
            $table->json('Default')->nullable();
            $table->string('EmptyValue')->nullable()->default(NULL);
            $table->integer('EmptyOrNot')->default('1');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('setting_id')->references('id')->on('tasks_helper')->onDelete('cascade');
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
        Schema::table('projects_fields', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['setting_id']);
            $table->dropIfExists('projects_fields');
        });
    }
}
