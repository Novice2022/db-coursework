<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedSmallInteger('entity_type_id');
            $table->string('fullname', 100);
            $table->string('phone', 20)->unique();
            $table->string('address', 255);
            $table->date('registration_date')->default(DB::raw('NOW()'));

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
        Schema::dropIfExists('clients');
    }
};
