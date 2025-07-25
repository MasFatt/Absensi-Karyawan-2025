<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('/favicon.png') }}" type="image/png">
    <title>{{ config('app.name', 'Laravel') }} - Sistem Absensi & HRIS Profesional</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tilt.js -->
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.7.2/dist/vanilla-tilt.min.js"></script>

    <!-- GSAP for advanced animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>

    <style>
        :root {
            --color-primary: #4f46e5;
            --color-primary-light: #6366f1;
            --color-primary-dark: #4338ca;
        }

        body {
            font-family: 'Figtree', sans-serif;
            color: #1f2937;
            overflow-x: hidden;
        }

        /* Cosmic background with stars */
        .cosmic-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            overflow: hidden;
        }

        /* Stars */
        .star {
            position: absolute;
            background-color: white;
            border-radius: 50%;
            animation: twinkle var(--duration) infinite ease-in-out;
        }

        @keyframes twinkle {

            0%,
            100% {
                opacity: 0.2;
            }

            50% {
                opacity: 1;
            }
        }

        /* Meteors */
        .meteor {
            position: absolute;
            width: 300px;
            height: 1px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.7) 50%, rgba(255, 255, 255, 0) 100%);
            transform: rotate(-45deg);
            animation: meteor var(--duration) linear infinite;
            opacity: 0;
            z-index: -1;
        }

        @keyframes meteor {
            0% {
                transform: translateX(0) translateY(0) rotate(-45deg);
                opacity: 1;
            }

            70% {
                opacity: 1;
            }

            100% {
                transform: translateX(1000px) translateY(1000px) rotate(-45deg);
                opacity: 0;
            }
        }

        /* Floating elements */
        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Glass morphism */
        .glass-deep {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .glass-deep:hover {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Neon text */
        .neon-text {
            color: white;
            text-shadow: 0 0 5px rgba(79, 70, 229, 0.5),
                0 0 10px rgba(79, 70, 229, 0.3),
                0 0 15px rgba(79, 70, 229, 0.2);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #d946ef);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Pulse animation */
        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(99, 102, 241, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0);
            }
        }

        /* Parallax layers */
        .parallax-layer {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--color-primary-light);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--color-primary);
        }
    </style>
</head>

