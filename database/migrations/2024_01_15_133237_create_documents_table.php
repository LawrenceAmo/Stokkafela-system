<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up() 
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('documentID')->index(); 
            $table->string('name'); 
            $table->string('url'); 
            $table->string('type')->nullable(); 
            $table->string('size')->default(0); 
            $table->text('description')->nullable();
            $table->foreignId('userID')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }
      
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
