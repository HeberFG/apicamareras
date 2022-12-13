<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('type');
            $table->integer('floor');
            $table->string('state')->default('Sucia');

            $table->unsignedBigInteger("build_id");
            $table->unsignedBigInteger("user_id");
            $table->timestamps();
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->foreign("build_id")->references('id')->on("buildings");
            $table->foreign("user_id")->references('id')->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
