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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')
            ->references('id')
            ->on('places')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();


            // $table->unsignedBigInteger('type_id');
            // $table->foreign('type_id')
            // ->references('id')
            // ->on('types')
            // ->cascadeOnUpdate()
            // ->cascadeOnDelete();

            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')
            ->references('id')
            ->on('statuses')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->string('name');
            $table->string('type');
            $table->string('picture_url')->nullable();
            $table->text('additions')->nullable();
            $table->string('nameOnTheCard')->nullable();
            $table->text('music')->nullable();
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
        Schema::dropIfExists('events');
    }
};
