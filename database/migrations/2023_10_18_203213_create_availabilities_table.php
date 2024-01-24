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
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('day');
            $table->string('type');
            $table->integer('max_patients');
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('status');
            // $table->foreignId('doctor_id')->nullable()->constrained('doctors');

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
        Schema::dropIfExists('availabilities');
    }
};
