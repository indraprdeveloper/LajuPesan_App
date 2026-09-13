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
        Schema::table('transactions', function (Blueprint $table) {
            $table->index(['user_id', 'status']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index(['user_id', 'is_popular']);
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->index(['user_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'is_popular']);
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'slug']);
        });
    }
};
