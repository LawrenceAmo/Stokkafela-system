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
        Schema::create('mini_statistics', function (Blueprint $table) {           
            $table->bigIncrements('mini_statsID')->index();
            $table->integer('staff')->nullable(); 
            $table->integer('jobs')->nullable(); 
            $table->integer('stores')->nullable(); 
            $table->integer('departments')->nullable(); 
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
        Schema::dropIfExists('mini_statistics');
    }
};
