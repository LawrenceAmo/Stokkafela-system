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
        Schema::create('destributors', function (Blueprint $table) {
            $table->bigIncrements('destributorID')->index();
            $table->string('name')->index();
            $table->string('descript')->nullable();
            $table->text('address')->nullable(); 
            $table->foreignId('storeID')->constrained('stores', 'storeID')->onDelete('cascade');
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
        Schema::dropIfExists('destributors');
    }
};
