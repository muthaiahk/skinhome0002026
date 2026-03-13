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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id('g_set_id');
            $table->integer('company_id');
            $table->string('company_name',75);
            $table->string('logo');
            $table->string('favicon');
            $table->string('default_pic');
            $table->date('established_date');
            $table->string('company_address');
            $table->string('contact_person',50);
            $table->string('phone_no',20);
            $table->string('email',50);
            $table->string('website',50);
            $table->string('date_format');
            $table->string('timezone',50);
            $table->string('currency',50);
            $table->string('language',50);
            $table->string('gst_no',20);
            $table->string('pan_no',20);
            $table->timestamp('created_dt')->useCurrent();
            $table->timestamp('modified_dt')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
};
