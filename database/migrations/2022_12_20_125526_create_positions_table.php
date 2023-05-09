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
        Schema::create('positions', function (Blueprint $table) {
            $table->bigIncrements('jobID')->index();
            $table->string('job_title'); 
            $table->text('description')->nullable(); 
            $table->boolean('active')->nullable()->default(true); 
            $table->dateTime('closing_date')->nullable(); 
            $table->foreignId('departmentID')->constrained('departments', 'departmentID')->onDelete('cascade');
            $table->foreignId('id')->constrained('users', 'id')->onDelete('cascade');
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
        Schema::dropIfExists('jobs');
    }
};
