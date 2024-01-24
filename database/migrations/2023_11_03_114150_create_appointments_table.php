<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('gender');
            $table->integer('age');
            $table->string('serial_no');
            $table->string('phone');
            $table->string('clinic')->nullable();
            $table->string('clinic_address')->nullable();
            $table->string('upload_docs')->nullable();
            $table->string('lab_report')->nullable();
            $table->string('prescription')->nullable();
            $table->string('status')->nullable();
            $table->string('payment')->nullable();
            $table->unsignedBigInteger('availability_id');
            $table->timestamps();

            // Define foreign key constraint
            // $table->foreign('availability_id')->references('id')->on('availabilities')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
