<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            
            $table->bigInteger('sender')->foreign('sender')->references('id')->on('users')->unsigned();
            $table->bigInteger('reciver')->foreign('reciver')->references('id')->on('users')->unsigned();
            
            $table->enum('status', [-2, -1, 0, 1])->default(0);
            
            $table->longText('message');
            
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
        Schema::dropIfExists('friends');
    }
}
