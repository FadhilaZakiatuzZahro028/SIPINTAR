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
    Schema::create('presensi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
        $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
        $table->date('tanggal');
        $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpha']);
        $table->timestamp('waktu');
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();
        $table->timestamps();

        $table->unique(['siswa_id', 'tanggal'], 'presensi_unique');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
