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
        Schema::create('customer_treatment', function (Blueprint $table) {
            $table->id('cus_treat_id');
            $table->integer('tc_id');
            $table->text('treatment_auto_id')->nullable();
            $table->integer('treatment_id');
            $table->integer('customer_id');
            $table->string('progress')->nullable();
            $table->text('medicine_prefered')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('amount');
            $table->integer('discount');
            $table->boolean('generate_invoice')->default(0);
            $table->integer('complete_status')->default(0);
            $table->timestamp('created_on')->useCurrent();
            $table->integer('created_by');
            $table->timestamp('modified_on')->useCurrent()->useCurrentOnUpdate();
            $table->integer('modified_by');
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
        Schema::dropIfExists('customer_treatment');
    }
};
