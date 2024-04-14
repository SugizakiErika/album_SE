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
        Schema::create('inquiry_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title',30);
            $table->date('date');
            $table->string('comment',400);
            $table->string('user_id',100);
            $table->string('email',100);
            $table->string('inquiry_code',100);
            $table->timestamps();
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
        Schema::dropIfExists('inquiry_lists');
    }
};
