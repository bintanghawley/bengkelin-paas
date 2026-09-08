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
        Schema::create('oils', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedInteger('harga');
            $table->integer('stok')->default(0);
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('jenis_oli');  // oli motor matic, oli motor bebek, oli motor sport
            $table->string('kekentalan'); // 10W30, 10W40, 20W50
            $table->string('ukuran');     // 1 L, 30ML, 40ML, 120ML, 200 ml, 200ML, 500ML, 800 mL, 800 ml, 900 ml, 900 mL
            $table->string('tipe_oli');   // Oli Double Ester, Oli Ester, Oli Gear, Oli Semi Sintetik
            $table->string('merek');      // Yamalube, MPX, Federal Oil, Motul, Castrol, Shell, dll.
            $table->text('fitur')->nullable(); // list fitur comma-separated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oils');
    }
};
