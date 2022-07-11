<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->string('restaurant_name');
            $table->string('unique_code');
            $table->string('gst_number');
            $table->string('primary_contact_no');
            $table->string('secondary_contact_no');
            $table->string('address');
            $table->boolean('is_razorpay_allowed');
            $table->string('is_cred_allowed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client');
    }
}
