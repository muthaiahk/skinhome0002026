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
        Schema::create('department', function (Blueprint $table) {
            $table->id('department_id');
            $table->integer('company_id');
            $table->integer('branch_id');
            $table->string('department_name',50);
            $table->string('dept_incharge')->nullable();
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
        Schema::dropIfExists('department');
    }
};
