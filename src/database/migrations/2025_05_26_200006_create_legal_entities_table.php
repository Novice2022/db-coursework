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
        Schema::create('legal_entities', function (Blueprint $table) {
            $table->id();
            $table->uuid('client_id');
            $table->unsignedSmallInteger('industry_id');
            $table->unsignedSmallInteger('profitability_id');
            $table->decimal('guarantee_amount', 13, 2);

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');
                  
            $table->foreign('industry_id')
                  ->references('id')
                  ->on('company_industry')
                  ->onDelete('cascade');
                  
            $table->foreign('profitability_id')
                  ->references('id')
                  ->on('profitability')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_entities');
    }
};
