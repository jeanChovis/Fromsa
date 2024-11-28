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
        Schema::create('customer_person', function (Blueprint $table) {
            $table->id('id');            
            $table->string('dni', 8)->unique();
            $table->date('date_birth')->nullable();
            $table->string('gender')->nullable();
            $table->foreignId('customer_id')->constrained('customer')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_person');
    }
};
