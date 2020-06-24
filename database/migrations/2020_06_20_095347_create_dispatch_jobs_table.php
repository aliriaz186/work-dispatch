<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatch_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_address');
            $table->string('long');
            $table->string('lat');
            $table->integer('id_technician');
            $table->integer('id_customer');
            $table->string('title');
            $table->string('description');
            $table->string('service_type');
            $table->string('status');
            $table->string('customer_availability_one')->nullable();
            $table->string('customer_availability_two')->nullable();
            $table->string('customer_availability_three')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
