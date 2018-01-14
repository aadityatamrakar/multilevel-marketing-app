<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Member extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('s_id');
            $table->string('title', 5);
            $table->string('name');
            $table->string('father_name');
            $table->string('dob_d', 2);
            $table->string('dob_m', 2);
            $table->string('dob_y', 4);
            $table->string('mobile', 10);
            $table->string('paytm_no', 10);
            $table->text('address');
            $table->string('pincode', 10);
            $table->string('city');
            $table->string('district');
            $table->string('state');
            $table->string('pancard', 10);
            $table->string('applied_pan', 10);
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->string('bank');
            $table->string('account_no');
            $table->string('ifsc', 11);
            $table->string('branch');
            $table->string('password');
            $table->string('id_proof');
            $table->string('bank_proof');
            $table->string('kyc_s');
            $table->tinyInteger('kyc')->nullable();
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
        Schema::drop('member');
    }
}
