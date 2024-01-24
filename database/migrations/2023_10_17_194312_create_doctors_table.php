<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_no')->unique();
            $table->string('email')->unique();
            $table->string('gender');
            $table->string('password');
            $table->foreignId('zone_id')->nullable()->constrained('zones');
            $table->foreignId('region_id')->nullable()->constrained('regions');
            $table->foreignId('branch_id')->nullable()->constrained('branches');
            $table->foreignId('district_id')->nullable()->constrained('districts');
            $table->foreignId('division_id')->nullable()->constrained('divisions');
            $table->foreignId('thana_id')->nullable()->constrained('thanas');
            $table->foreignId('union_id')->nullable()->constrained('unions');
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
        Schema::dropIfExists('doctors');
    }
}
