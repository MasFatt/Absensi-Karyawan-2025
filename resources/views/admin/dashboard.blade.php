<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <x-heroicon-o-presentation-chart-bar class="w-7 h-7 text-indigo-500" />
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            {{-- Kartu Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $cards = [
                        ['label' => 'Total Karyawan', 'value' => $totalKaryawan, 'icon' => 'users', 'color' => 'from-blue-500 to-blue-700'],
                        ['label' => 'Total Atasan', 'value' => $totalAtasan, 'icon' => 'user-group', 'color' => 'from-green-500 to-green-700'],
                        ['label' => 'Cuti Pending', 'value' => $pendingLeaves, 'icon' => 'document-text', 'color' => 'from-yellow-400 to-yellow-600'],
                        ['label' => 'Lembur Pending', 'value' => $pendingOvertimes, 'icon' => 'clock', 'color' => 'from-rose-500 to-red-600'],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <div class="rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 bg-gradient-to-br {{ $card['color'] }} text-white p-6 flex items-center gap-4 transform hover:scale-[1.02]">
                        <div class="p-4 bg-white bg-opacity-20 rounded-full">
                            <x-dynamic-component :component="'heroicon-o-' . $card['icon']" class="w-8 h-8" />
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ $card['label'] }}</p>
                            <p class="text-3xl font-bold">{{ $card['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Panel Aktivitas Terbaru --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-heroicon-o-calendar class="w-6 h-6 text-indigo-500" />
                    Aktivitas Terbaru
                </h3>

                <div class="space-y-4">
                    @forelse ($recentLogs as $log)
                        <div class="flex items-start gap-4 p-4 rounded-xl shadow-sm hover:shadow-md bg-gray-50 dark:bg-gray-700 transition duration-200 border border-transparent hover:border-indigo-400">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-600 flex items-center justify-center text-sm font-bold text-indigo-700 dark:text-white">
                                {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800 dark:text-white leading-snug">
                                    <span class="font-semibold">{{ $log->user->name ?? 'Sistem' }}</span>
                                    {{ str_replace('_', ' ', $log->activity) }}
                                    <span class="text-indigo-600 font-bold">#{{ $log->auditable_id }}</span>
                                    <span class="text-gray-500 dark:text-gray-300">({{ class_basename($log->auditable_type) }})</span>.
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 dark:text-gray-400 italic">Belum ada aktivitas tercatat.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
