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
        Schema::create('fines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('credit_id');
            $table->decimal('amount', 9, 2);
            $table->text('reason');
            $table->timestamp('datetime')->useCurrent();
            $table->timestamp('payed_at')->nullable();

            $table->foreign('credit_id')
                  ->references('id')
                  ->on('credits')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
