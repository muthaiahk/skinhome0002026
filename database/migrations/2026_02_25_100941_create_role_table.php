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
       Schema::create('role', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('role_name');
            $table->string('role_description')->nullable();
            $table->timestamp('created_on')->useCurrent();
            $table->integer('created_by');
            $table->timestamp('modified_on')->nullable();
            $table->integer('modified_by');
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
        Schema::dropIfExists('role');
    }
};
