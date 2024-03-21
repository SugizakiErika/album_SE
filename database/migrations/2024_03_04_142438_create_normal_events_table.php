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
            $table->string('color');
            $table->string('comment',500);
            //$table->date('end')->nullable();
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
