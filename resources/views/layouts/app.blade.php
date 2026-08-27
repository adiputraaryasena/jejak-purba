<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jejak Purba — Ekspedisi Waktu</title>
    
    <!-- Tailwind CSS CDN (Dijamin langsung aktif sempurna di Railway) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Plus+Jakarta+Sans:wght@500;700;800&display=swap" rel="stylesheet">
    <style> 
        .font-purba { font-family: 'Cinzel', serif; } 
        body { font-family: 'Plus Jakarta Sans', sans-serif; } 
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#0d0d11] text-stone-100 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Tag Audio Tanpa SRC Bawaan (SRC diatur penuh oleh JavaScript) -->
    <audio id="globalBgm" loop preload="auto"></audio>
    <audio id="sfxClick" src="{{ asset('assets/audio/sfx_click.mp3') }}"></audio>

    <!-- Content Injected -->
    @yield('content')

    <script>
        // Ambil URL Audio dari View Blade
        const pageBgmUrl = "@yield('bgm_file', asset('assets/audio/bgm_main.mp3'))";

        document.addEventListener('alpine:init', () => {
            Alpine.store('audio', {
                isPlaying: localStorage.getItem('bgm_active') === 'true',

                toggle() {
                    const bgm = document.getElementById('globalBgm');
                    if (!bgm) return;

                    if (this.isPlaying) {
                        bgm.pause();
                        this.isPlaying = false;
                        localStorage.setItem('bgm_active', 'false');
                    } else {
                        bgm.play().then(() => {
                            this.isPlaying = true;
                            localStorage.setItem('bgm_active', 'true');
                        }).catch(() => {
                            this.isPlaying = false;
                            localStorage.setItem('bgm_active', 'false');
                        });
                    }
                }
            });
        });

        function playSfx() {
            const sfx = document.getElementById('sfxClick');
            if (sfx) {
                sfx.currentTime = 0;
                sfx.play().catch(() => {});
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const bgm = document.getElementById('globalBgm');
            if (!bgm) return;

            const lastSrc = localStorage.getItem('bgm_last_src');
            const lastTime = parseFloat(localStorage.getItem('bgm_last_time') || 0);

            // 1. Cek apakah lagu halaman ini SAMA dengan lagu halaman sebelumnya
            const isSameSong = (lastSrc === pageBgmUrl);

            // Set src audio secara manual
            bgm.src = pageBgmUrl;

            // 2. Jika lagu SAMA dan ada rekaman detiknya, lanjutkan dari detik tersebut
            if (isSameSong && lastTime > 0) {
                bgm.currentTime = lastTime;
            } else {
                // Jika lagu BERBEDA, reset detik ke 0
                localStorage.setItem('bgm_last_src', pageBgmUrl);
                localStorage.setItem('bgm_last_time', 0);
            }

            // 3. Simpan posisi detik secara langsung setiap kali lagu berjalan
            bgm.addEventListener('timeupdate', () => {
                if (bgm.currentTime > 0) {
                    localStorage.setItem('bgm_last_src', pageBgmUrl);
                    localStorage.setItem('bgm_last_time', bgm.currentTime);
                }
            });

            // 4. Putar musik jika BGM dalam kondisi aktif (ON)
            if (localStorage.getItem('bgm_active') === 'true') {
                bgm.play().then(() => {
                    // Pastikan currentTime di-apply setelah promise play berjalan
                    if (isSameSong && lastTime > 0) {
                        bgm.currentTime = lastTime;
                    }
                    if (window.Alpine && Alpine.store('audio')) {
                        Alpine.store('audio').isPlaying = true;
                    }
                }).catch(() => {});
            }
        });
    </script>
</body>
</html>