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
        Schema::create('staff', function (Blueprint $table) {
            $table->bigIncrements('staffID')->index();
            $table->string('staff_number')->index();
            $table->json('id_type')->default('id');
            $table->string('id_number')->nullable();
            $table->string('gender')->nullable();
            // $table->string('phone')->nullable();
            // $table->string('email')->nullable();
            // $table->string('gender')->nullable();
            // $table->integer('rep_number')->nullable();
            $table->string('descript')->nullable();
            // $table->text('address')->nullable(); 
            $table->foreignId('storeID')->constrained('stores', 'storeID')->onDelete('cascade');
            $table->foreignId('userID')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('departmentID')->constrained('departments', 'departmentID')->onDelete('cascade');
            $table->foreignId('roleID')->constrained('roles', 'roleID')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
};
