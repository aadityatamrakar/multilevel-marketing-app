<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Account extends Migration
{
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->string('title');
            $table->float('amount');
            $table->string('type');
            $table->float('admin_chrg');
            $table->float('tds');
            $table->float('total');
            $table->tinyInteger('display');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('account');
    }
}
