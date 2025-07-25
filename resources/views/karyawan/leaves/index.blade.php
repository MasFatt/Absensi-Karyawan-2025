<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pengajuan Cuti & Izin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- BAGIAN TABEL RIWAYAT (SEKARANG DI ATAS) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-end mb-4">
                        <a href="{{ route('karyawan.leaves.create') }}">
                            <x-primary-button>{{ __('Ajukan Cuti/Izin Baru') }}</x-primary-button>
                        </a>
                    </div>

                    @if (session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-2 px-4 border-b">Jenis</th>
                                    <th class="py-2 px-4 border-b">Tanggal</th>
                                    <th class="py-2 px-4 border-b">Bukti</th>
                                    <th class="py-2 px-4 border-b">Status</th>
                                    <th class="py-2 px-4 border-b">Catatan Atasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($leaves as $leave)
                                    <tr class="text-center">
                                        <td class="py-2 px-4 border-b">{{ ucfirst($leave->type) }}</td>
                                        <td class="py-2 px-4 border-b">
                                            {{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }} -
                                            {{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') }}</td>
                                        <td class="py-2 px-4 border-b">
                                            @if ($leave->proof_document)
                                                <a href="{{ asset('storage/' . $leave->proof_document) }}"
                                                    target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            @if ($leave->status == 'pending')
                                                <span
                                                    class="bg-yellow-200 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">Pending</span>
                                            @elseif($leave->status == 'approved')
                                                <span
                                                    class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">Approved</span>
                                            @else
                                                <span
                                                    class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b text-left">{{ $leave->approver_notes ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Belum ada riwayat pengajuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $leaves->links() }}</div>
                </div>
            </div>

            {{-- BAGIAN PANEL INFORMASI (VERSI MODERN) --}}
            <div class="bg-white rounded-xl mt-8 p-8 mx-auto">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-blue-100 rounded-full animate-pulse">
                        <x-heroicon-s-information-circle class="h-10 w-10 text-blue-600" />
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-blue-700">Informasi Pengajuan Cuti & Izin</h2>
                        <p class="mt-2 text-gray-700">
                            Kami memahami pentingnya keseimbangan antara pekerjaan dan kehidupan pribadi. Berikut adalah
                            panduan untuk membantu Anda dalam proses pengajuan cuti dan izin.
                        </p>
                    </div>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    <div
                        class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300 p-5 cursor-pointer group">
                        <h4 class="font-bold text-blue-700 text-lg flex items-center space-x-2">
                            <span>🗓️</span>
                            <span>Cuti Tahunan</span>
                        </h4>
                        <p class="mt-2 text-gray-600 group-hover:text-blue-600 transition-colors duration-300">
                            Anda berhak mendapatkan cuti tahunan setelah memenuhi masa kerja yang ditentukan. Manfaatkan
                            waktu ini untuk beristirahat dan menyegarkan diri.
                        </p>
                    </div>

                    <div
                        class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300 p-5 cursor-pointer group">
                        <h4 class="font-bold text-blue-700 text-lg flex items-center space-x-2">
                            <span>🤒</span>
                            <span>Izin Sakit</span>
                        </h4>
                        <p class="mt-2 text-gray-600 group-hover:text-blue-600 transition-colors duration-300">
                            Kesehatan Anda adalah prioritas. Jika merasa tidak sehat, silakan ajukan izin sakit. Untuk
                            izin lebih dari 1 hari, mohon sertakan surat keterangan dokter agar kami dapat memprosesnya
                            dengan baik.
                        </p>
                    </div>

                    <div
                        class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300 p-5 cursor-pointer group">
                        <h4 class="font-bold text-blue-700 text-lg flex items-center space-x-2">
                            <span>💍</span>
                            <span>Izin Khusus</span>
                        </h4>
                        <p class="mt-2 text-gray-600 group-hover:text-blue-600 transition-colors duration-300">
                            Perusahaan memberikan izin khusus untuk peristiwa penting seperti pernikahan atau jika ada
                            anggota keluarga inti yang meninggal dunia. Silakan ajukan melalui sistem dengan melampirkan
                            dokumen pendukung yang relevan.
                        </p>
                    </div>

                    <div
                        class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300 p-5 cursor-pointer group">
                        <h4 class="font-bold text-blue-700 text-lg flex items-center space-x-2">
                            <span>✅</span>
                            <span>Proses Pengajuan</span>
                        </h4>
                        <p class="mt-2 text-gray-600 group-hover:text-blue-600 transition-colors duration-300">
                            Semua pengajuan akan diproses oleh atasan Anda. Anda dapat memantau statusnya di tabel
                            riwayat di atas dan akan melihat catatan jika ada tanggapan dari atasan.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
