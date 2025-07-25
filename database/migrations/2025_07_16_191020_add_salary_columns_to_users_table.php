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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('gaji_pokok')->default(0)->after('role');
            $table->unsignedBigInteger('tarif_lembur_per_jam')->default(0)->after('gaji_pokok');
            $table->unsignedBigInteger('tunjangan_jabatan')->default(0)->after('tarif_lembur_per_jam');
            $table->unsignedBigInteger('tunjangan_kesehatan')->default(0)->after('tunjangan_jabatan');
            $table->unsignedInteger('jam_lembur')->default(0)->after('tunjangan_kesehatan');
            $table->unsignedInteger('tidak_masuk_kerja')->default(0)->after('jam_lembur');
            $table->unsignedBigInteger('bonus_reward')->default(0)->after('tidak_masuk_kerja');
            $table->unsignedInteger('jumlah_telat')->default(0)->after('bonus_reward');
            $table->unsignedBigInteger('punishment')->default(0)->after('jumlah_telat');
            $table->unsignedBigInteger('iuran_bpjs')->default(0)->after('punishment');
            $table->unsignedBigInteger('total_diterima')->default(0)->after('iuran_bpjs');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'gaji_pokok',
                'tarif_lembur_per_jam',
                'tunjangan_jabatan',
                'tunjangan_kesehatan',
                'jam_lembur',
                'tidak_masuk_kerja',
                'bonus_reward',
                'jumlah_telat',
                'punishment',
                'iuran_bpjs',
                'total_diterima',
            ]);
        });
    }
};
