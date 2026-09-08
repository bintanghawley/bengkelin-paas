<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'sqlite') {
            return;
        }

        Schema::table('service_bookings', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'sqlite') {
            return;
        }

        Schema::table('service_bookings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'ditugaskan', 'diproses', 'selesai', 'dibatalkan'])->default('pending')->change();
        });
    }
};
