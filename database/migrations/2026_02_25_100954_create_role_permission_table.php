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
        Schema::create('role_permission', function (Blueprint $table) {
                $table->id('rp_id');
                $table->integer('role_id');
                $table->text('page');
                $table->text('permission')->nullable();
                $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
                $table->integer('created_by');
                $table->timestamp('updated_at')->useCurrent();
                $table->integer('updated_by');
                $table->integer('status');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permission');
    }
};
