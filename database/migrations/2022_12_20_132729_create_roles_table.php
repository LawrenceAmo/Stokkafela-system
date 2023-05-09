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
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('roleID')->index();
            $table->string('role_title'); 
            $table->text('description')->nullable(); 
            $table->foreignId('departmentID')->constrained('departments', 'departmentID')->onDelete('cascade');
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
        Schema::dropIfExists('roles');
    }
};
