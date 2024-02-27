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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->bigIncrements('leave_typeID')->index();
            $table->string('name');
            $table->integer('days')->default(0);
            $table->decimal('accumulation_rate')->default(0)->comment(' in days');
            $table->integer('accumulation_period')->default(0)->comment(' in days');
            $table->integer('expire_in_days')->default(0);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('leave_types');
    }
};
