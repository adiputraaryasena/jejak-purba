@extends('layouts.app')

@section('bgm_file', asset('assets/audio/bgm_main.mp3'))

@section('content')
<div class="w-full max-w-sm bg-[#16151a] border-2 border-stone-800 rounded-3xl p-6 space-y-5 shadow-2xl relative"
     x-data="{ showSyncModal: false }">
    
    <!-- Header User + Tombol Sync & Music -->
    <div class="flex items-center justify-between border-b border-stone-800 pb-4">
        <div>
            <span class="text-[10px] text-stone-400 uppercase tracking-widest font-bold">Arkeolog Aktif</span>
            <h2 class="font-purba text-lg font-bold text-amber-300">Halo, {{ $userName }} 🗿</h2>
        </div>
        
        <div class="flex items-center gap-2">
            <!-- 1. Tombol Sync (Hanya tampil jika user berstatus Guest / Tamu) -->
            @if(Auth::check() && (Auth::user()->is_guest || Str::contains(Auth::user()->email, 'guest') || Auth::user()->email == null || Str::contains(strtolower(Auth::user()->name), 'tamu')))
                <button @click="playSfx(); showSyncModal = true" 
                        class="w-9 h-9 rounded-xl bg-amber-500/20 border border-amber-500/50 flex items-center justify-center text-sm text-amber-300 hover:bg-amber-500/30 transition animate-pulse" 
                        title="Simpan / Hubungkan Akun">
                    🔄
                </button>
            @endif

            <!-- 2. Tombol Musik BGM (Menggunakan Alpine Store) -->
            <button @click="$store.audio.toggle()" 
                    class="w-9 h-9 rounded-xl bg-stone-800/80 border border-stone-700/80 flex items-center justify-center text-sm text-amber-400 hover:bg-stone-700 transition" 
                    title="Musik Suasana">
                <span x-text="$store.audio.isPlaying ? '🔊' : '🔇'"></span>
            </button>
        </div>
    </div>

    <!-- Status Stats -->
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-[#111014] p-3.5 rounded-2xl border border-stone-800 space-y-1">
            <span class="text-[10px] font-semibold text-stone-400">Total Skor Riset</span>
            <p class="font-purba text-xl font-bold text-amber-400">{{ $totalScore }} <span class="text-xs font-sans text-stone-500">PTS</span></p>
        </div>
        <div class="bg-[#111014] p-3.5 rounded-2xl border border-stone-800 space-y-1">
            <span class="text-[10px] font-semibold text-stone-400">Fosil Ditemukan</span>
            <p class="font-purba text-xl font-bold text-emerald-400">{{ $fossilsUnlocked }} <span class="text-xs font-sans text-stone-500">/ {{ $totalEras }}</span></p>
        </div>
    </div>

    <!-- 3 Tombol Utama Sesuai Storyboard -->
    <div class="space-y-2.5">
        <!-- 1. Peta Garis Waktu -->
        <a href="{{ route('game.timeline') }}" @click="playSfx()" class="block p-3.5 rounded-2xl bg-[#1c1b22] border border-stone-700/60 hover:border-amber-500/80 transition group shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-xl">🗺️</div>
                <div>
                    <h3 class="font-purba text-sm font-bold text-stone-100 group-hover:text-amber-300">PETA GARIS WAKTU</h3>
                    <p class="text-[11px] text-stone-400">Jelajahi era dari masa ke masa</p>
                </div>
            </div>
        </a>

        <!-- 2. Mini Game Kuis -->
        <a href="{{ route('game.quiz.list') }}" @click="playSfx()" class="block p-3.5 rounded-2xl bg-[#1c1b22] border border-stone-700/60 hover:border-amber-500/80 transition group shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-xl">🧠</div>
                <div>
                    <h3 class="font-purba text-sm font-bold text-stone-100 group-hover:text-amber-300">KUIS PURBA</h3>
                    <p class="text-[11px] text-stone-400">Uji pengetahuan & kumpulkan poin</p>
                </div>
            </div>
        </a>

        <!-- 3. Pencapaian -->
        <a href="{{ route('game.pencapaian') }}" @click="playSfx()" class="block p-3.5 rounded-2xl bg-[#1c1b22] border border-stone-700/60 hover:border-amber-500/80 transition group shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-xl">🏆</div>
                <div>
                    <h3 class="font-purba text-sm font-bold text-stone-100 group-hover:text-amber-300">PENCAPAIAN</h3>
                    <p class="text-[11px] text-stone-400">Rekap nilai, badge & galeri fosil</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Tombol Logout -->
    <form action="{{ route('logout') }}" method="POST" class="pt-1">
        @csrf
        <button type="submit" @click="playSfx()" class="w-full py-2.5 text-center bg-rose-950/60 border border-rose-800/50 text-rose-300 font-bold text-xs rounded-xl hover:bg-rose-900/80 transition">
            Keluar Ekspedisi
        </button>
    </form>

    <!-- Modal Pop-up Sync / Hubungkan Akun -->
    <div x-show="showSyncModal" x-transition class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-cloak>
        <div class="bg-[#1c1b22] border-2 border-stone-700 p-6 rounded-3xl max-w-xs w-full text-center space-y-4 shadow-2xl relative">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center text-2xl mx-auto">🔄</div>
            <div>
                <h3 class="font-purba text-base font-bold text-amber-300">Simpan Progres Akun</h3>
                <p class="text-[11px] text-stone-400 mt-1">Daftarkan email & password untuk mengamankan data riset kamu.</p>
            </div>

            <form action="{{ route('guest.sync') }}" method="POST" class="space-y-3 text-left">
                @csrf
                <div>
                    <label class="text-[10px] font-bold text-stone-400 block mb-1">EMAIL</label>
                    <input type="email" name="email" required placeholder="email@kamu.com" class="w-full bg-stone-900 border border-stone-700 rounded-xl px-3 py-2 text-xs text-stone-200 focus:outline-none focus:border-amber-500">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-stone-400 block mb-1">PASSWORD</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full bg-stone-900 border border-stone-700 rounded-xl px-3 py-2 text-xs text-stone-200 focus:outline-none focus:border-amber-500">
                </div>

                <div class="pt-2 space-y-2">
                    <button type="submit" @click="playSfx()" class="w-full py-2.5 bg-amber-500 text-stone-950 font-bold text-xs rounded-xl hover:bg-amber-400 transition shadow-lg">
                        Simpan Progres Sekarang
                    </button>
                    <button type="button" @click="showSyncModal = false" class="w-full py-2 bg-stone-800 text-stone-400 font-bold text-xs rounded-xl hover:bg-stone-700 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection