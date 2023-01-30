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
        Schema::create('products_stats', function (Blueprint $table) {
            $table->bigIncrements('statsID')->index();
            // $table->longText('id')->primary();
            $table->string('stock_value')->nullable();
            $table->string('total_stock')->nullable();
            $table->string('total_quantity')->nullable(); // optional
            $table->string('out_of_stock_products')->nullable(); 
             // $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
