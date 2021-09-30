<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hostpital_room_id');
            $table->unsignedBigInteger('occupant_id');
            $table->foreign('hostpital_room_id')->references('id')->on('hospital_rooms')->onDelete('cascade');
            $table->foreign('occupant_id')->references('id')->on('occupants')->onDelete('cascade');
            $table->string('type');
            $table->string('status');
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
        Schema::dropIfExists('room_requests');
    }
}
