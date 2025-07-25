<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User & Gaji') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $user->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Role -->
                        <div class="mt-4">
                            <x-input-label for="role" :value="__('Role')" />
                            <select id="role" name="role"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="karyawan" @selected(old('role', $user->role) == 'karyawan')>Karyawan</option>
                                <option value="atasan" @selected(old('role', $user->role) == 'atasan')>Atasan</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Gaji Pokok -->
                        <div class="mt-4">
                            <x-input-label for="gaji_pokok" :value="__('Gaji Pokok')" />
                            <x-text-input id="gaji_pokok" class="block mt-1 w-full" type="number" name="gaji_pokok"
                                :value="old('gaji_pokok', $user->gaji_pokok)" required />
                            <x-input-error :messages="$errors->get('gaji_pokok')" class="mt-2" />
                        </div>

                        <!-- Tunjangan Jabatan -->
                        <div class="mt-4">
                            <x-input-label for="tunjangan_jabatan" :value="__('Tunjangan Jabatan')" />
                            <x-text-input id="tunjangan_jabatan" class="block mt-1 w-full" type="number"
                                name="tunjangan_jabatan" :value="old('tunjangan_jabatan', $user->tunjangan_jabatan)" />
                        </div>

                        <!-- Tunjangan Kesehatan -->

                        <div class="mt-4">
                            <x-input-label for="tunjangan_kesehatan" :value="__('Tunjangan Kesehatan')" />
                            <input id="tunjangan_kesehatan" class="block mt-1 w-full bg-gray-100 rounded-lg" type="number" value="70000" readonly />
                        </div>    

                        <!-- Tarif Lembur per Jam -->
                        <div class="mt-4">
                            <x-input-label for="tarif_lembur_per_jam" :value="__('Tarif Lembur per Jam')" />
                            <x-text-input id="tarif_lembur_per_jam" class="block mt-1 w-full" type="number"
                                name="tarif_lembur_per_jam" :value="old('tarif_lembur_per_jam', $user->tarif_lembur_per_jam)" required />
                            <x-input-error :messages="$errors->get('tarif_lembur_per_jam')" class="mt-2" />
                        </div>

                        <!-- Jam Lembur -->
                        <div class="mt-4">
                            <x-input-label for="jam_lembur" :value="__('Jam Lembur')" />
                            <x-text-input id="jam_lembur" class="block mt-1 w-full" type="number" name="jam_lembur"
                                :value="old('jam_lembur', $user->jam_lembur)" />
                        </div>

                        <!-- Tidak Masuk Kerja -->
                        <div class="mt-4">
                            <x-input-label for="tidak_masuk_kerja" :value="__('Tidak Masuk Kerja (Hari)')" />
                            <x-text-input id="tidak_masuk_kerja" class="block mt-1 w-full" type="number"
                                name="tidak_masuk_kerja" :value="old('tidak_masuk_kerja', $user->tidak_masuk_kerja)" />
                        </div>

                        <!-- Bonus & Reward -->
                        <div class="mt-4">
                            <x-input-label for="bonus_reward" :value="__('Bonus & Reward')" />
                            <x-text-input id="bonus_reward" class="block mt-1 w-full" type="number" name="bonus_reward"
                                :value="old('bonus_reward', $user->bonus_reward)" />
                        </div>

                        <!-- Jumlah Telat -->
                        <div class="mt-4">
                            <x-input-label for="jumlah_telat" :value="__('Jumlah Telat (Kali)')" />
                            <x-text-input id="jumlah_telat" class="block mt-1 w-full" type="number" name="jumlah_telat"
                                :value="old('jumlah_telat', $user->jumlah_telat)" />
                        </div>

                        <!-- Punishment -->
                        <div class="mt-4">
                            <x-input-label for="punishment" :value="__('Punishment (Rp)')" />
                            <x-text-input id="punishment" class="block mt-1 w-full" type="number" name="punishment"
                                :value="old('punishment', $user->punishment)" />
                        </div>

                        <!-- Iuran BPJS (JHT) -->
                        <div class="mt-4">
                            <x-input-label for="iuran_bpjs" :value="__('Iuran BPJS (JHT)')" />
                            <input id="iuran_bpjs" class="block mt-1 w-full bg-gray-100 rounded-lg" type="number" value="43000" readonly />
                        </div>          

                        <!-- Submit -->
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
