<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsUpvotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_upvotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('news_upvotes', function (Blueprint $table) {
            $table->foreign('news_id')->references('id')->on('news');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_upvoters');
    }
}
