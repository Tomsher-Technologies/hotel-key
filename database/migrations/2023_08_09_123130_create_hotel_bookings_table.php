<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('main_user_id')->unsigned();
            $table->foreign('main_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('room_number');
            $table->string('checkin_date');
            $table->string('checkin_time');
            $table->string('checkout_date');
            $table->string('checkout_time');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
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
        Schema::dropIfExists('hotel_bookings');
    }
};
