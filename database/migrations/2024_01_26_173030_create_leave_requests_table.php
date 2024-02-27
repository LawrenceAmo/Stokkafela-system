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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->bigIncrements('leave_requestID')->index();
            $table->integer('number_of_days_requested')->default(0);
            $table->integer('actual_number_of_days_requested')->default(0);
            $table->date('date_from')->default(now())->index();
            $table->date('date_to')->default(now())->index();
            $table->enum('status', ['pending', 'declined', 'approved', 'cancelled'])->default('pending');
            $table->string('reason_to_update')->nullable();
            $table->text('description')->nullable();
            $table->text('logs')->nullable();
            $table->foreignId('leave_typeID')->constrained('leave_types', 'leave_typeID')->onDelete('cascade');
            $table->foreignId('userID')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('updated_byID')->nullable()->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_requests');
    }
};
