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
        Schema::create('sales', function (Blueprint $table) {
                    $table->id('sales_id');
                    $table->integer('customer_id');
                    $table->integer('brand_id');
                    $table->integer('prod_cat_id');
                    $table->integer('product_id');
                    $table->date('date');
                    $table->integer('quantity');
                    $table->integer('amount');
                    $table->integer('branch_id')->default(0);
                    $table->timestamp('created_at')->useCurrent();
                    $table->timestamp('updated_at')->useCurrent();
                    $table->integer('created_by');
                    $table->integer('updated_by');
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
        Schema::dropIfExists('sales');
    }
};
