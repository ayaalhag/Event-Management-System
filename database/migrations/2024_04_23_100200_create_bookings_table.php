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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')
            ->references('id')
            ->on('places')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')
            ->references('id')
            ->on('events')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            $table->dateTime('start_date');
            $table->dateTime('end_date');         
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
        Schema::dropIfExists('bookings');
    }
};
