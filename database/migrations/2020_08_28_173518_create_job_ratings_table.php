<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('jobId')->nullable();
            $table->integer('workerId')->nullable();
            $table->integer('technicianId')->nullable();
            $table->string('rating')->nullable();
            $table->string('additional_comments')->nullable();
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
        Schema::dropIfExists('job_ratings');
    }
}
