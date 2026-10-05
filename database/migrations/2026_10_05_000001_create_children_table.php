<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pic_id');
            $table->foreign('pic_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('age');
            $table->string('birth_place');
            $table->string('birth_date');
            $table->string('nik');
            $table->timestamps();

            // Satu anak unik per PIC berdasarkan NIK.
            $table->unique(['pic_id', 'nik']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
