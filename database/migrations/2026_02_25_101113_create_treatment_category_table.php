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
        Schema::create('treatment_category', function (Blueprint $table) {
            $table->id('tcategory_id');
            $table->string('tc_name',50);
            $table->string('tc_description')->nullable();
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
        Schema::dropIfExists('treatment_category');
    }
};
