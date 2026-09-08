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
        Schema::create('tires', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedInteger('harga');
            $table->integer('stok')->default(0);
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('jenis_ban'); // ban motor matic, ban motor bebek, ban motor sport, ban motor big matic
            $table->string('merek');     // aspira, planeto, Michelin, irc, Pirelli, ecostreet, presa, swallow, Dunlop, kenda, fdr
            $table->string('ukuran_ban'); // 70/90, 80/80, 80/90, 90/80, 90/90, 100/80, 100/90, 110/70, 110/80, 110/90, 120/70, 120/80, 130/70, 130/80, 140/70, 150/60, 150/70, 160/60
            $table->string('posisi_ban'); // belakang, depan, depan/belakang
            $table->string('material')->default('medium compound');
            $table->string('diameter');   // Ring 10, Ring 11, Ring 12, Ring 13, Ring 14, Ring 17
            $table->string('tipe');       // tubeless, tubetype
            $table->text('fitur')->nullable(); // list fitur comma-separated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tires');
    }
};
