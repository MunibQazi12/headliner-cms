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
        Schema::table('carts', function (Blueprint $table) {
            $table->string('agency_id')->constrained('seo_settings', 'id')->nullable()->cascadeOnDelete();
            $table->string('address')->nullable();
            $table->dropColumn('shipping_charge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('agency_id');
            $table->dropColumn('address');
            $table->integer('shipping_charge')->default(0);
        });
    }
};
