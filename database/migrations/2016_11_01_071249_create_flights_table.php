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
            $table->date('outbound_date');
            $table->date('inbound_date');
            $table->char('cabin_class', 12);
            $table->tinyInteger('number_of_seat');
            $table->integer('price');
            $table->char('flight_number', 6);
            $table->string('carrier_logo');
            $table->string('carrier_name');
            $table->string('payment_id')->nullable();
            $table->foreign('payment_id')->references('paypal_id')->on('payments')->onDelete('cascade');;
            $table->integer('tour_id')->unsigned();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');;
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
