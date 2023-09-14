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
        Schema::create('spaza_shops', function (Blueprint $table) {
            $table->bigIncrements('spaza_shopID')->index();
            $table->string('name')->index();
            $table->text('address');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->boolean('status')->default(true);
            $table->string('comment')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('repID')->nullable()->index();
            $table->foreign('repID')->references('repID')->on('reps');
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
        Schema::dropIfExists('spaza_shops');
    }
};
