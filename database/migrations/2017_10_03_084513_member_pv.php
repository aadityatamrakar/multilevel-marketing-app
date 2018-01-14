<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberPv extends Migration
{
    public function up()
    {
        Schema::create('member_pv', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->integer('pv');
            $table->integer('members');
            $table->integer('activated');
            $table->integer('level');
            $table->integer('highest');
            $table->integer('all_act');
            $table->integer('club');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('member_pv');
    }
}
