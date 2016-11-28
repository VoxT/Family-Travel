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
            $table->dateTime('pick_up_datetime');
            $table->dateTime('drop_off_datetime');
            $table->integer('price');
            $table->string('image');
            $table->tinyInteger('seats');
            $table->tinyInteger('doors');
            $table->tinyInteger('bags');
            $table->string('manual')->nullable();
            $table->string('air_conditioning')->nullable();
            $table->string('mandatory_chauffeur')->nullable();
            $table->string('car_class_name')->nullable();
            $table->string('vehicle');
            $table->float('distance_to_search_location_in_km');
            $table->string('geo_info');
            $table->string('fuel_type')->nullable();
            $table->string('fuel_policy')->nullable();
            $table->string('theft_protection_insurance')->nullable();
            $table->string('third_party_cover_insurance')->nullable();
            $table->string('free_collision_waiver_insurance')->nullable();
            $table->string('free_damage_refund_insurance')->nullable();
            $table->string('free_cancellation')->nullable();
            $table->string('free_breakdown_assistance')->nullable();
            $table->string('unlimited')->nullable();
            $table->string('included')->nullable();
            $table->string('unit')->nullable();
            $table->text('address');
            $table->string('full_name');
            $table->char('phone', 15);
            $table->string('email');
            $table->char('gender', 5);
            $table->string('payment_id')->nullable();
            $table->foreign('payment_id')->references('paypal_id')->on('payments');
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
        Schema::dropIfExists('cars');
    }
}
