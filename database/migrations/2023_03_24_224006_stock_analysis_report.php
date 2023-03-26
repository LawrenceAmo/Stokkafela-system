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
        Schema::create('stock_analysis_reports', function (Blueprint $table) {
            $table->bigIncrements('analysisID')->index();
            $table->string('barcode')->index();
            $table->string('descript')->nullable();  
            $table->string('department')->nullable();  
            $table->double('sellpinc1')->nullable(); 
            $table->integer('onhand')->nullable();
            $table->double('avrgcost')->nullable();
            $table->double('nett_sales')->nullable();
            $table->double('avr_rr')->nullable();
            $table->double('stock_value')->nullable();
            $table->decimal('days_onhand', $total = 8, $places = 1)->nullable();
            $table->string('vat')->nullable();
            $table->string('status')->nullable();
            $table->string('comment')->nullable();
            // $table->dateTime('date', $precision = 0);
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
        Schema::dropIfExists('stock_analysis_reports');
    }
};
