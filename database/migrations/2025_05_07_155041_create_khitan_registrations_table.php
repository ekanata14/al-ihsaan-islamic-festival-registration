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
        Schema::create('khitan_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number'); // Registration number column
            $table->unsignedBigInteger('pic_id'); // Foreign key referencing users.id
            $table->foreign('pic_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name'); // Name column
            $table->string('age'); // Age column
            $table->string('birth_place'); // Birth Place
            $table->string('birth_date'); // Birth Date
            $table->string('domicile'); // Domicile column
            $table->string('nik'); // NIK column
            $table->boolean('is_sanur')->default(false); // Approval status column
            $table->string('photo_url'); // Certificate URL column
            $table->string('certificate_url'); // Certificate URL column
            $table->string('status'); // Status column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khitan_registrations');
    }
};
