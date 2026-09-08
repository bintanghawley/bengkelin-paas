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
        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedInteger('harga');
            $table->integer('stok')->default(0);
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('jenis_sparepart'); // aki motor, filter udara motor, kampas rem, cairan anti bocor
            $table->string('merek');           // X-Grade, X-Ten, MK, Denso, Jossz, X-Guard, X-Smart
            $table->text('fitur')->nullable();  // list fitur comma-separated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spareparts');
    }
};
