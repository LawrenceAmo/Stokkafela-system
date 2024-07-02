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
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('accountID')->index();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('street')->nullable();
            $table->string('suburb')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->integer('number_of_employees')->nullable();
            $table->string('annual_revenue')->nullable();
            $table->enum('account_type', ['individual', 'business'])->default('individual');
            $table->string('company_name');
            $table->string('registration_number')->nullable();
            $table->string('tax_id')->nullable();
            $table->enum('preferred_contact_method', ['email', 'phone', 'mail', 'sms'])->nullable();
            $table->boolean('marketing_opt_in')->default(false); 
            $table->foreignId('repID')->nullable()->constrained('reps', 'repID')->onDelete('cascade');       
            $table->foreignId('industryID')->nullable()->constrained('industries', 'industryID')->onDelete('cascade');       
            $table->enum('account_status', ['active', 'inactive', 'pending'])->default('active');
            $table->string('source')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('accounts');
    }
};
