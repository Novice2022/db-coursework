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
        Schema::create('credit_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('entity_type_id');
            $table->string('name', 50);
            $table->text('description')->nullable();

            $table->foreign('entity_type_id')
                  ->references('id')
                  ->on('entity_type')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_type');
    }
};
