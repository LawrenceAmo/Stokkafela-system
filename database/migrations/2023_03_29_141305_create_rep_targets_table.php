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
        Schema::create('rep_targets', function (Blueprint $table) {
            $table->bigIncrements('targetID')->index();
            $table->text('comments')->nullable(); 
            $table->decimal('target_amount', $total = 8, $places = 2)->nullable();
            $table->decimal('target', $total = 8, $places = 2)->nullable();
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
        Schema::dropIfExists('rep_targets');
    }
};
