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
        Schema::create('dry_ice_by_cities', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('h1_tag')->nullable();
            $table->text('city_lowercase')->nullable();
            $table->string('state_short_abbr')->nullable();
            $table->string('city')->nullable();
            $table->string('state_code')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_codes')->nullable();
            $table->string('type')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('faq_q_1')->nullable();
            $table->text('faq_a_1')->nullable();
            $table->text('faq_q_2')->nullable();
            $table->text('faq_a_2')->nullable();
            $table->text('faq_q_3')->nullable();
            $table->text('faq_a_3')->nullable();
            $table->text('faq_q_4')->nullable();
            $table->text('faq_a_4')->nullable();
            $table->text('faq_q_5')->nullable();
            $table->text('faq_a_5')->nullable();
            $table->text('faq_q_6')->nullable();
            $table->text('faq_a_6')->nullable();
            $table->text('faq_q_7')->nullable();
            $table->text('faq_a_7')->nullable();
            $table->boolean('status')->default(true)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dry_ice_by_cities');
    }
};
