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
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('contactID')->index();
            $table->string('alt_email')->nullable(); 
            $table->string('phone')->nullable();
            $table->bigInteger('storeID')->default(0);
            $table->boolean('store')->default(false);
            $table->string('web')->nullable();
            $table->string('social')->nullable(); 
            $table->string('country')->nullable(); 
            $table->string('state')->nullable();
            $table->string('city')->nullable(); 
            $table->string('suburb')->nullable();  
            $table->string('street')->nullable();
            $table->integer('zip_code')->nullable();
            $table->longText('discription')->nullable();
            $table->longText('goal')->nullable();
            $table->foreignId('userID')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('contacts');
    }
};
