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
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('movie');
            $table->string('thumbnails_image');
            $table->string('movie_title',100);
            $table->string('movie_outline');
            $table->string('type1');
            $table->string('type2')->nullable();
            $table->string('type3')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('id');
            $table->index('user_id');
            $table->index('type1');
            $table->index('type2');
            $table->index('type3');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('movies');
    }
};
