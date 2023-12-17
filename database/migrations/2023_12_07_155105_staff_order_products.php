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
        Schema::create('staff_order_products', function (Blueprint $table) {
            $table->bigIncrements('staff_order_productID')->index(); 
            $table->integer('qty')->default(0);
            $table->decimal('price', $total = 8, $places = 2)->default(0);
            $table->text('comments')->nullable();
            $table->foreignId('staff_orderID')->constrained('staff_orders', 'staff_orderID')->onDelete('cascade');
            $table->foreignId('productID')->constrained('products', 'productID')->onDelete('cascade');
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
        Schema::dropIfExists('staff_order_products');
    }
};
