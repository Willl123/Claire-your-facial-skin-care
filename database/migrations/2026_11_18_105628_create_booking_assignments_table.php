<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_assignments', function (Blueprint $table) {
            $table->id();

            // Booking yang ditugaskan
            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->cascadeOnDelete();

            // Terapis yang menerima penugasan
            $table->foreignId('therapist_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Status respons penugasan
            $table->enum('status', [
                'pending',
                'accepted',
                'rejected',
                'completed',
                'reassigned'
            ])->default('pending');

            // Alasan jika terapis menolak
            $table->text('rejection_reason')->nullable();

            // Waktu terapis memberikan respons
            $table->timestamp('responded_at')->nullable();

            $table->timestamps();

            $table->index(['therapist_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_assignments');
    }
};
