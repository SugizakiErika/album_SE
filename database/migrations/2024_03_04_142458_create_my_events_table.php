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
        Schema::create('my_events', function (Blueprint $table) {
            $table->id();
            $table->string('title',30);
            $table->string('start');
            $table->string('f_end');
            $table->string('category');
            $table->integer('day');
            $table->string('color');
            $table->string('url');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('users_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_events');
    }
};
