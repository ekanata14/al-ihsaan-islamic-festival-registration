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
        Schema::create('khitan_family_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('khitan_registration_id');
            $table->foreign('khitan_registration_id')->references('id')->on('khitan_registrations')->onDelete('cascade');
            $table->string('family_card_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khitan_family_cards');
    }
};
