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
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_presensi_id')->constrained('sesi_presensi')->cascadeOnDelete();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->cascadeOnDelete();
            $table->enum('status', ['H','X','-'])->default('X');
            $table->timestamp('waktu_scan')->nullable();
            $table->timestamps();

            $table->unique(['sesi_presensi_id', 'mahasiswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
    }
};
