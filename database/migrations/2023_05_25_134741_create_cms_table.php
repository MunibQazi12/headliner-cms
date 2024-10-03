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
        Schema::create('cms', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->longText('text_content')->nullable();
            $table->text('heading')->nullable();
            $table->text('sub_title_one')->nullable();
            $table->text('sub_title_two')->nullable();
            $table->longText('short_desc')->nullable();
            $table->longText('button_text')->nullable();
            $table->longText('button_url')->nullable();
            $table->string('image')->nullable();
            $table->string('featured_image')->nullable();
            $table->text('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->text('open_graph_title')->nullable();
            $table->longText('open_graph_description')->nullable();
            $table->string('open_graph_url')->nullable();
            $table->string('open_graph_image')->nullable();
            $table->text('x_card_title')->nullable();
            $table->longText('x_card_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms');
    }
};
