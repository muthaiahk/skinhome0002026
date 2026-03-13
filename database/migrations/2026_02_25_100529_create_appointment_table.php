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
        Schema::create('appointment', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->integer('company_id');
            $table->integer('customer_id')->nullable();
            $table->integer('lead_id')->nullable();
            $table->integer('branch_id')->default(0);
            $table->integer('tc_id')->nullable();
            $table->string('date',11)->nullable();
            $table->string('time',11)->nullable();
            $table->integer('treatment_id')->nullable();
            $table->integer('staff_id');
            $table->text('problem')->nullable();
            $table->integer('lead_status_id')->nullable();
            $table->text('app_status');
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('appointment');
    }
};
