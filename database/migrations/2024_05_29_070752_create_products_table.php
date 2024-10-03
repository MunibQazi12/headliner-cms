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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('available_stock')->nullable();
            $table->boolean('status')->default(1);
            $table->string('slug')->nullable();
            $table->text('h1')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('featured_image')->nullable();
            $table->text('open_graph_title')->nullable();
            $table->text('open_graph_description')->nullable();
            $table->string('open_graph_url')->nullable();
            $table->string('open_graph_image')->nullable();
            $table->json('schema')->nullable();
            $table->text('x_card_title')->nullable();
            $table->text('x_card_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
