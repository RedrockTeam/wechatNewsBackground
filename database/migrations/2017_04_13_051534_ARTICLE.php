<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ARTICLE extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table){
           $table->increments('id');
           $table->integer('type_id');
           $table->string('title');
           $table->string('content')->nullable();
           $table->integer('user_id')->unsigned();
           $table->text('target_url');
           $table->timestamps();
           $table->tinyInteger('state')->default(1);;
           $table->index('created_at');
           $table->index('updated_at');
//           $table->foreign('user_id')->references('id')->on('users');
//           $table->foreign('photo_id')->references('id')->on('pictures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
