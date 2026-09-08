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
        Schema::create('service_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->foreignId('mechanic_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_kendaraan');
            $table->string('plat_nomor');
            $table->text('keluhan')->nullable();
            $table->date('tanggal_booking');
            $table->time('jam_booking');
            $table->enum('status', ['pending', 'ditugaskan', 'diproses', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->text('catatan_mekanik')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_bookings');
    }
};
