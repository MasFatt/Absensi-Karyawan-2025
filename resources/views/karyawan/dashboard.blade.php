<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            <x-heroicon-o-user-circle class="w-7 h-7 text-indigo-500" />
            {{ __(key: 'Dashboard Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 space-y-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome & Status --}}
            <div class="bg-white dark:bg-white/5 backdrop-blur-lg shadow-lg border border-gray-200 dark:border-gray-700 rounded-2xl p-6 text-center space-y-4"
                data-tilt>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Selamat datang, {{ Auth::user()->name }}! 👋
                </h3>
                <p class="text-gray-500 dark:text-gray-300">Absensi Hari Ini: <span
                        class="font-semibold">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span></p>
                <p id="clock" class="text-4xl font-extrabold text-indigo-600 dark:text-indigo-400"></p>

                {{-- Notifikasi --}}
                @if (session('status'))
                    <div
                        class="bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400 border border-green-300 dark:border-green-600 px-4 py-3 rounded-md text-sm">
                        ✅ <strong>Sukses:</strong> {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div
                        class="bg-red-100 text-red-800 dark:bg-red-800/20 dark:text-red-400 border border-red-300 dark:border-red-600 px-4 py-3 rounded-md text-sm">
                        ❌ <strong>Gagal:</strong> {{ session('error') }}
                    </div>
                @endif

                {{-- Status Absensi --}}
                @if ($todayAttendance && $todayAttendance->check_out_time)
                    <p class="text-blue-600 dark:text-blue-400 font-semibold">Anda telah menyelesaikan absensi hari ini.
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Masuk:
                        {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }} | Pulang:
                        {{ \Carbon\Carbon::parse($todayAttendance->check_out_time)->format('H:i') }}</p>
                @elseif ($todayAttendance)
                    <p class="text-green-600 dark:text-green-400 font-semibold">Anda telah absen masuk pada
                        {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }}</p>
                @endif

                {{-- Scanner --}}
                @if (!$todayAttendance || !$todayAttendance->check_out_time)
                    <div id="scanner-container" class="w-full max-w-sm mx-auto my-4 hidden">
                        <div id="qr-reader" class="rounded-lg border-2 border-dashed p-4"></div>
                        <button id="close-scanner-button" type="button"
                            class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition">
                            Tutup Kamera
                        </button>
                    </div>

                    <form id="attendance-form" method="POST" action="{{ route('karyawan.attendance.store') }}"
                        class="hidden">
                        @csrf
                        <input type="hidden" name="location" id="location">
                        <input type="hidden" name="qr_token" id="qr_token">
                    </form>

                    <!-- Tombol Scan QR: hanya tampil di desktop (md ke atas) -->
                    <x-primary-button id="scan-button" class="mt-4 hidden md:inline-flex">
                        <x-heroicon-s-qr-code class="w-5 h-5 mr-2" />
                        {{ !$todayAttendance ? 'Scan QR Absen Masuk' : 'Scan QR Absen Pulang' }}
                    </x-primary-button>

                    <!-- Tombol Upload QR: hanya tampil di mobile (sm ke bawah) -->
                    <div class="mt-4 block md:hidden">
                        <label for="qr-image-upload"
                            class="block w-full text-center bg-gray-800 dark:bg-gray-200 text-white py-2 rounded-lg cursor-pointer hover:bg-indigo-500">
                            Upload QR dari Gambar
                        </label>
                        <input type="file" accept="image/*" id="qr-image-upload" style="display: none;" />
                    </div>
                @endif
            </div>

            {{-- Panel Panduan --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 space-y-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white border-b pb-2">Panduan Penggunaan Sistem
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-600 dark:text-gray-300">

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl space-y-2">
                        <div class="flex items-center">
                            <x-heroicon-o-qr-code class="w-6 h-6 mr-2 text-indigo-500" />
                            <h4 class="font-bold">Absensi Harian</h4>
                        </div>
                        <p>
                            Klik tombol <strong>“Scan QR”</strong> untuk absensi masuk/pulang. Kamera dan lokasi harus
                            diaktifkan.
                        </p>

                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl space-y-2">
                        <div class="flex items-center">
                            <x-heroicon-o-clock class="w-6 h-6 mr-2 text-indigo-500" />
                            <h4 class="font-bold">Pengajuan Lembur</h4>
                        </div>
                        <p>
                            Gunakan menu <strong>“Lembur”</strong> untuk ajukan waktu tambahan. Pantau status
                            persetujuan dari halaman tersebut.
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl space-y-2">
                        <div class="flex items-center">
                            <x-heroicon-o-document-text class="w-6 h-6 mr-2 text-indigo-500" />
                            <h4 class="font-bold">Cuti & Izin</h4>
                        </div>
                        <p>
                            Ajukan cuti atau izin melalui menu <strong>“Cuti & Izin”</strong>. Unggah dokumen jika
                            diperlukan (mis. surat sakit).
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const clock = document.getElementById('clock');
                setInterval(() => {
                    const now = new Date();
                    clock.textContent = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });
                }, 1000);

                setTimeout(() => {
                    document.getElementById('alert-success')?.remove();
                    document.getElementById('alert-error')?.remove();
                }, 5000);

                const scanBtn = document.getElementById('scan-button');
                const scanner = document.getElementById('scanner-container');
                const closeBtn = document.getElementById('close-scanner-button');
                const uploadBtn = document.getElementById('upload-button');
                const fileInput = document.getElementById('qr-image-upload');

                let html5QrCode;

                function stopScanner() {
                    if (html5QrCode && html5QrCode.isScanning) {
                        html5QrCode.stop().then(() => {
                            scanner.style.display = 'none';
                            scanBtn.style.display = 'inline-flex';
                        }).catch(err => console.error(err));
                    }
                }

                function onScanSuccess(decodedText) {
                    stopScanner();
                    document.getElementById('qr_token').value = decodedText;

                    navigator.geolocation.getCurrentPosition(position => {
                        document.getElementById('location').value =
                            `${position.coords.latitude},${position.coords.longitude}`;
                        document.getElementById('attendance-form').submit();
                    }, () => {
                        alert('Izin lokasi tidak diberikan.');
                        scanBtn.style.display = 'inline-flex';
                    });
                }

                if (scanBtn) {
                    scanBtn.addEventListener('click', function() {
                        scanner.style.display = 'block';
                        scanBtn.style.display = 'none';

                        if (!html5QrCode) {
                            html5QrCode = new Html5Qrcode("qr-reader");
                        }

                        html5QrCode.start({
                                facingMode: "environment"
                            }, {
                                fps: 10,
                                qrbox: {
                                    width: 250,
                                    height: 250
                                }
                            },
                            onScanSuccess,
                            () => {}
                        ).catch(() => {
                            alert("Kamera gagal diakses. Cek izin perangkat.");
                            stopScanner();
                        });
                    });
                }

                if (closeBtn) {
                    closeBtn.addEventListener('click', stopScanner);
                }

                // ✅ Upload Gambar QR
                if (uploadBtn && fileInput) {
                    uploadBtn.addEventListener('click', () => fileInput.click());

                    fileInput.addEventListener('change', function() {
                        const file = this.files[0];
                        if (!file) {
                            alert("Silakan pilih gambar.");
                            return;
                        }

                        // Tampilkan area scanner sementara jika disembunyikan
                        if (scanner) scanner.style.display = 'block';

                        if (!html5QrCode) {
                            html5QrCode = new Html5Qrcode("qr-reader");
                        }

                        html5QrCode.scanFile(file, true)
                            .then(decodedText => {
                                fileInput.value = ''; // reset input
                                onScanSuccess(decodedText);
                            })
                            .catch(err => {
                                alert("Gagal membaca QR dari gambar.");
                                console.error(err);
                            });
                    });
                }
            });
        </script>
    @endpush

</x-app-layout>
