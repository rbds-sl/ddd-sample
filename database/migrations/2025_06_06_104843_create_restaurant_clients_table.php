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
        Schema::create('restaurant_clients', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('app');
            $table->string('app_client_id');
            $table->string('status');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_country_code')->nullable();

            $table->json('preferences');
            $table->json('stats')->nullable();
            $table->json('last_3_months_stats')->nullable();
            $table->integer('stats_updated_at')->nullable();
            $table->string('language')->nullable();
            $table->string('company_name')->nullable();
            $table->json('address')->nullable();
            $table->json('marketing_subscription');
            $table->json('integrations');
            $table->string('dob')->nullable();
            $table->json('custom_properties');
            $table->string('restaurant_id')->nullable();
            $table->integer('added_at');
            $table->timestamp('created_at', 0)->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at', 0)->default(DB::raw('CURRENT_TIMESTAMP'));

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_clients');
    }
};
