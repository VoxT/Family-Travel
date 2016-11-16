<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->increments('id');
            $table->string('origin_place');
            $table->string('destination_place');
            $table->string('origin_location')->nullable();
            $table->string('destination_location')->nullable();
            $table->date('outbound_date');
            $table->date('inbound_date');
            $table->tinyInteger('adults');
            $table->tinyInteger('children');
            $table->tinyInteger('infants');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('tours');
    }
}
