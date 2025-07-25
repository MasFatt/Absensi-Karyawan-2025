<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 flex items-center gap-2">
            {{ __('QR Code Absensi Hari Ini') }}
        </h2>
    </x-slot>

    <div class="w-full max-w-3xl mx-auto px-6 py-12 text-center">
        <p class="mb-8 text-black text-lg font-medium">
            Tunjukkan QR Code ini kepada karyawan untuk melakukan absensi.
        </p>

        {{-- QR Code Container tanpa bg putih --}}
        <div id="qr-container"
            class="inline-block p-6 rounded-3xl"
            style="background: radial-gradient(circle at center, rgba(99,102,241,0.2), transparent 70%)">
            {!! QrCode::size(320)->generate($qrToken) !!}
        </div>

        <p class="mt-6 text-black font-mono select-all break-words max-w-xl mx-auto">
            Token Hari Ini:<br>
            <span class="font-semibold text-black">{{ $qrToken }}</span>
        </p>

        <button id="download-btn"
        class="mt-10 inline-block bg-black hover:bg-gray-900 text-white font-semibold px-8 py-3 rounded-full shadow-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-gray-700 focus:ring-opacity-60"
        type="button">
            Download QR Code
        </button>
    </div>

    <script>
        document.getElementById('download-btn').addEventListener('click', function() {
            // Ambil elemen SVG QR Code
            const svg = document.querySelector('#qr-container svg');
            if (!svg) return alert('QR Code belum tersedia.');

            // Serialize SVG to string
            const serializer = new XMLSerializer();
            const svgString = serializer.serializeToString(svg);

            // Buat canvas dan gambar QR ke canvas
            const canvas = document.createElement('canvas');
            const img = new Image();
            const svgBlob = new Blob([svgString], {
                type: 'image/svg+xml;charset=utf-8'
            });
            const url = URL.createObjectURL(svgBlob);

            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                URL.revokeObjectURL(url);

                // Buat link download PNG
                const pngUrl = canvas.toDataURL('image/png');
                const downloadLink = document.createElement('a');
                downloadLink.href = pngUrl;
                downloadLink.download = 'qr-absensi-{{ date('Ymd') }}.png';
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            };

            img.onerror = function() {
                alert('Gagal memuat QR Code untuk di-download.');
            };

            img.src = url;
        });
    </script>
</x-app-layout>
