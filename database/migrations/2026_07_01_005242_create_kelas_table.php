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
    Schema::create('kelas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->cascadeOnDelete();
        $table->foreignId('wali_kelas_id')->nullable()->constrained('users')->nullOnDelete();
        $table->enum('tingkat', ['X', 'XI', 'XII']);
        $table->enum('jurusan', ['IPA', 'IPS']);
        $table->unsignedTinyInteger('nomor');
        $table->timestamps();

        $table->unique(['tahun_ajaran_id', 'tingkat', 'jurusan', 'nomor']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('kelas');
}
};
