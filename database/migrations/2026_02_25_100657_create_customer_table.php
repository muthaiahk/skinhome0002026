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
        Schema::create('customer', function (Blueprint $table) {
            $table->id('customer_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('staff_id');
            $table->string('customer_first_name');
            $table->string('customer_last_name');
            $table->string('customer_dob');
            $table->string('customer_gender',11);
            $table->integer('customer_age');
            $table->bigInteger('customer_phone');
            $table->string('customer_email');
            $table->text('customer_address');
            $table->integer('treatment_id');
            $table->date('enquiry_date')->nullable();
            $table->integer('lead_status_id');
            $table->integer('lead_source_id');
            $table->string('customer_problem')->nullable();
            $table->string('customer_remark')->nullable();
            $table->integer('sitting_count');
            $table->integer('state_id');
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
        Schema::dropIfExists('customer');
    }
};
