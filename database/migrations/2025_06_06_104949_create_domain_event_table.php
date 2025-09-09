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
        Schema::create('domain_event', function (Blueprint $table) {
            $table->id();
            $table->string('eventName');
            $table->string('relatedId');
            $table->string('initiatorId')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('occurredOn');
            $table->json('data');
            $table->string('stream')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domain_event');
    }
};
