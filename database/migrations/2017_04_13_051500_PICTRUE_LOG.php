<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PICTRUELOG extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictures', function (Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->string('photo_src');
            $table->string('thumbnail_src');
            $table->integer('article_id');
            $table->timestamps();
            $table->tinyInteger('state')->default(1);;
//            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pictures');
    }
}
