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
         Schema::create('branch', function (Blueprint $table) {
            $table->id('branch_id');
            $table->string('branch_code',20);
            $table->unsignedBigInteger('company_id');
            $table->string('branch_name',50);
            $table->text('branch_location');
            $table->string('branch_phone',50);
            $table->string('branch_email');
            $table->string('branch_authority',50)->default('1');
            $table->text('branch_opening_date');
            $table->integer('is_franchise');
            $table->integer('created_by');
            $table->timestamp('created_on')->useCurrent();
            $table->integer('modified_by');
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
        Schema::dropIfExists('branch');
    }
};
