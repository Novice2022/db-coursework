<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('individual_entities', function (Blueprint $table) {
            $table->index('client_id');
        });
        
        Schema::table('legal_entities', function (Blueprint $table) {
            $table->index('client_id');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->index('name');
        });
        
        Schema::table('credits', function (Blueprint $table) {
            $table->index('client_id');
        });
        
        Schema::table('payments', function (Blueprint $table) {
            $table->index('credit_id');
        });
        
        Schema::table('fines', function (Blueprint $table) {
            $table->index('credit_id');
        });
    }
    
    public function down(): void
    {
        Schema::table('individual_entities', function (Blueprint $table) {
            $table->dropIndex(['client_id']);
        });
        
        Schema::table('legal_entities', function (Blueprint $table) {
            $table->dropIndex(['client_id']);
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });
        
        Schema::table('credits', function (Blueprint $table) {
            $table->dropIndex(['client_id']);
        });
        
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['credit_id']);
        });
        
        Schema::table('fines', function (Blueprint $table) {
            $table->dropIndex(['credit_id']);
        });
    }
};