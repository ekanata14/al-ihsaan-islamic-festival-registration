<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->integer('participant_number');
            $table->unsignedBigInteger('pic_id');
            $table->foreign('pic_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('participant_id'); // Foreign key referencing registrations.id
            $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
            $table->unsignedBigInteger('registration_id'); // Foreign key referencing registrations.id
            $table->foreign('registration_id')->references('id')->on('registrations')->onDelete('cascade');
            $table->unsignedBigInteger('competition_id'); // Foreign key referencing registrations.id
            $table->foreign('competition_id')->references('id')->on('competitions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};
