<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenreTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_type', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('genre_id')->unsigned();
            $table->bigInteger('type_id')->unsigned();
            $table->foreign('genre_id')->references('id')->on('genres');
            $table->foreign('type_id')->references('id')->on('types');
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
        Schema::dropIfExists('genre__type');
    }
}
