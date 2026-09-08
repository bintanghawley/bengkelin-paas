<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('jam_booking');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });

        Schema::create('emergency_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mechanic_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_kendaraan');
            $table->string('plat_nomor');
            $table->text('keluhan');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->text('lokasi_detail')->nullable();
            $table->enum('status', ['pending', 'diterima', 'dalam_perjalanan', 'sampai_lokasi', 'selesai', 'ditolak', 'dibatalkan'])->default('pending');
            $table->text('catatan_mekanik')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency_reports');

        Schema::table('service_bookings', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
