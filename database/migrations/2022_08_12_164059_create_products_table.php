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
        Schema::create('products', function (Blueprint $table) { 
            $table->bigIncrements('productID')->index();
            $table->string('barcode');  
            $table->string('descript');  
            $table->double('sellprice1');
            $table->string('department')->nullable();  
            $table->string('sellpinc1', $precision = 8, $scale = 2)->nullable();   
            $table->string('onhandlvl1')->nullable();   
            $table->string('OnHandAvail')->nullable();   
            $table->string('itemValue')->nullable();   
            $table->string('GP_1')->nullable(); 
            // $table->boolean('isHero')->default(false); 
            
            // $table->json('photos')->nullable(); 
            // $table->json('collections')->nullable();
            // $table->json('sizes')->nullable(); 
            // $table->json('colours')->nullable(); 
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
        Schema::dropIfExists('products');
    }
};
