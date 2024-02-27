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
        Schema::create('user_managers', function (Blueprint $table) {
            $table->bigIncrements('user_managerID')->index();     
            $table->foreignId('userID')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('managerID')->nullable()->constrained('users', 'id')->onDelete('cascade');       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_managers');
    }
};
