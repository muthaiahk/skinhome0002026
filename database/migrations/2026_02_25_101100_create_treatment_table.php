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
        Schema::create('treatment', function (Blueprint $table) {
            $table->id('treatment_id');
            $table->integer('tc_id');
            $table->string('treatment_name',50);
            $table->string('treatment_description')->nullable();
            $table->integer('amount');
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
        Schema::dropIfExists('treatment');
    }
};
