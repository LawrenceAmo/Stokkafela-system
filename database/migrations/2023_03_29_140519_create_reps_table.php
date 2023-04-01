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
        Schema::create('reps', function (Blueprint $table) {
            $table->bigIncrements('repID')->index();
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->integer('rep_number')->nullable();
            $table->string('descript')->nullable();
            $table->text('address')->nullable(); 
            $table->foreignId('storeID')->constrained('stores', 'storeID')->onDelete('cascade');
            $table->foreignId('destributorID')->constrained('destributors', 'destributorID')->onDelete('cascade');
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
        Schema::dropIfExists('reps');
    }
};
