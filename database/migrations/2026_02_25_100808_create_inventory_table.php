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
        Schema::create('inventory', function (Blueprint $table) {
                    $table->id('inventory_id');
                    $table->string('inventory_date',11);
                    $table->integer('company_id');
                    $table->integer('branch_id');
                    $table->integer('brand_id');
                    $table->integer('prod_cat_id');
                    $table->integer('product_id');
                    $table->integer('stock_in_hand');
                    $table->integer('stock_alert_count');
                    $table->string('description')->nullable();
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
        Schema::dropIfExists('inventory');
    }
};
