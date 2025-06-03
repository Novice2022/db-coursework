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
        Schema::create('individual_entities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_id');
            $table->unsignedSmallInteger('credit_history_id');
            $table->decimal('income', 9, 2);

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');
                  
            $table->foreign('credit_history_id')
                  ->references('id')
                  ->on('credit_history')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual_entities');
    }
};
