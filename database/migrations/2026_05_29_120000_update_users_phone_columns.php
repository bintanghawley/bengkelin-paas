<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            if (!Schema::hasColumn('users', 'nomor_telepon')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('nomor_telepon')->nullable()->unique()->after('name');
                });
            }

            if (Schema::hasColumn('users', 'email')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropUnique(['email']);
                    $table->dropColumn('email');
                });
            }

            if (Schema::hasColumn('users', 'email_verified_at')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('email_verified_at');
                });
            }

            if (Schema::hasColumn('users', 'jenis_kelamin')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('jenis_kelamin');
                });
            }
        }

        Schema::dropIfExists('password_reset_tokens');
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('nomor_telepon')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
            if (Schema::hasColumn('users', 'nomor_telepon')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropUnique(['nomor_telepon']);
                    $table->dropColumn('nomor_telepon');
                });
            }

            if (!Schema::hasColumn('users', 'email')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('email')->unique()->after('name');
                });
            }

            if (!Schema::hasColumn('users', 'email_verified_at')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->timestamp('email_verified_at')->nullable();
                });
            }

            if (!Schema::hasColumn('users', 'jenis_kelamin')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->enum('jenis_kelamin', ['L', 'P']);
                });
            }
        }

        Schema::dropIfExists('password_reset_tokens');
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }
};
