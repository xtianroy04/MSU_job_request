<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            // Connection for the user who submitted the request
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->string('service_provider');
            $table->string('service_name');
            $table->text('details');
            $table->enum('status', ['Pending', 'Approved', 'Declined', 'Cancelled']);
            
            // User manager who approved the request
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            
            // User who is assigned to the service
            $table->unsignedBigInteger('assigned')->nullable();
            $table->foreign('assigned')->references('id')->on('users')->onDelete('set null');
            
            // Connection to the Services Table
            $table->unsignedBigInteger('service_type_id');
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');

            $table->integer('service_rating')->nullable();
            $table->string('additional_field')->nullable();
            $table->string('e_signature')->nullable();
            $table->date('date_served')->nullable();
            $table->date('date_approved')->nullable();
            $table->timestamps();
        });            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_types');
        Schema::dropIfExists('services');
    }
};
