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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('owner_uuid')->unique()->nullable();
            $table->string('name')->unique();
            $table->string('display_name')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('image')->nullable();
            $table->string('contact')->nullable();
            $table->string('industry')->nullable();
            $table->string('code')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('bank_details')->nullable();
            $table->string('other_details')->nullable();
            $table->json('social_links')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
