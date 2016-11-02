<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pick_up_place');
            $table->string('drop_off_place');
            $table->date('pick_up_datetime');
            $table->date('drop_off_datetime');
            $table->integer('price');
            $table->string('image');
            $table->tinyInteger('seats');
            $table->text('info');
            $table->text('location');
            $table->string('payment_id')->nullable();
            $table->foreign('payment_id')->references('paypal_id')->on('payments');
            $table->integer('tour_id')->unsigned();
            $table->foreign('tour_id')->references('id')->on('tours');
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
        Schema::dropIfExists('cars');
    }
}