<body class="antialiased">
    <!-- Cosmic background with stars and meteors -->
    <div class="cosmic-bg" id="cosmicBg"></div>

    <!-- Parallax layers -->
    <div class="parallax-layer" style="z-index: -1;">
        <div class="absolute top-0 left-0 w-full h-full opacity-20" id="parallaxLayer1"></div>
    </div>

    <div class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
        {{-- Tombol Login/Register --}}
        <div class="absolute top-0 right-0 p-6 text-right z-50">
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="font-semibold text-white hover:text-indigo-300 transition-all duration-300 hover:scale-105">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                    class="font-semibold text-white hover:text-indigo-300 transition-all duration-300 hover:scale-105">Log
                    in</a>
            @endauth
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-12 w-full relative z-10">
            {{-- Header --}}
            <header class="text-center mb-20 relative">
                <div class="absolute -top-20 -left-20 w-40 h-40 bg-indigo-500 rounded-full filter blur-3xl opacity-20">
                </div>
                <div
                    class="absolute -bottom-20 -right-20 w-40 h-40 bg-purple-500 rounded-full filter blur-3xl opacity-20">
                </div>

                <h1 class="text-5xl md:text-7xl font-extrabold neon-text tracking-tight mb-6">
                    <span class="gradient-text">Sistem Absensi</span> & HRIS
                </h1>

                <div class="mt-10">
                    <div class="inline-block floating">
                        <div class="relative">
                            <div class="absolute -inset-2 bg-indigo-500 rounded-xl blur opacity-75"></div>
                            <a href="/login"
                                class="relative px-8 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition-all duration-300 transform hover:scale-105">
                                Coba Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Tentang --}}
            <section
                class="glass-deep rounded-3xl p-8 md:p-10 text-center max-w-5xl mx-auto mb-20 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500 rounded-full filter blur-xl opacity-10">
                </div>
                <div
                    class="absolute -bottom-10 -left-10 w-32 h-32 bg-purple-500 rounded-full filter blur-xl opacity-10">
                </div>

                <h2 class="text-3xl font-bold text-white mb-6">
                    <span class="gradient-text">🧠 Tentang Project</span>
                </h2>
                <p class="text-gray-300 leading-relaxed text-lg">
                    Bukan sekadar aplikasi, ini adalah <strong class="text-indigo-300">Project Sistem Absensi</strong> —
                    dibangun dari nol dengan Laravel 12, Tailwind, dan dilengkapi fitur-fitur kritikal seperti
                    Autentikasi, Absensi GPS + QR, Slip Gaji PDF, dan Dashboard Karyawan.
                </p>
            </section>

            {{-- Fitur --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
                @php
                    $features = [
                        [
                            'icon' => 'heroicon-o-qr-code',
                            'title' => 'Absensi QR & GPS',
                            'desc' => 'Validasi lokasi realtime & QR unik harian.',
                        ],
                        [
                            'icon' => 'heroicon-o-clock',
                            'title' => 'Manajemen Lembur',
                            'desc' => 'Flow approval lembur antar divisi.',
                        ],
                        [
                            'icon' => 'heroicon-o-document-text',
                            'title' => 'Cuti & Izin Online',
                            'desc' => 'Pengajuan izin + upload bukti otomatis.',
                        ],
                        [
                            'icon' => 'heroicon-o-currency-dollar',
                            'title' => 'Slip Gaji PDF',
                            'desc' => 'Auto generate slip gaji digital format PDF.',
                        ],
                    ];
                @endphp

                @foreach ($features as $index => $feature)
                    <div data-tilt data-tilt-max="10" data-tilt-glare="true" data-tilt-max-glare="0.1"
                        data-tilt-speed="800"
                        class="glass-deep p-6 rounded-2xl text-center transform transition-all duration-300 hover:scale-[1.03] feature-tilt relative overflow-hidden">
                        <div
                            class="absolute -top-10 -right-10 w-20 h-20 bg-indigo-500 rounded-full filter blur-xl opacity-10">
                        </div>

                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-full bg-indigo-900/30 flex items-center justify-center border border-indigo-500/30">
                            <x-dynamic-component :component="$feature['icon']" class="w-8 h-8 text-indigo-300" />
                        </div>
                        <h3 class="text-xl font-semibold text-white">{{ $feature['title'] }}</h3>
                        <p class="text-gray-300 mt-2">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Demo Section --}}
            <section id="demo" class="glass-deep rounded-3xl p-8 md:p-10 mb-20 relative overflow-hidden">
                <div class="absolute -top-20 -left-20 w-40 h-40 bg-indigo-500 rounded-full filter blur-3xl opacity-10">
                </div>
                <div
                    class="absolute -bottom-20 -right-20 w-40 h-40 bg-purple-500 rounded-full filter blur-3xl opacity-10">
                </div>

                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-white mb-2">
                        <span class="gradient-text">🎮 Live Demo</span>
                    </h2>
                    <p class="text-gray-300">Coba fitur-fitur utama sistem kami</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div class="space-y-6">
                        <div
                            class="p-6 rounded-xl bg-gradient-to-br from-indigo-900/30 to-purple-900/30 border border-indigo-500/20">
                            <h3 class="text-xl font-semibold text-white mb-3">Login Admin</h3>
                            <p class="text-gray-300 mb-4">Akses penuh ke semua fitur sistem</p>
                            <div class="flex flex-col space-y-3">
                                <input type="text" placeholder="Email"
                                    class="px-4 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <input type="password" placeholder="Password"
                                    class="px-4 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <button
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Login</button>
                            </div>
                        </div>

                        <div
                            class="p-6 rounded-xl bg-gradient-to-br from-indigo-900/30 to-purple-900/30 border border-indigo-500/20">
                            <h3 class="text-xl font-semibold text-white mb-3">Scan QR Absensi</h3>
                            <p class="text-gray-300 mb-4">Coba fitur absensi real-time</p>
                            <div class="relative">
                                <div class="w-full h-64 bg-black rounded-lg flex items-center justify-center">
                                    <div class="p-4 bg-white rounded">
                                        <!-- QR Code Placeholder -->
                                        <div class="grid grid-cols-5 gap-1">
                                            @for ($i = 0; $i < 25; $i++)
                                                <div class="{{ $i % 2 == 0 ? 'bg-black' : 'bg-white' }} w-4 h-4"></div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute -bottom-3 -right-3 w-6 h-6 bg-green-400 rounded-full pulse"></div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="relative">
                            <div class="absolute -inset-4 bg-indigo-500/30 rounded-2xl blur"></div>
                            <div class="relative bg-gray-800/80 rounded-xl overflow-hidden border border-gray-700">
                                <!-- Dashboard Preview -->
                                <div class="bg-gray-900 p-3 flex items-center">
                                    <div class="flex space-x-2">
                                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    </div>
                                    <div class="text-xs text-gray-400 mx-auto">dashboard.html</div>
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-6">
                                        <h3 class="text-white font-semibold">Dashboard Admin</h3>
                                        <div class="text-xs text-gray-400">Today: {{ date('d M Y') }}</div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div class="bg-indigo-900/30 p-3 rounded-lg border border-indigo-500/30">
                                            <div class="text-xs text-indigo-300 mb-1">Total Karyawan</div>
                                            <div class="text-2xl font-bold text-white">142</div>
                                        </div>
                                        <div class="bg-purple-900/30 p-3 rounded-lg border border-purple-500/30">
                                            <div class="text-xs text-purple-300 mb-1">Absensi Hari Ini</div>
                                            <div class="text-2xl font-bold text-white">87%</div>
                                        </div>
                                    </div>

                                    <div
                                        class="h-40 bg-gray-700/50 rounded-lg mb-4 flex items-center justify-center text-gray-400">
                                        Grafik Statistik
                                    </div>

                                    <div
                                        class="h-20 bg-gray-700/50 rounded-lg flex items-center justify-center text-gray-400">
                                        Daftar Absensi Terbaru
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- CTA --}}
            <section class="glass-deep rounded-3xl p-10 text-center max-w-4xl mx-auto mb-20 relative overflow-hidden">
                <div class="absolute -top-20 -left-20 w-40 h-40 bg-indigo-500 rounded-full filter blur-3xl opacity-10">
                </div>
                <div
                    class="absolute -bottom-20 -right-20 w-40 h-40 bg-purple-500 rounded-full filter blur-3xl opacity-10">
                </div>

                <h2 class="text-3xl font-bold text-white mb-6">
                    <span class="gradient-text">🚀 Siap Mengubah Sistem HR Anda?</span>
                </h2>
                <p class="text-gray-300 leading-relaxed text-lg mb-8">
                    Mulai digitalisasi proses HR dan absensi perusahaan Anda hari ini. Hubungi kami untuk demo lengkap
                    dan penawaran khusus.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="https://www.instagram.com/fatihaers_"
                        class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition-all duration-300 transform hover:scale-105">
                        Hubungi Kami
                    </a>
                    <a href="#demo"
                        class="px-8 py-3 bg-transparent text-indigo-300 font-bold rounded-lg border border-indigo-500 hover:bg-indigo-500/10 transition-all duration-300 transform hover:scale-105">
                        Dokumentasi
                    </a>
                </div>
            </section>

            {{-- Footer --}}
            <footer class="mt-24 text-center">
                <p class="text-gray-400">Dibuat dengan <span class="text-pink-500 animate-pulse">❤️</span> oleh
                    <a href="https://github.com/MasFatt" target="_blank"
                        class="text-indigo-300 font-semibold hover:underline hover:text-white transition">Fatiha Eros
                        Perdana</a>
                </p>
                {{-- Github --}}
                <div class="flex justify-center space-x-4 mt-6">
                    <a href="https://github.com/MasFatt" class="text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    {{-- Instgram --}}
                    <a href="https://www.instagram.com/fatihaers_" class="text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    {{-- Xtwiter --}}
                    <a href="https://x.com/fatihaers_" class="text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                            </path>
                        </svg>
                    </a>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Initialize VanillaTilt
        VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
            max: 10,
            speed: 800,
            glare: true,
            "max-glare": 0.1
        });

        // Create stars
        function createStars() {
            const cosmicBg = document.getElementById('cosmicBg');
            const starCount = 200;

            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'star';

                // Random size between 1-3px
                const size = Math.random() * 2 + 1;
                star.style.width = `${size}px`;
                star.style.height = `${size}px`;

                // Random position
                star.style.left = `${Math.random() * 100}%`;
                star.style.top = `${Math.random() * 100}%`;

                // Random animation duration
                star.style.setProperty('--duration', `${Math.random() * 3 + 2}s`);

                cosmicBg.appendChild(star);
            }
        }

        // Create meteors
        function createMeteors() {
            const cosmicBg = document.getElementById('cosmicBg');
            const meteorCount = 5;

            for (let i = 0; i < meteorCount; i++) {
                const meteor = document.createElement('div');
                meteor.className = 'meteor';

                // Random position
                meteor.style.left = `${Math.random() * 20}%`;
                meteor.style.top = `${Math.random() * 20}%`;

                // Random animation duration and delay
                const duration = Math.random() * 3 + 2;
                meteor.style.setProperty('--duration', `${duration}s`);
                meteor.style.animationDelay = `${Math.random() * 20}s`;

                cosmicBg.appendChild(meteor);
            }
        }

        // Initialize GSAP animations
        function initAnimations() {
            // Animate elements on scroll
            gsap.registerPlugin(ScrollTrigger);

            // Animate features
            gsap.utils.toArray('.feature-tilt').forEach((feature, i) => {
                gsap.from(feature, {
                    scrollTrigger: {
                        trigger: feature,
                        start: "top 80%",
                        toggleActions: "play none none none"
                    },
                    y: 50,
                    opacity: 0,
                    duration: 0.8,
                    delay: i * 0.1
                });
            });

            // Animate demo section
            gsap.from("#demo", {
                scrollTrigger: {
                    trigger: "#demo",
                    start: "top 80%",
                    toggleActions: "play none none none"
                },
                y: 100,
                opacity: 0,
                duration: 1
            });

            // Floating animation for CTA
            gsap.to(".floating", {
                y: -20,
                duration: 2,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        }

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            createStars();
            createMeteors();
            initAnimations();
        });
    </script>
</body>

</html>
