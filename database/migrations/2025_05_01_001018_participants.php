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
        Schema::create('participants', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('registration_id'); // Foreign key referencing registrations.id
            $table->foreign('registration_id')->references('id')->on('registrations')->onDelete('cascade');
            $table->string('name'); // Name column
            $table->string('age'); // Age column
            $table->string('nik'); // NIK column
            $table->string('certificate_url'); // Certificate URL column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
