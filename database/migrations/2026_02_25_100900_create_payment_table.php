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
        Schema::create('payment', function (Blueprint $table) {
            $table->id('p_id');
            $table->string('invoice_no')->nullable();
            $table->integer('cus_treat_id')->nullable();
            $table->text('receipt_no');
            $table->string('payment_date')->nullable();
            $table->integer('tcate_id')->nullable();
            $table->text('treatment_id')->nullable();
            $table->text('product_id')->nullable();
            $table->integer('lead_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('sitting_count')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('total_amount');
            $table->integer('balance');
            $table->integer('discount')->default(0);
            $table->integer('discount_type')->default(0);
            $table->string('discount_amount')->default('0');
            $table->integer('cgst');
            $table->integer('sgst');
            $table->text('payment_status')->nullable();
            $table->text('payment_mode')->nullable();
            $table->integer('created_by');
            $table->timestamp('created_on')->useCurrent();
            $table->integer('updated_by');
            $table->timestamp('updated_on')->useCurrent()->useCurrentOnUpdate();
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
        Schema::dropIfExists('payment');
    }
};
