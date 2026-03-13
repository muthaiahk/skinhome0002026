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
        Schema::create('followup_history', function (Blueprint $table) {
                    $table->id('followup_id');
                    $table->integer('lead_id');
                    $table->integer('followup_count');
                    $table->dateTime('followup_date');
                    $table->dateTime('next_followup_date');
                    $table->string('positive_negative_status')->nullable();
                    $table->integer('app_status')->default(0);
                    $table->text('remark')->nullable();
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
        Schema::dropIfExists('followup_history');
    }
};
