<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->increments('id');
            $table->string('origin_place');
            $table->string('destination_place');
            $table->date('departure_date');
            $table->date('arrival_date');
            $table->char('flight_number', 6);
            $table->string('carrier_logo');
            $table->string('carrier_name');
            $table->char('type', 8)->default('outbound');
            $table->tinyInteger('index')->default(0);
            $table->integer('round_trip_id')->unsigned();
            $table->foreign('round_trip_id')->references('id')->on('flight_round_trip')->onDelete('cascade');
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
        Schema::dropIfExists('flights');
    }
}
