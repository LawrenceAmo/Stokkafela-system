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
        Schema::create('account_reps', function (Blueprint $table) {
            $table->bigIncrements('account_repID')->index();
            $table->boolean('primary')->default(true); 
            $table->text('note')->nullable();
            $table->foreignId('accountID')->constrained('accounts', 'accountID')->onDelete('cascade');       
            $table->foreignId('userID')->constrained('users', 'id')->onDelete('cascade');
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
        Schema::dropIfExists('account_reps');
    }
};
