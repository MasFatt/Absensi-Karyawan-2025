<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user.
     */
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat user baru.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:karyawan,atasan'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'iuran_bpjs' => 43000,  // default iuran bpjs
            'tunjangan_kesehatan' => 70000,  // default tunjangan kesehatan
        ]);

        return redirect()->route('admin.users.index')->with('status', 'User baru berhasil ditambahkan.');
    }


    /**
     * Menampilkan form untuk edit user.
     */
    public function edit(User $user)
    {
        $iuranBpjs = $user->iuran_bpjs ?? 43000;
        $tunjanganKesehatan = $user->tunjangan_kesehatan ?? 70000;
        
        return view('admin.users.edit', compact('user', 'iuranBpjs', 'tunjanganKesehatan'));
    }

    /**
     * Menyimpan perubahan data user.
     */
public function update(Request $request, User $user)
{
    $request->validate([
        // validation rules...
    ]);

    $gaji_pokok = (float) $request->input('gaji_pokok');
    $tunjangan_jabatan = (float) $request->input('tunjangan_jabatan', 0);
    $tunjangan_kesehatan = (float) $request->input('tunjangan_kesehatan', 70000);
    $tarif_lembur = (float) $request->input('tarif_lembur_per_jam');
    $jam_lembur = (float) $request->input('jam_lembur', 0);
    $bonus_reward = (float) $request->input('bonus_reward', 0);
    $punishment = (float) $request->input('punishment', 0);
    $iuran_bpjs = (float) $request->input('iuran_bpjs', 43000);
    $jumlah_telat = (float) $request->input('jumlah_telat', 0);
    $tidak_masuk_kerja = (float) $request->input('tidak_masuk_kerja', 0);

    $total_gaji = $gaji_pokok
                + $tunjangan_jabatan
                + $tunjangan_kesehatan
                + ($jam_lembur * $tarif_lembur)
                + $bonus_reward;

    $hari_kerja = 26;
    $potongan_per_hari = $gaji_pokok / $hari_kerja;

    $potongan_tidak_masuk = $tidak_masuk_kerja * 92308;
    $potongan_telat = $jumlah_telat * $potongan_per_hari;

    $total_potongan = $potongan_tidak_masuk + $potongan_telat + $punishment + $iuran_bpjs;

    $total_diterima = $total_gaji - $total_potongan;


    $user->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'role' => $request->input('role'),
        'gaji_pokok' => $gaji_pokok,
        'tunjangan_jabatan' => $tunjangan_jabatan,
        'tunjangan_kesehatan' => $tunjangan_kesehatan,
        'tarif_lembur_per_jam' => $tarif_lembur,
        'jam_lembur' => $jam_lembur,
        'tidak_masuk_kerja' => $tidak_masuk_kerja,
        'bonus_reward' => $bonus_reward,
        'jumlah_telat' => $jumlah_telat,
        'punishment' => $punishment,
        'iuran_bpjs' => $iuran_bpjs,
        'total_diterima' => $total_diterima,
    ]);

    return redirect()->route('admin.users.index')->with('status', 'Data user & gaji berhasil diperbarui.');
}
  

    /**
     * Menghapus user dari database.
     */
    public function destroy(User $user)
    {
        // Pencegahan: Jangan biarkan admin menghapus akunnya sendiri
        if (auth()->user()->id === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User berhasil dihapus!');
    }
}