<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'guru', 'guru_bk'])->default('guru')->after('email');
            $table->boolean('is_wali_kelas')->default(false)->after('role');
            $table->string('nip')->nullable()->unique()->after('is_wali_kelas');
            $table->boolean('is_active')->default(true)->after('nip');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_wali_kelas', 'nip', 'is_active']);
        });
    }
};