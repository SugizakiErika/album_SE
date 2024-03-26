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
        Schema::create('normal_events', function (Blueprint $table) {
            $table->bigIncrements('id');//自動増分カラムで0か正の数しか生成できない主キー
            $table->string('title',30);
            $table->string('start');
            $table->string('f_end');
            $table->string('color');
            $table->String('url');
            $table->string('explanation',500);
            $table->string('todo',500);
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
        Schema::dropIfExists('normal_events');
    }
};
