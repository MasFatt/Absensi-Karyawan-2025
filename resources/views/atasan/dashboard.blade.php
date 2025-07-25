<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 dark:text-white leading-tight tracking-wide flex items-center gap-2">
            <x-heroicon-o-clipboard-document-check class="w-7 h-7 text-indigo-500" />
            {{ __('Dashboard Atasan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- Welcome Card --}}
            <div class="rounded-2xl bg-white/60 dark:bg-white/10 backdrop-blur-md shadow-lg p-6 border border-gray-200 dark:border-gray-700" data-tilt>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Selamat datang, {{ Auth::user()->name }} 👋</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Berikut adalah ringkasan tugas dan status tim Anda.</p>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-2xl bg-gradient-to-br from-yellow-400 to-yellow-500 text-white p-6 shadow-md" data-tilt>
                    <div class="flex items-center space-x-4">
                        <div class="p-4 bg-white/30 rounded-full">
                            <x-heroicon-o-document-text class="w-8 h-8" />
                        </div>
                        <div>
                            <p class="text-sm font-medium">Cuti & Izin Pending</p>
                            <p class="text-3xl font-extrabold">{{ $pendingLeaves }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl bg-gradient-to-br from-orange-400 to-orange-500 text-white p-6 shadow-md" data-tilt>
                    <div class="flex items-center space-x-4">
                        <div class="p-4 bg-white/30 rounded-full">
                            <x-heroicon-o-clock class="w-8 h-8" />
                        </div>
                        <div>
                            <p class="text-sm font-medium">Lembur Pending</p>
                            <p class="text-3xl font-extrabold">{{ $pendingOvertimes }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pengajuan Menunggu --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 space-y-4 border border-gray-200 dark:border-gray-700" data-tilt>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <x-heroicon-o-inbox class="w-6 h-6 text-indigo-500" />
                    Tugas Menunggu Persetujuan
                </h3>

                @if($recentLeaves->isEmpty() && $recentOvertimes->isEmpty())
                    <p class="text-center text-gray-500 dark:text-gray-400 py-6 italic">Tidak ada pengajuan saat ini. 👏</p>
                @else
                    {{-- Cuti --}}
                    @foreach ($recentLeaves as $leave)
                        <div class="flex items-center justify-between bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-800 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                            <div class="flex items-center gap-3">
                                <x-heroicon-s-document-text class="w-6 h-6 text-yellow-500" />
                                <div>
                                    <p class="text-sm font-semibold text-yellow-900 dark:text-yellow-300">{{ $leave->user->name }} mengajukan {{ $leave->type }}</p>
                                    <p class="text-xs text-yellow-800 dark:text-yellow-400">Tanggal: {{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/y') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('atasan.leaves.edit', $leave) }}" class="text-sm font-semibold text-indigo-600 hover:underline">Proses</a>
                        </div>
                    @endforeach

                    {{-- Lembur --}}
                    @foreach ($recentOvertimes as $overtime)
                        <div class="flex items-center justify-between bg-orange-50 dark:bg-orange-900/10 border border-orange-200 dark:border-orange-800 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                            <div class="flex items-center gap-3">
                                <x-heroicon-s-clock class="w-6 h-6 text-orange-500" />
                                <div>
                                    <p class="text-sm font-semibold text-orange-900 dark:text-orange-300">{{ $overtime->user->name }} mengajukan lembur</p>
                                    <p class="text-xs text-orange-800 dark:text-orange-400">Tanggal: {{ \Carbon\Carbon::parse($overtime->overtime_date)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('atasan.overtime.edit', $overtime) }}" class="text-sm font-semibold text-indigo-600 hover:underline">Proses</a>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
