<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // store id
            $table->tinyInteger('rating')->default(0); // 1-5 bintang
            $table->text('review')->nullable(); // kritik/saran
            $table->timestamps();
        });

        // Tambah kolom is_rated di transactions untuk tracking
        Schema::table('transactions', function (Blueprint $table) {
            $table->boolean('is_rated')->default(false)->after('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('is_rated');
        });
    }
};
