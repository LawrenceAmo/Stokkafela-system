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
        Schema::create('staff_orders', function (Blueprint $table) {
            $table->bigIncrements('staff_orderID')->index(); 
            $table->string('order_number')->nullable(); 
            $table->date('when_to_deliver')->default(now());
            $table->boolean('ordered')->default(false);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->integer('total_qty')->default(0);
            $table->decimal('total_price', $total = 8, $places = 2)->default(0);
            $table->text('comments')->nullable();
            $table->foreignId('userID')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('staff_orders');
    }
};
