<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseTablesImageTaskAndGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id')->unsigned();
            $table->string('task_class_name');
            $table->text('task_params');
            $table->timestamps();
        });
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id')->unsigned();
            $table->integer('group_task_id')->unsigned();
            $table->string('name');
            $table->string('path');
            $table->string('ext');
            $table->string('mime');
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
        Schema::dropIfExists('group_tasks');
        Schema::dropIfExists('images');
    }
}
