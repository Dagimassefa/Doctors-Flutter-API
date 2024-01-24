<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academics', function (Blueprint $table) {
            $table->id();
            $table->string('degree');
            $table->string('college');
            $table->string('reg_no')->nullable();
            $table->string('reg_doc')->nullable();
            $table->string('specialization')->nullable();
            $table->string('years')->nullable();
            $table->string('file')->nullable();
            $table->string('doctor_id')->nullable();
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
        Schema::dropIfExists('academics');
    }
}
