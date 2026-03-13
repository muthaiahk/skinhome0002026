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
       Schema::create('appointment_payment', function (Blueprint $table) {
                    $table->id('app_pay_id');
                    $table->integer('app_id');
                    $table->string('mode');
                    $table->integer('amount')->default(0);
                    $table->timestamp('created_at')->useCurrent();
                    $table->integer('created_by');
                    $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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
        Schema::dropIfExists('appointment_payment');
    }
};
