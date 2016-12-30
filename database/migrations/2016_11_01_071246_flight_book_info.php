<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FlightBookInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_book_info', function (Blueprint $table) {
            $table->increments('id');
            $table->char('gender', 6);
            $table->string('full_name');
            $table->date('birthday')->nullable();
            $table->integer('round_trip_id')->unsigned();
            $table->foreign('round_trip_id')->references('id')->on('flight_round_trip')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flight_book_info', function (Blueprint $table) {
            //
        });
    }
}
