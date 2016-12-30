<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlightRoundTripTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_round_trip', function (Blueprint $table) {
            $table->increments('id');
            $table->char('cabin_class', 12)->default('Economic');
            $table->tinyInteger('number_of_seat');
            $table->integer('price');
            $table->char('phone', 15);
            $table->string('email');
            $table->string('address');
            $table->string('payment_id')->nullable();
            $table->foreign('payment_id')->references('paypal_id')->on('payments')->onDelete('cascade');
            $table->integer('tour_id')->unsigned();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
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
        Schema::table('flight_round_trip', function (Blueprint $table) {
            //
        });
    }
}
