<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_assignments', function (Blueprint $table) {
            $table->enum('admin_status', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending')->after('status');

            $table->timestamp('admin_responded_at')
                ->nullable()
                ->after('responded_at');
        });
    }

    public function down(): void
    {
        Schema::table('booking_assignments', function (Blueprint $table) {
            $table->dropColumn([
                'admin_status',
                'admin_responded_at'
            ]);
        });
    }
};
