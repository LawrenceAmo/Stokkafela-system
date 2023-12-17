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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigIncrements('user_roleID')->index(); 
            $table->date('start')->default(now());
            $table->date('end')->default(now());
            $table->boolean('role_status')->default(false);
            $table->foreignId('userID')->constrained('users', 'id')->onDelete('cascade');
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
        Schema::dropIfExists('user_roles');
    }
};
