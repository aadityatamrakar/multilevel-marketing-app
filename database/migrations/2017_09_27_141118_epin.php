<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Epin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epin', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->integer('reg_id')->nullable();
            $table->string('code');
            $table->string('status');
            $table->integer('value');
            $table->string('gen_by');
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
        Schema::drop('epin');
    }
}
