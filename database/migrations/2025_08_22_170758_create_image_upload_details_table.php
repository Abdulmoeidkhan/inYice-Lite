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
        Schema::create('image_upload_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('uploaded_by')->references('uuid')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->uuid('related_to')->references('uuid')->on('companies')->onUpdate('cascade')->onDelete('restrict');
            $table->string('path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_upload_details');
    }
};
