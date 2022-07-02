<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('author_name', 64);
            $table->string('title', 125);
            $table->string('link', 255);
            $table->bigInteger('upvotes')->unsigned()->nullable(0);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::table('news', function (Blueprint $table) {
            $table->foreign('author_name')->references('name')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
