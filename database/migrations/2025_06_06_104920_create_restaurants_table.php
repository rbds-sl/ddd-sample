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
        Schema::create('restaurants', static function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('app');
            $table->string('app_restaurant_id');
            $table->string('name');
            $table->string('status');
            $table->timestamp('created_at', 0)->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at', 0)->default(DB::raw('CURRENT_TIMESTAMP'));

        });

        Schema::table('restaurants', static function (Blueprint $table) {
            $table->index(['app', 'app_restaurant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
