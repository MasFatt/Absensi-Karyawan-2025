<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Slip Gaji - {{ $user->name }}</title>
  <style>
    @page {
      size: A4;
      margin: 20mm;
    }

    body {
      font-family: 'Helvetica', sans-serif;
      font-size: 12px;
      margin: 0;
      padding: 0;
      background: #fff;
      color: #222;
      -webkit-print-color-adjust: exact;
    }

    .container {
      width: 100%;
      max-width: 170mm;
      margin: 0 auto;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
      color: #0047b3;
    }

    .header p {
      margin: 2px 0;
      font-size: 11px;
      color: #555;
    }

    .title {
      text-align: center;
      font-size: 16px;
      font-weight: bold;
      margin-top: 15px;
      color: #0047b3;
    }

    .period {
      text-align: center;
      margin-bottom: 15px;
      font-size: 12px;
      color: #555;
    }

    .content table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .content th,
    .content td {
      border: 1px solid #ddd;
      padding: 8px;
      font-size: 12px;
    }

    .content th {
      background-color: #f2f2f2;
      text-align: left;
    }

    .text-right {
      text-align: right;
    }

    .total-row {
      background: #0047b3;
      color: #fff;
      font-weight: bold;
    }

    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 10px;
      color: #777;
      border-top: 1px solid #ccc;
      padding-top: 10px;
    }

    @media print {
      .container {
        box-shadow: none;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>PT. Nama Perusahaan Anda</h1>
      <p>Jl. Contoh Alamat No.123, Jakarta</p>
      <p>Telp: (021) 12345678 | Email: info@perusahaan.com</p>
      <hr style="border: 1px solid #ccc; margin: 10px 0;">

    </div>

    <div class="title">SLIP GAJI</div>
    <div class="period">Periode: {{ $bulan ?? '-' }} {{ $tahun ?? '-' }}</div>

    <div class="content">
      <table>
        <tbody>
          <tr>
            <th>Nama Karyawan</th>
            <td>{{ $user->name ?? '-' }}</td>
          </tr>
          <tr>
            <th>Role</th>
            <td>{{ ucfirst($user->role ?? '-') }}</td>
          </tr>
        </tbody>
      </table>

      <table>
        <thead>
          <tr>
            <th>Keterangan</th>
            <th class="text-right">Jumlah (Rp)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Gaji Pokok</td>
            <td class="text-right">Rp {{ number_format($gaji_pokok ?? 0, 0, ',', '.') }}</td>
          </tr>
          <tr>
            <td>Tunjangan Jabatan</td>
            <td class="text-right">Rp {{ number_format($tunjangan_jabatan ?? 0, 0, ',', '.') }}</td>
          </tr>
          <tr>
            <td>Tunjangan Kesehatan</td>
            <td class="text-right">Rp {{ number_format($tunjangan_kesehatan ?? 0, 0, ',', '.') }}</td>
          </tr>
          <tr>
            <td>Upah Lembur ({{ $jam_lembur ?? 0 }} Jam)</td>
            <td class="text-right">Rp {{ number_format(($tarif_lembur_per_jam ?? 0) * ($jam_lembur ?? 0), 0, ',', '.') }}</td>
          </tr>
          <tr>
            <td>Bonus & Reward</td>
            <td class="text-right">Rp {{ number_format($bonus_reward ?? 0, 0, ',', '.') }}</td>
          </tr>
        </tbody>
      </table>

      <table>
        <thead>
          <tr>
            <th>Keterangan</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Jumlah Telat</td>
            <td class="text-right">{{ $jumlah_telat ?? 0 }} Kali</td>
          </tr>
          <tr>
            <td>Punishment</td>
            <td class="text-right">-Rp {{ number_format($punishment ?? 0, 0, ',', '.') }}</td>
          </tr>
          <tr>
            <td>Iuran BPJS</td>
            <td class="text-right">-Rp {{ number_format($iuran_bpjs ?? 0, 0, ',', '.') }}</td>
          </tr>
          <tr>
            <td>Tidak Masuk Kerja</td>
            <td class="text-right">{{ $tidak_masuk_kerja ?? 0 }} Hari</td>
          </tr>
          <tr class="total-row">
            <td>Total Potongan</td>
            <td class="text-right">-Rp {{ number_format(($punishment ?? 0) + ($iuran_bpjs ?? 0), 0, ',', '.') }}</td>
          </tr>
        </tbody>
      </table>

      <table>
        <thead>
          <tr class="total-row" style="background:#dbeafe; color:#0047b3;">
            <td>Total Gaji Diterima</td>
            <td class="text-right">Rp {{ number_format($total_diterima ?? 0, 0, ',', '.') }}</td>
          </tr>
        </thead>
      </table>
    </div>

    <div class="footer">
      Slip ini dihasilkan otomatis oleh sistem. Tidak memerlukan tanda tangan.<br>
      Terima kasih atas dedikasi dan kerja keras Anda.
    </div>
  </div>
</body>

</html>
