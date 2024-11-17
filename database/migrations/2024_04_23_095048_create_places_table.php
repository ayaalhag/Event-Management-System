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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('location');
            $table->string('phone');
            $table->unsignedBigInteger('category_place_id');
            $table->foreign('category_place_id')
            ->references('id')
            ->on('catgories_place')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            $table->string('picture_url')->nullable();
            $table->decimal('assessment')->default(0.0)->check('assessment >= 0 AND assessment <= 5');;
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
        Schema::dropIfExists('places');
    }
};
