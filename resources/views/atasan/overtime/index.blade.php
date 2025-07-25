<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pengajuan Lembur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ====================================================== --}}
            {{--         PANEL INFORMASI PANDUAN PERSETUJUAN          --}}
            {{-- ====================================================== --}}
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
                <div class="flex">
                    <div class="py-1"><x-heroicon-s-information-circle class="h-6 w-6 text-blue-500 mr-4"/></div>
                    <div>
                        <p class="font-bold">Panduan Halaman Persetujuan Lembur</p>
                        <ul class="list-disc list-inside text-sm mt-2">
                            <li>Halaman ini menampilkan semua <strong>pengajuan lembur</strong> dari karyawan yang menjadi tanggung jawab Anda.</li>
                            <li><strong>Tinjau</strong> setiap pengajuan dengan saksama. Pastikan <strong>alasan</strong> yang diberikan <strong>relevan</strong> dan <strong>mendesak</strong>.</li>
                            <li>Klik tombol <strong>"Test"</strong> untuk melihat <strong>detail pengajuan</strong> dan memberikan keputusan (<strong>Setuju/Tolak</strong>).</li>
                            <li>Gunakan kolom <strong>"Catatan Atasan"</strong> saat memproses untuk memberikan <strong>feedback yang jelas</strong> kepada karyawan.</li>                            
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if (session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-2 px-4 border-b">Karyawan</th>
                                    <th class="py-2 px-4 border-b">Tanggal</th>
                                    <th class="py-2 px-4 border-b">Waktu</th>
                                    <th class="py-2 px-4 border-b">Status</th>
                                    <th class="py-2 px-4 border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($overtimes as $overtime)
                                    <tr class="text-center">
                                        <td class="py-2 px-4 border-b text-left">{{ $overtime->user->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($overtime->overtime_date)->format('d/m/Y') }}</td>
                                        <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($overtime->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($overtime->end_time)->format('H:i') }}</td>
                                        <td class="py-2 px-4 border-b">
                                             @if($overtime->status == 'pending')
                                                <span class="bg-yellow-200 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">Pending</span>
                                            @elseif($overtime->status == 'approved')
                                                <span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">Approved</span>
                                            @else
                                                <span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <a href="{{ route('atasan.overtime.edit', $overtime) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <x-secondary-button>
                                                    Proses
                                                </x-secondary-button>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Tidak ada pengajuan lembur.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $overtimes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
