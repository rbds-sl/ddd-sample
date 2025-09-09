<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DELETE FROM restaurant_clients
WHERE id IN (
    SELECT id
    FROM (
        SELECT id,
               ROW_NUMBER() OVER (PARTITION BY app_client_id ORDER BY id DESC) AS rn
        FROM restaurant_clients
    ) t
    WHERE rn > 1
);');
        Schema::table('restaurant_clients', static function (Blueprint $table) {
            $table->index(['restaurant_id'], 'restaurant_client_restaurant_id');
            $table->unique(['app','app_client_id'], 'restaurant_client_client_id_client_id_index');
        });
        Schema::table('restaurants', static function (Blueprint $table) {
            $table->unique(['app','app_restaurant_id'], 'restaurant_app_restaurant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
