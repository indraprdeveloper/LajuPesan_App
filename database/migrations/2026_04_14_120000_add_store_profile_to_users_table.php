<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('address')->nullable()->after('role');
            $table->string('google_maps_link')->nullable()->after('address');
            $table->string('phone')->nullable()->after('google_maps_link');
            $table->string('opening_hours')->nullable()->after('phone');
            $table->string('closing_hours')->nullable()->after('opening_hours');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'google_maps_link', 'phone', 'opening_hours', 'closing_hours']);
        });
    }
};
