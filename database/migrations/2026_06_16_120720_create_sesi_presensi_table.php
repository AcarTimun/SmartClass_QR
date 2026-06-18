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
        Schema::create('sesi_presensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_kuliah_id')->constrained('jadwal_kuliah')->cascadeOnDelete();
            $table->integer('pertemuan');
            $table->string('qr_token');
            $table->enum('status', ['dibuka','ditutup'])->default('dibuka');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_presensi');
    }
};
