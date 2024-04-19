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
        Schema::create('release_lists', function (Blueprint $table) {
            $table->id();
            $table->string('release_user_id',100); //見に来てほしい人のユーザーID
            $table->string('follow_name',100);
            $table->string('request')->default(false);//申請中か
            $table->boolean('notice')->default(false); //許可済みか
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
        Schema::dropIfExists('release_lists');
    }
};
