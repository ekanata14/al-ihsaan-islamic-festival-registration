<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->after('nominal');
            $table->boolean('is_active')->default(true)->after('sort_order');
            $table->string('website_url')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn(['sort_order', 'is_active', 'website_url']);
        });
    }
};
