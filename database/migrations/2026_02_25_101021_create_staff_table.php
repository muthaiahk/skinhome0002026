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
        Schema::create('staff', function (Blueprint $table) {
            $table->id('staff_id');
            $table->unsignedBigInteger('company_id');
            $table->string('branch_id');
            $table->string('name',50);
            $table->string('address');
            $table->string('phone_no',20);
            $table->bigInteger('emergency_contact');
            $table->string('email');
            $table->string('date_of_birth');
            $table->string('date_of_joining');
            $table->integer('salary')->nullable();
            $table->string('gender',11);
            $table->string('marital_status',11)->nullable();
            $table->string('date_of_relieve')->nullable();
            $table->integer('dept_id')->default(0);
            $table->integer('role_id')->default(0);
            $table->integer('job_id')->default(0);
            $table->string('username');
            $table->string('password');
            $table->integer('created_by')->default(0);
            $table->timestamp('created_on')->useCurrent();
            $table->integer('modified_by')->default(0);
            $table->timestamp('modified_on')->useCurrent()->useCurrentOnUpdate();
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
        Schema::dropIfExists('staff');
    }
};
