<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('guests');
            $table->integer('rooms');
            $table->integer('price');
            $table->text('policy');
            $table->string('room_type', 20);
            $table->text('reviews');
            $table->string('name');
            $table->text('description');
            $table->text('location');
            $table->integer('popularity');
            $table->text('amenities');
            $table->string('latitude',10);
            $table->string('longitude',10);
            $table->integer('star_rating');
            $table->text('image_url');
            $table->string('full_name');
            $table->char('phone', 15);
            $table->string('address');
            $table->string('email');
            $table->char('gender', 6);
            $table->string('payment_id')->nullable();
            $table->foreign('payment_id')->references('paypal_id')->on('payments');
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
        Schema::dropIfExists('hotels');
    }
}
