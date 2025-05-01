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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('registration_number'); // Registration number column
            $table->unsignedBigInteger('pic_id'); // Foreign key referencing users.id
            $table->foreign('pic_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('competition_id'); // Foreign key referencing competitions.id
            $table->foreign('competition_id')->references('id')->on('competitions')->onDelete('cascade');
            $table->unsignedBigInteger('group_id'); // Foreign key referencing groups.id
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->string('status'); // Status column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
