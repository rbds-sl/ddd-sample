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
        Schema::create('security_secrets', static function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('client_id')->nullable();
            $table->string('environment')->nullable();
            $table->text('token')->nullable();
            $table->string('url')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('restaurant_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('valid')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_secrets');
    }
};