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
        Schema::table('purchases', function (Blueprint $table) {
            $table->integer('jumlah')->default(1)->after('harga');
            $table->integer('total_harga')->default(0)->after('jumlah');
            $table->text('alamat')->nullable()->after('total_harga');
            $table->string('telepon')->nullable()->after('alamat');
            $table->string('metode_pembayaran')->default('COD')->after('telepon');
            $table->text('catatan')->nullable()->after('metode_pembayaran');
            $table->string('status')->default('pending')->after('catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn([
                'jumlah',
                'total_harga',
                'alamat',
                'telepon',
                'metode_pembayaran',
                'catatan',
                'status'
            ]);
        });
    }
};
