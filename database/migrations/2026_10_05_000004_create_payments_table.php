<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pic_id');
            $table->foreign('pic_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->string('mode')->default('per_anak');
            $table->unsignedInteger('unit_amount')->default(0);
            $table->unsignedInteger('child_count')->default(0);
            $table->unsignedInteger('lomba_count')->default(0);
            $table->unsignedInteger('total_amount')->default(0);
            $table->unsignedInteger('verified_amount')->nullable();
            $table->string('status')->default('belum_bayar');
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->foreign('verified_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            // Satu tagihan per PIC.
            $table->unique('pic_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
