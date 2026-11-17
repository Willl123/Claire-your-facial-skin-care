<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('place')->default('clinic');
            $table->string('payment_method')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('service_fee')->default(10000);
            $table->unsignedInteger('total_price')->default(10000);
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'place',
                'payment_method',
                'price',
                'service_fee',
                'total_price',
            ]);
        });
    }
};
