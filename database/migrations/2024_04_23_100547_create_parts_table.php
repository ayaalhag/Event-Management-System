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
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('catgory_part_id');
            $table->foreign('catgory_part_id')
            ->references('id')
            ->on('catgories_part')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            $table->string('name');
            $table->decimal('price');
            $table->string('pictture_url')->nullable();
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
        Schema::dropIfExists('parts');
    }
};
