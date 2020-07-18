<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageGroupsAndGroupTasksTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_groups', function (Blueprint $table) {
            $table->integer('image_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->primary(['image_id', 'group_id']);
        });
        Schema::create('image_downloads', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('url');
            $table->string('name');
            $table->string('path');
            $table->string('groups');
            $table->integer('image_id')->unsigned();
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
        Schema::dropIfExists('image_groups');
        Schema::dropIfExists('image_downloads');
    }
}
