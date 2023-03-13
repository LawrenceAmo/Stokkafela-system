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
        Schema::create('stock_analyses', function (Blueprint $table) {
            $table->bigIncrements('analysisID')->index();
            $table->string('code')->index();
            $table->string('descript')->nullable();  
            $table->string('department')->nullable();  
            $table->string('invoices')->nullable(); 
            $table->string('CRNOTES')->nullable();
            $table->string('purchases')->nullable();
            $table->string('reFundsCost')->nullable();
            $table->string('nettSales')->nullable();
            $table->string('profit')->nullable();
            $table->string('vat')->nullable();
            $table->dateTime('date', $precision = 0);
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
        Schema::dropIfExists('stock_analyses');
    }
};
