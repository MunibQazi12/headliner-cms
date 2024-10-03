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
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('slug')->nullable();
            $table->text('p_tag')->nullable();
            $table->text('h1_tag')->nullable();
            $table->text('h2_tag')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('state_code')->nullable();
            $table->string('zip_codes')->nullable();
            $table->string('type')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_settings');
    }
};
