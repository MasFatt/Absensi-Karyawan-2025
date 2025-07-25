<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            {{ __('Manajemen User & Gaji') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ====================================================== --}}
            {{--           PANEL INFORMASI PANDUAN MANAJEMEN USER           --}}
            {{-- ====================================================== --}}
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
                <div class="flex">
                    <div class="py-1"><x-heroicon-s-information-circle class="h-6 w-6 text-blue-500 mr-4"/></div>
                    <div>
                        <p class="font-bold">Panduan Halaman Manajemen User</p>
                        <ul class="list-disc list-inside text-sm mt-2">
                            <li>Halaman ini digunakan untuk mengelola data semua pengguna dengan role <strong>Karyawan</strong> dan <strong>Atasan</strong>.</li>
                            <li>Gunakan tombol <strong>"Tambah User Baru"</strong> untuk mendaftarkan akun baru ke dalam sistem.</li>
                            <li>Klik <strong>"Edit"</strong> pada setiap baris untuk mengubah detail, role, serta mengatur <strong>Gaji Pokok</strong> dan <strong>Tarif Lembur</strong> per jam untuk karyawan.</li>
                            <li>Pengguna yang baru ditambahkan akan memiliki Gaji Pokok dan Tarif Lembur <strong>Rp 0</strong> secara default.</li>                         
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.users.create') }}">
                            <x-primary-button>
                                {{ __('Tambah User Baru') }}
                            </x-primary-button>
                        </a>
                    </div>
                    
                    @if (session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-max w-full table-auto border-collapse bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-2 px-4 border-b">Nama</th>
                                    <th class="py-2 px-4 border-b">Email</th>
                                    <th class="py-2 px-4 border-b">Role</th>
                                    <th class="py-2 px-4 border-b">Gaji Pokok</th>
                                    <th class="py-2 px-4 border-b">Tunjangan Jabatan</th>
                                    <th class="py-2 px-4 border-b">Tunjangan Kesehatan</th>
                                    <th class="py-2 px-4 border-b">Jam Lembur</th>
                                    <th class="py-2 px-4 border-b">Tidak Masuk Kerja</th>
                                    <th class="py-2 px-4 border-b">Bonus & Reward</th>
                                    <th class="py-2 px-4 border-b">Jumlah Telat</th>
                                    <th class="py-2 px-4 border-b">Punishment</th>
                                    <th class="py-2 px-4 border-b">Iuran BPJS</th>
                                    <th class="py-2 px-4 border-b">Total</th>
                                    <th class="py-2 px-4 border-b">Total Diterima</th>
                                    <th class="py-2 px-4 border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr class="text-center">
                                        <td class="py-2 px-4 border-b text-left">{{ $user->name }}</td>
                                        <td class="py-2 px-4 border-b text-left">{{ $user->email }}</td>
                                        <td class="py-2 px-4 border-b">{{ ucfirst($user->role) }}</td>
                                        <td class="py-2 px-4 border-b text-right">Rp {{ number_format($user->gaji_pokok, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b text-right">Rp {{ number_format($user->tunjangan_jabatan ?? 0, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b text-right">Rp {{ number_format($user->tunjangan_kesehatan ?? 0, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b text-right">{{ $user->jam_lembur ?? 0 }}</td>
                                        <td class="py-2 px-4 border-b text-right">{{ $user->tidak_masuk_kerja ?? 0 }}</td>
                                        <td class="py-2 px-4 border-b text-right">Rp {{ number_format($user->bonus_reward ?? 0, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b text-right">{{ $user->jumlah_telat ?? 0 }}</td>
                                        <td class="py-2 px-4 border-b text-right">Rp {{ number_format($user->punishment ?? 0, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b text-right">Rp {{ number_format($user->iuran_bpjs ?? 0, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b text-right">Rp {{ number_format($user->total ?? 0, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b text-right">Rp {{ number_format($user->total_diterima, 0, ',', '.') }}</td>                                        
                                        <td class="py-2 px-4 border-b flex justify-center items-center space-x-2">
                                            {{-- Tombol Edit dengan ikon --}}
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                <x-heroicon-s-pencil-square class="h-5 w-5" /> {{-- Ikon pensil untuk edit --}}
                                            </a>
                                            
                                            {{-- Form Delete dengan ikon --}}
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                    <x-heroicon-s-trash class="h-5 w-5" /> {{-- Ikon tempat sampah untuk delete --}}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Tidak ada data user.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>