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
        Schema::create('attendance', function (Blueprint $table) {
                    $table->id('attendance_id');
                    $table->integer('staff_id');
                    $table->string('staff_name');
                    $table->integer('job_id');
                    $table->string('attendance_status',25);
                    $table->integer('present');
                    $table->integer('permission');
                    $table->integer('leave');
                    $table->string('leave_remarks')->nullable();
                    $table->integer('weekoff');
                    $table->dateTime('from_date');
                    $table->dateTime('to_date');
                    $table->integer('created_by');
                    $table->timestamp('created_on')->useCurrent();
                    $table->integer('modified_by');
                    $table->timestamp('modified_on')->useCurrent();
                    $table->integer('status')->default(0);
                });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance');
    }
};
