<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('account_contacts', function (Blueprint $table) {
            $table->bigIncrements('account_contactID')->index();
            $table->enum('title', ['Mr.', 'Mrs.', 'Miss', 'Ms.', 'Dr.', 'Prof.', 'Rev.', 'Hon.', 'Capt.', 'Sir', 'Madam', 'Lord'])->nullable(); 
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('alt_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('alt_phone')->nullable();
            $table->string('street')->nullable();
            $table->string('suburb')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('position')->nullable();
            $table->string('zip_code')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->boolean('primary')->default(false); 
            $table->boolean('marketing_opt_in')->default(false); 
            $table->enum('gender', ['male', 'female', 'other'])->nullable(); 
            $table->enum('preferred_contact_method', ['email', 'phone', 'mail', 'sms'])->nullable(); 
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active');
            $table->text('notes')->nullable();
            $table->foreignId('accountID')->constrained('accounts', 'accountID')->onDelete('cascade');       
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
        Schema::dropIfExists('account_contacts');
    }
};
