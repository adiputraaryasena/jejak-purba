@extends('layouts.app')

@section('content')
<div class="relative w-full max-w-md bg-[#16151a] border-2 border-stone-800/80 rounded-3xl p-8 shadow-2xl space-y-8 backdrop-blur-md" x-data="{ openGuestModal: false, openLoginModal: false }">
    
    <div class="text-center space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-950/60 border border-amber-700/40 text-amber-400 text-[11px] font-bold tracking-widest uppercase">
            🗿 Ekspedisi Zaman Purba
        </div>
        
        <h1 class="font-purba text-4xl font-black tracking-wider text-transparent bg-clip-text bg-gradient-to-b from-amber-100 via-amber-300 to-amber-600 drop-shadow-md">
            JEJAK PURBA
        </h1>
        
        <p class="text-stone-400 text-xs leading-relaxed max-w-xs mx-auto">
            Singkap misteri jutaan tahun lalu, gali fosil raksasa, dan catat namamu di batu sejarah.
        </p>
    </div>

    <div class="space-y-3">
        <button type="button" @click="playSfx(); openGuestModal = true" class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 text-stone-950 font-black tracking-wide text-sm shadow-lg shadow-amber-900/30 hover:brightness-110 active:scale-[0.98] transition border border-amber-300/40">
            🦴 MULAI SEBAGAI TAMU
        </button>

        <button type="button" @click="playSfx(); openLoginModal = true" class="w-full py-3.5 px-6 rounded-2xl bg-[#1c1b22] border border-stone-700 text-amber-300 font-bold text-xs hover:bg-stone-800 transition">
            🔑 LOGIN / DAFTAR AKUN
        </button>
    </div>

    <!-- Modal Input Nama Tamu -->
    <div x-show="openGuestModal" x-transition class="fixed inset-0 bg-black/85 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-cloak>
        <div class="bg-[#1c1b22] border-2 border-stone-700 p-6 rounded-2xl max-w-sm w-full space-y-5 shadow-2xl relative">
            <div class="flex justify-between items-center border-b border-stone-800 pb-3">
                <h3 class="font-purba text-base font-bold text-amber-300">📜 Ukir Nama Peneliti</h3>
                <button type="button" @click="openGuestModal = false" class="text-stone-500 hover:text-stone-300">✕</button>
            </div>
            <form action="{{ route('guest.login') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-stone-300">Nama Peneliti / Julukan:</label>
                    <input type="text" name="username" placeholder="cth: Pemburu_Fosil" required class="w-full px-4 py-3 rounded-xl bg-[#121116] border border-stone-700 text-amber-100 text-sm focus:outline-none focus:border-amber-500 placeholder:text-stone-600">
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="button" @click="openGuestModal = false" class="w-1/2 py-3 rounded-xl border border-stone-700 text-xs font-bold text-stone-400 hover:bg-stone-800">Batal</button>
                    <button type="submit" class="w-1/2 py-3 rounded-xl bg-amber-500 text-stone-950 text-xs font-black hover:bg-amber-400">Masuk Peta 🗺️</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Login / Register -->
    <div x-show="openLoginModal" x-transition class="fixed inset-0 bg-black/85 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-cloak>
        <div class="bg-[#1c1b22] border-2 border-stone-700 p-6 rounded-2xl max-w-sm w-full space-y-4 shadow-2xl relative" x-data="{ isRegister: false }">
            <div class="flex justify-between items-center border-b border-stone-800 pb-3">
                <h3 class="font-purba text-base font-bold text-amber-300" x-text="isRegister ? '📝 Daftar Akun Baru' : '🔑 Login Peneliti'"></h3>
                <button type="button" @click="openLoginModal = false" class="text-stone-500 hover:text-stone-300">✕</button>
            </div>

            <form x-show="!isRegister" action="{{ route('user.login') }}" method="POST" class="space-y-3">
                @csrf
                <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2.5 rounded-xl bg-[#121116] border border-stone-700 text-amber-100 text-xs focus:outline-none focus:border-amber-500">
                <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2.5 rounded-xl bg-[#121116] border border-stone-700 text-amber-100 text-xs focus:outline-none focus:border-amber-500">
                <button type="submit" class="w-full py-3 bg-amber-500 text-stone-950 text-xs font-black rounded-xl hover:bg-amber-400">Masuk</button>
                <p class="text-[11px] text-center text-stone-400 mt-2">
                    Belum punya akun? <button type="button" @click="isRegister = true" class="text-amber-400 font-bold underline">Daftar</button>
                </p>
            </form>

            <form x-show="isRegister" action="{{ route('register') }}" method="POST" class="space-y-3" x-cloak>
                @csrf
                <input type="text" name="name" placeholder="Nama Lengkap" required class="w-full px-4 py-2.5 rounded-xl bg-[#121116] border border-stone-700 text-amber-100 text-xs focus:outline-none focus:border-amber-500">
                <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2.5 rounded-xl bg-[#121116] border border-stone-700 text-amber-100 text-xs focus:outline-none focus:border-amber-500">
                <input type="password" name="password" placeholder="Password (min 6 karakter)" required class="w-full px-4 py-2.5 rounded-xl bg-[#121116] border border-stone-700 text-amber-100 text-xs focus:outline-none focus:border-amber-500">
                <button type="submit" class="w-full py-3 bg-amber-500 text-stone-950 text-xs font-black rounded-xl hover:bg-amber-400">Buat Akun</button>
                <p class="text-[11px] text-center text-stone-400 mt-2">
                    Sudah punya akun? <button type="button" @click="isRegister = false" class="text-amber-400 font-bold underline">Login</button>
                </p>
            </form>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const bgm = document.getElementById('globalBgm');
        if (bgm) {
            bgm.pause();
            bgm.currentTime = 0;
        }
        localStorage.setItem('bgm_active', 'false');
    });
</script>
@endsection