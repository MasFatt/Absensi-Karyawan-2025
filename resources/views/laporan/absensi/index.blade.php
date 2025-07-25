<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Laporan Absensi Bulanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Panel Informasi Panduan --}}
            <div class="bg-blue-50 border border-blue-300 rounded-lg shadow-md p-5 flex items-start space-x-4">
                <x-heroicon-s-information-circle class="h-8 w-8 text-blue-500 flex-shrink-0" />
                <div class="text-blue-700 dark:text-blue-300">
                    <p class="font-semibold text-lg mb-2">Panduan Membaca Laporan Absensi</p>
                    <ul class="list-disc list-inside text-sm space-y-1 max-w-prose leading-relaxed">
                        <li>Gunakan filter di atas untuk melihat laporan pada bulan dan tahun yang diinginkan.</li>
                        <li>Kolom <span class="font-bold text-green-600">H</span> adalah total hari kehadiran karyawan pada periode tersebut.</li>
                        <li>Kolom <span class="font-bold text-red-600">A</span> adalah total hari karyawan tidak melakukan absensi (Alpha).</li>
                        <li>Sel absensi berwarna <span class="bg-red-100 text-red-800 font-semibold px-1 rounded">merah muda</span> menandakan keterlambatan.</li>
                        <li>Sel <span class="text-gray-500 font-semibold">L</span> menandakan hari libur akhir pekan.</li>
                    </ul>
                </div>
            </div>

            {{-- Form Filter Bulan & Tahun --}}
            <form method="GET" action="{{ route('laporan.absensi.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-end">
                <div>
                    <label for="bulan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bulan</label>
                    <select name="bulan" id="bulan" class="block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                    <input type="number" name="tahun" id="tahun" value="{{ $tahun }}" min="2000" max="2100"
                        class="block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
                </div>
                <div>
                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition font-semibold">
                        Filter
                    </button>
                </div>
            </form>

            {{-- Tabel Laporan --}}
            <div class="relative overflow-x-auto rounded-lg shadow border border-gray-200 dark:border-gray-700">

                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-auto">
                    <thead class="bg-gray-50 dark:bg-gray-800 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider sticky left-0 bg-gray-50 dark:bg-gray-800 shadow-sm">Karyawan</th>
                            @php
                                $daysInMonth = \Carbon\Carbon::createFromDate($tahun, $bulan)->daysInMonth;
                            @endphp
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ $day }}</th>
                            @endfor
                            <th class="px-3 py-3 text-center text-xs font-semibold text-green-700 bg-green-100 dark:bg-green-900 dark:text-green-300 uppercase tracking-wider">H</th>
                            <th class="px-3 py-3 text-center text-xs font-semibold text-red-700 bg-red-100 dark:bg-red-900 dark:text-red-300 uppercase tracking-wider">A</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($karyawan as $user)
                            @php
                                $hadirCount = 0;
                                $alphaCount = 0;
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100 sticky left-0 bg-white dark:bg-gray-900 shadow-sm">
                                    {{ $user->name }}
                                </td>

                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $currentDate = \Carbon\Carbon::createFromDate($tahun, $bulan, $day);
                                        $attendance = $user->attendances->firstWhere('attendance_date', $currentDate->toDateString());
                                        $isWeekend = $currentDate->dayOfWeek === \Carbon\Carbon::SUNDAY;
                                        $isLate = $attendance && \Carbon\Carbon::parse($attendance->check_in_time)->gt(\Carbon\Carbon::parse($jamMasukSetting));
                                        if ($attendance) $hadirCount++;
                                        if (!$attendance && !$isWeekend) $alphaCount++;
                                    @endphp
                                    <td
                                        class="px-2 py-2 whitespace-nowrap text-center text-xs font-semibold
                                        {{ $isWeekend ? 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-default' : '' }}
                                        {{ $isLate ? 'bg-red-100 dark:bg-red-700 text-red-700 dark:text-red-300' : '' }}
                                        {{ !$attendance && !$isWeekend ? 'text-red-500 dark:text-red-400' : '' }}"
                                        @if($attendance)
                                            title="Check-in: {{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') }}"
                                        @elseif($isWeekend)
                                            title="Hari Libur"
                                        @else
                                            title="Alpha (Tidak Absen)"
                                        @endif
                                    >
                                        @if ($attendance)
                                            {{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') }}
                                        @elseif($isWeekend)
                                            L
                                        @else
                                            A
                                        @endif
                                    </td>
                                @endfor

                                <td class="px-3 py-3 whitespace-nowrap text-center text-sm font-bold text-green-700 bg-green-100 dark:bg-green-900 dark:text-green-300">
                                    {{ $hadirCount }}
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap text-center text-sm font-bold text-red-700 bg-red-100 dark:bg-red-900 dark:text-red-300">
                                    {{ $alphaCount }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</x-app-layout>
