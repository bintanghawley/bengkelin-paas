<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Update status enum: pending → diterima/ditolak → diproses → selesai
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            // For MySQL: modify the enum column
            DB::statement("ALTER TABLE service_bookings MODIFY COLUMN status ENUM('pending','diterima','ditolak','diproses','selesai','dibatalkan') NOT NULL DEFAULT 'pending'");
        } elseif ($driver === 'pgsql') {
            // For PostgreSQL: update column definition safely
            DB::statement("ALTER TABLE service_bookings DROP CONSTRAINT IF EXISTS service_bookings_status_check");
            DB::statement("ALTER TABLE service_bookings ADD CONSTRAINT service_bookings_status_check CHECK (status::text IN ('pending', 'diterima', 'ditolak', 'diproses', 'selesai', 'dibatalkan'))");
        }

        // Migrate old 'ditugaskan' values to 'diterima'
        DB::statement("UPDATE service_bookings SET status = 'diterima' WHERE status = 'ditugaskan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: map back old values
        DB::statement("UPDATE service_bookings SET status = 'ditugaskan' WHERE status = 'diterima'");
        DB::statement("UPDATE service_bookings SET status = 'dibatalkan' WHERE status = 'ditolak'");
        
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE service_bookings MODIFY COLUMN status ENUM('pending','ditugaskan','diproses','selesai','dibatalkan') NOT NULL DEFAULT 'pending'");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE service_bookings DROP CONSTRAINT IF EXISTS service_bookings_status_check");
            DB::statement("ALTER TABLE service_bookings ADD CONSTRAINT service_bookings_status_check CHECK (status::text IN ('pending', 'ditugaskan', 'diproses', 'selesai', 'dibatalkan'))");
        }
    }
};
