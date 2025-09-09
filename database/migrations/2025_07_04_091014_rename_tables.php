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
        Schema::rename('restaurant_clients', 'crm_restaurant_clients');
        Schema::rename('restaurants', 'crm_restaurants');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
