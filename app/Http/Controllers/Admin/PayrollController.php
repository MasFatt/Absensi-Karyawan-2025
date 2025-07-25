<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Overtime;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $employees = User::where('role', 'karyawan')->get();
        $payrollData = [];

        foreach ($employees as $employee) {
            $totalOvertimeHours = Overtime::where('user_id', $employee->id)
                ->where('status', 'approved')
                ->whereMonth('overtime_date', $bulan)
                ->whereYear('overtime_date', $tahun)
                ->get()
                ->reduce(function ($carry, $item) {
                    $start = Carbon::parse($item->start_time);
                    $end = Carbon::parse($item->end_time);
                    return $carry + $end->diffInHours($start);
                }, 0);

            $totalAttendanceDays = Attendance::where('user_id', $employee->id)
                ->whereMonth('attendance_date', $bulan)
                ->whereYear('attendance_date', $tahun)
                ->count();

            $totalHariKerja = Carbon::create($tahun, $bulan)->daysInMonth;
            // $tidakMasukKerja = $totalHariKerja - $totalAttendanceDays;
            $tidakMasukKerja = $employee->tidak_masuk_kerja ?? ($totalHariKerja - $totalAttendanceDays);


            $gajiPokok = $employee->gaji_pokok ?? 0;
            $tunjanganJabatan = $employee->tunjangan_jabatan ?? 0;
            $tunjanganKesehatan = 70000; // tetap
            $bonusReward = $employee->bonus_reward ?? 0;
            $jumlahTelat = $employee->jumlah_telat ?? 0;
            $punishment = $employee->punishment ?? 0;
            $iuranBpjs = 43000; // tetap
            $tarifLembur = $employee->tarif_lembur_per_jam ?? 0;
            $upahLembur = $totalOvertimeHours * $tarifLembur;

            // Potongan telat (sekarang 0, bisa disesuaikan)
            $potonganTelat = $jumlahTelat * 0;

            $potonganPerHari = $gajiPokok / $totalHariKerja;
            $potonganTidakMasuk = $tidakMasukKerja * 92308;

            $total = $gajiPokok + $tunjanganJabatan + $tunjanganKesehatan + $upahLembur + $bonusReward;
            $totalPotongan = $potonganTelat + $punishment + $iuranBpjs + $potonganTidakMasuk;
            $totalDiterima = $total - $totalPotongan;

            $payrollData[] = [
                'user' => $employee,
                'total_kehadiran' => $totalAttendanceDays,
                'gaji_pokok' => $gajiPokok,
                'tarif_lembur_per_jam' => $tarifLembur,
                'tunjangan_jabatan' => $tunjanganJabatan,
                'tunjangan_kesehatan' => $tunjanganKesehatan,
                'jam_lembur' => $totalOvertimeHours,
                'tidak_masuk_kerja' => $tidakMasukKerja,
                'bonus_reward' => $bonusReward,
                'jumlah_telat' => $jumlahTelat,
                'punishment' => $punishment,
                'iuran_bpjs' => $iuranBpjs,
                'total_diterima' => $totalDiterima,
            ];
        }

        return view('admin.payroll.index', compact('payrollData', 'bulan', 'tahun'));
    }

    public function generatePayslip(Request $request, User $user)
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $totalOvertimeHours = Overtime::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereMonth('overtime_date', $bulan)
            ->whereYear('overtime_date', $tahun)
            ->get()
            ->reduce(function ($carry, $item) {
                $start = Carbon::parse($item->start_time);
                $end = Carbon::parse($item->end_time);
                return $carry + $end->diffInHours($start);
            }, 0);

        $totalAttendanceDays = Attendance::where('user_id', $user->id)
            ->whereMonth('attendance_date', $bulan)
            ->whereYear('attendance_date', $tahun)
            ->count();

        $totalHariKerja = Carbon::create($tahun, $bulan)->daysInMonth;
        $tidakMasukKerja = $user->tidak_masuk_kerja ?? ($totalHariKerja - $totalAttendanceDays);

        $gajiPokok = $user->gaji_pokok ?? 0;
        $tunjanganJabatan = $user->tunjangan_jabatan ?? 0;
        $tunjanganKesehatan = 70000; // tetap
        $bonusReward = $user->bonus_reward ?? 0;
        $jumlahTelat = $user->jumlah_telat ?? 0;
        $punishment = $user->punishment ?? 0;
        $iuranBpjs = 43000; // tetap
        $tarifLembur = $user->tarif_lembur_per_jam ?? 0;

        // Potongan telat, bisa diubah sesuai aturan
        $potonganTelat = 0;

        $potonganPerHari = $gajiPokok / $totalHariKerja;
        $potonganTidakMasuk = $tidakMasukKerja * 92308;

        $upahLembur = $totalOvertimeHours * $tarifLembur;

        $total = $gajiPokok + $tunjanganJabatan + $tunjanganKesehatan + $upahLembur + $bonusReward;
        $totalPotongan = $potonganTelat + $punishment + $iuranBpjs + $potonganTidakMasuk;
        $totalDiterima = $total - $totalPotongan;

        $data = [
            'user' => $user,
            'total_kehadiran' => $totalAttendanceDays,
            'bulan' => Carbon::create()->month($bulan)->translatedFormat('F'),
            'tahun' => $tahun,
            'gaji_pokok' => $gajiPokok,
            'tarif_lembur_per_jam' => $tarifLembur,
            'tunjangan_jabatan' => $tunjanganJabatan,
            'tunjangan_kesehatan' => $tunjanganKesehatan,
            'jam_lembur' => $totalOvertimeHours,
            'tidak_masuk_kerja' => $tidakMasukKerja,
            'bonus_reward' => $bonusReward,
            'jumlah_telat' => $jumlahTelat,
            'punishment' => $punishment,
            'iuran_bpjs' => $iuranBpjs,
            'total_diterima' => $totalDiterima,
        ];

        $pdf = Pdf::loadView('admin.payroll.payslip', $data);

        return $pdf->download('slip-gaji-' . $user->name . '-' . $bulan . '-' . $tahun . '.pdf');
    }
}
