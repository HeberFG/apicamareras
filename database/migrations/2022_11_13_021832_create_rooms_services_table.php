<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms_services', function (Blueprint $table) {
           $table->unsignedBigInteger('rooms_id');
           $table->unsignedBigInteger('services_id');
            $table->foreign("rooms_id")->references("id")->on("rooms");
           $table->foreign("services_id")->references("id")->on("services");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms_services');
    }
}
