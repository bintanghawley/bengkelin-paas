<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mechanic_assistance_requests', function (Blueprint $table) {
            $table->foreignId('emergency_report_id')->nullable()->after('id')->constrained('emergency_reports')->cascadeOnDelete();
        });

        Schema::table('mechanic_assistance_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('service_booking_id');
        });
    }

    public function down(): void
    {
        Schema::table('mechanic_assistance_requests', function (Blueprint $table) {
            $table->foreignId('service_booking_id')->nullable()->after('id')->constrained('service_bookings')->cascadeOnDelete();
        });

        Schema::table('mechanic_assistance_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('emergency_report_id');
        });
    }
};
