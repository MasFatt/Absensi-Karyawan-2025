<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('📝 Proses Pengajuan Lembur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    
                    {{-- 🧾 Detail Pengajuan --}}
                    <div>
                        <h3 class="font-semibold text-lg mb-2">Detail Pengajuan</h3>
                        <div class="border-t border-gray-200 dark:border-gray-600">
                            <dl>
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Karyawan</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        {{ $overtime->user->name }}
                                    </dd>
                                </div>
                                <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Tanggal</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        {{ \Carbon\Carbon::parse($overtime->overtime_date)->format('d F Y') }}
                                    </dd>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Waktu</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        {{ $overtime->start_time }} – {{ $overtime->end_time }}
                                    </dd>
                                </div>
                                <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Alasan</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        {{ $overtime->reason }}
                                    </dd>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Status Saat Ini</dt>
                                    <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                        @switch($overtime->status)
                                            @case('pending')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100 font-medium">
                                                    Pending
                                                </span>
                                                @break
                                            @case('approved')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 font-medium">
                                                    Approved
                                                </span>
                                                @break
                                            @default
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100 font-medium">
                                                    Rejected
                                                </span>
                                        @endswitch
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- ✅ Formulir Proses --}}
                    <form method="POST" action="{{ route('atasan.overtime.update', $overtime) }}">
                        @csrf
                        @method('PUT')

                        {{-- Pilih Status --}}
                        <div>
                            <x-input-label for="status" :value="__('Setujui / Tolak Pengajuan')" />
                            <select id="status" name="status"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                                required>
                                <option value="approved" @selected(old('status', $overtime->status) == 'approved')>Setujui</option>
                                <option value="rejected" @selected(old('status', $overtime->status) == 'rejected')>Tolak</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        {{-- Catatan Atasan --}}
                        <div class="mt-4">
                            <x-input-label for="approver_notes" :value="__('Catatan Atasan (Opsional)')" />
                            <textarea id="approver_notes" name="approver_notes" rows="3"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                            >{{ old('approver_notes', $overtime->approver_notes) }}</textarea>
                            <x-input-error :messages="$errors->get('approver_notes')" class="mt-2" />
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Simpan Keputusan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
