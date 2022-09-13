<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views_times', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedInteger('movie_id')->index();
            $table->integer('views_time')->default(0);

            $table->foreign('movie_id')
                ->references('id')
                ->on('movies')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('views_times');
    }
};
