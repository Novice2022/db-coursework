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
        Schema::create('credits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_id');
            $table->unsignedSmallInteger('credit_type_id');
            $table->decimal('amount', 12, 2);
            $table->decimal('rate', 5, 2);
            $table->unsignedSmallInteger('term');
            $table->timestamp('start_date')->useCurrent();
            $table->date('end_date')->nullable();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');
                  
            $table->foreign('credit_type_id')
                  ->references('id')
                  ->on('credit_type')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
