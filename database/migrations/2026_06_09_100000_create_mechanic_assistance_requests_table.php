<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mechanic_assistance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_booking_id')->constrained('service_bookings')->cascadeOnDelete();
            $table->foreignId('requester_mechanic_id')->constrained('users');
            $table->foreignId('target_mechanic_id')->constrained('users');
            $table->string('needed_item', 255);
            $table->text('reason')->nullable();
            $table->string('location_detail', 500);
            $table->string('maps_url', 1000)->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'completed', 'cancelled'])->default('pending');
            $table->text('response_note')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mechanic_assistance_requests');
    }
};
