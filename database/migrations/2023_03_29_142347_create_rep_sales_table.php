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
        Schema::create('rep_sales', function (Blueprint $table) {
            $table->bigIncrements('salesID')->index();
            $table->decimal('Invoices', $total = 8, $places = 2)->nullable();
            $table->decimal('CreditNotes', $total = 8, $places = 2)->nullable();
            $table->decimal('Units', $total = 8, $places = 2)->nullable();
            $table->decimal('CNUnits', $total = 8, $places = 2)->nullable();
            $table->decimal('InvoiceCost', $total = 8, $places = 2)->nullable();
            $table->decimal('CreditNotesCost', $total = 8, $places = 2)->nullable();
            $table->decimal('NettSales', $total = 8, $places = 2)->nullable();
            $table->decimal('Profit', $total = 8, $places = 2)->nullable();
            $table->decimal('VAT', $total = 8, $places = 2)->nullable(); 
            $table->dateTime('date', $precision = 0);
            $table->foreignId('repID')->constrained('reps', 'repID')->onDelete('cascade');
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
        Schema::dropIfExists('rep_sales');
    }
};
