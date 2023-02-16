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
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('salesID')->index();
            $table->string('barcode')->index();
            $table->string('descript')->nullable();  
            $table->string('department')->nullable();  
            $table->string('mainitem')->nullable();
            $table->string('sales')->nullable();
            $table->string('salesCost')->nullable();
            $table->string('reFunds')->nullable();
            $table->string('reFundsCost')->nullable();
            $table->string('nettSales')->nullable();
            $table->string('profit')->nullable();
            $table->string('vat')->nullable();
            $table->boolean('daily_total')->default(false)->index();
            $table->dateTime('from', $precision = 0);
            $table->dateTime('to', $precision = 0);
            $table->foreignId('storeID')->constrained('stores', 'storeID')->onDelete('cascade');
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
        Schema::dropIfExists('sales');
    }
};
