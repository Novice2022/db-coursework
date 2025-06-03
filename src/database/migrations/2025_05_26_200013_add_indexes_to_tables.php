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
        Schema::table('tables', function (Blueprint $table) {
            DB::statement('CREATE INDEX individual_idx ON individual_entities USING HASH (client_id)');
            DB::statement('CREATE INDEX legal_idx ON legal_entities USING HASH (client_id)');
            DB::statement('CREATE INDEX users_name_idx ON users USING HASH (name)');
            DB::statement('CREATE INDEX credits_idx ON credits USING HASH (client_id)');
            DB::statement('CREATE INDEX payments_idx ON payments USING HASH (credit_id)');
            DB::statement('CREATE INDEX fines_idx ON fines USING HASH (credit_id)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('individual_entities', function ($table) {
            $table->dropIndex('individual_idx');
        });
        Schema::table('legal_entities', function ($table) {
            $table->dropIndex('legal_idx');
        });
        Schema::table('clients', function ($table) {
            $table->dropIndex('users_name_idx');
        });
        Schema::table('credits', function ($table) {
            $table->dropIndex('credits_idx');
        });
        Schema::table('payments', function ($table) {
            $table->dropIndex('payments_idx');
        });
        Schema::table('fines', function ($table) {
            $table->dropIndex('fines_idx');
        });
    }
};
