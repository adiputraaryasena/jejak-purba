@extends('layouts.app')

@section('bgm_file', asset('assets/audio/bgm_main.mp3'))

@section('content')
<style>
    /* Custom Scrollbar Tipis untuk UI Game */
    .custom-scroll::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scroll::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
    }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #f59e0b;
        border-radius: 8px;
    }
</style>

<div class="w-full max-w-sm bg-[#16151a] border-2 border-stone-800 rounded-3xl p-6 space-y-4 shadow-2xl relative min-h-[580px]" 
     x-data="{ tab: 'galeri', openFossil: null, openFossilImg: '', openFossilEra: '' }">
    
    <!-- Top Header Presisi & Simetris -->
    <div class="flex items-center justify-between border-b border-stone-800/80 pb-3.5 mb-2">
        <!-- Tombol Back Modern -->
        <a href="{{ route('game.home') }}" 
           @click="playSfx()" 
           class="w-9 h-9 rounded-xl bg-stone-900 border border-stone-700/80 flex items-center justify-center text-amber-400 hover:bg-amber-500 hover:text-stone-950 hover:border-amber-400 shadow-md active:scale-95 transition-all duration-200 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <!-- Judul Presisi di Tengah -->
        <h2 class="font-purba text-sm font-bold text-amber-300 tracking-wide uppercase">
            Pencapaian & Koleksi
        </h2>

        <!-- Penyeimbang Kanan -->
        <div class="w-9 h-9"></div>
    </div>

    <!-- 3 Submenu Tab -->
    <div class="grid grid-cols-3 bg-[#111014] p-1 rounded-2xl border border-stone-800 text-center text-xs font-bold">
        <button @click="playSfx(); tab = 'galeri'" :class="tab === 'galeri' ? 'bg-amber-500 text-stone-950 shadow' : 'text-stone-400'" class="py-2 rounded-xl transition cursor-pointer">Galeri</button>
        <button @click="playSfx(); tab = 'badge'" :class="tab === 'badge' ? 'bg-amber-500 text-stone-950 shadow' : 'text-stone-400'" class="py-2 rounded-xl transition cursor-pointer">Badge</button>
        <button @click="playSfx(); tab = 'skor'" :class="tab === 'skor' ? 'bg-amber-500 text-stone-950 shadow' : 'text-stone-400'" class="py-2 rounded-xl transition cursor-pointer">Skor</button>
    </div>

    <!-- TAB 1: GALERI FOSIL (SCROLLABLE & PNG DYNAMIC) -->
    <div x-show="tab === 'galeri'" class="max-h-[360px] overflow-y-auto custom-scroll pr-1">
        <div class="grid grid-cols-3 gap-2.5 pt-1">
            @foreach($progressList as $p)
                @php
                    $eraLower = strtolower($p->era_name);
                    if (str_contains($eraLower, 'arkaikum')) {
                        $imgName = 'stromatolite.png';
                    } elseif (str_contains($eraLower, 'paleozoikum')) {
                        $imgName = 'trilobite.png';
                    } elseif (str_contains($eraLower, 'mesozoikum')) {
                        $imgName = 'trex_skull.png';
                    } elseif (str_contains($eraLower, 'neozoikum') || str_contains($eraLower, 'tersier')) {
                        $imgName = 'smilodon_fang.png';
                    } elseif (str_contains($eraLower, 'pleistosen')) {
                        $imgName = 'mammoth_tusk.png';
                    } else {
                        $imgName = 'prasasti.png';
                    }

                    $imgPath = asset('assets/images/minigames/' . $imgName);
                @endphp

                @if($p->fossil_unlocked)
                    <!-- Fosil Terbuka -->
                    <div @click="openFossil = '{{ $p->fossil_name }}'; openFossilImg = '{{ $imgPath }}'; openFossilEra = '{{ $p->era_name }}'" 
                         class="bg-[#1c1b22] border-2 border-amber-500/80 p-2 rounded-2xl text-center cursor-pointer hover:border-amber-400 transition shadow flex flex-col items-center justify-between h-[105px]">
                        <div class="w-12 h-12 flex items-center justify-center mt-1">
                            <img src="{{ $imgPath }}" alt="{{ $p->fossil_name }}" class="w-full h-full object-contain animate-pulse drop-shadow-[0_0_6px_rgba(245,158,11,0.4)]">
                        </div>
                        <p class="text-[9px] font-bold text-amber-200 truncate w-full px-1">{{ $p->fossil_name }}</p>
                        <span class="text-[8px] text-stone-400 block pb-1">{{ $p->era_name }}</span>
                    </div>
                @else
                    <!-- Fosil Terkunci -->
                    <div class="bg-stone-950/60 border border-stone-800/80 p-2 rounded-2xl text-center relative opacity-40 select-none flex flex-col items-center justify-between h-[105px]">
                        <div class="w-12 h-12 flex items-center justify-center relative mt-1">
                            <img src="{{ $imgPath }}" alt="Terkunci" class="w-full h-full object-contain filter grayscale brightness-0">
                            <span class="absolute text-xs">🔒</span>
                        </div>
                        <p class="text-[9px] font-bold text-stone-500 truncate w-full px-1">Terkunci</p>
                        <span class="text-[8px] text-stone-600 block pb-1">{{ $p->era_name }}</span>
                    </div>
                @endif
            @endforeach
            @if($progressList->isEmpty())
                <div class="col-span-3 text-center text-xs text-stone-500 py-8">Belum ada era yang tersedia.</div>
            @endif
        </div>
    </div>

    <!-- TAB 2: BADGE (SCROLLABLE) -->
    <div x-show="tab === 'badge'" class="max-h-[360px] overflow-y-auto custom-scroll pr-1 space-y-2.5 pt-1" x-cloak>
        @foreach($progressList as $p)
            @if($p->badge_unlocked)
                <!-- Badge Terbuka -->
                <div class="flex items-center gap-3 p-3 bg-[#1c1b22] border border-amber-500/60 rounded-2xl shadow">
                    <div class="text-2xl p-2 bg-amber-500/20 border border-amber-500/40 rounded-xl">🥇</div>
                    <div>
                        <h4 class="text-xs font-bold text-amber-300">{{ $p->badge_unlocked }}</h4>
                        <p class="text-[10px] text-stone-400">Lulus kuis {{ $p->era_name }} dengan skor &#8805; 70</p>
                    </div>
                </div>
            @else
                <!-- Badge Terkunci -->
                <div class="flex items-center gap-3 p-3 bg-stone-950/40 border border-stone-800/80 rounded-2xl opacity-40 select-none">
                    <div class="text-2xl p-2 bg-stone-900 border border-stone-800 rounded-xl grayscale">🔒</div>
                    <div>
                        <h4 class="text-xs font-bold text-stone-500">Badge {{ $p->era_name }}</h4>
                        <p class="text-[10px] text-stone-600">Dapatkan skor &#8805; 70 di kuis era ini</p>
                    </div>
                </div>
            @endif
        @endforeach
        @if($progressList->isEmpty())
            <div class="text-center text-xs text-stone-500 py-8">Belum ada data badge.</div>
        @endif
    </div>

    <!-- TAB 3: SKOR KUIS (SCROLLABLE) -->
    <div x-show="tab === 'skor'" class="max-h-[360px] overflow-y-auto custom-scroll pr-1 space-y-2 pt-1" x-cloak>
        @foreach($progressList as $p)
        <div class="bg-[#1c1b22] p-3 rounded-2xl border border-stone-700 flex justify-between items-center">
            <div>
                <span class="text-[10px] text-stone-400 font-bold block">{{ strtoupper($p->era_name) }}</span>
                <h4 class="text-xs font-bold text-stone-200">Skor Kuis Terbaik</h4>
            </div>
            <span class="font-purba text-lg font-bold text-emerald-400">{{ $p->quiz_score ?? 0 }} PTS</span>
        </div>
        @endforeach
        @if($progressList->isEmpty())
            <div class="text-center text-xs text-stone-500 py-8">Belum ada kuis yang diselesaikan.</div>
        @endif
    </div>

    <!-- Modal Popup Detail Fosil Dinamis -->
    <div x-show="openFossil" x-transition class="fixed inset-0 bg-black/85 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-cloak>
        <div class="bg-[#1c1b22] border-2 border-stone-700 p-6 rounded-3xl max-w-xs w-full text-center space-y-4 shadow-2xl relative">
            <div class="w-24 h-24 mx-auto flex items-center justify-center">
                <img :src="openFossilImg" :alt="openFossil" class="w-full h-full object-contain">
            </div>
            <div>
                <h3 class="font-purba text-lg font-bold text-amber-300" x-text="openFossil"></h3>
                <span class="text-[10px] text-amber-400 font-bold block mt-0.5" x-text="'Era ' + openFossilEra"></span>
                <p class="text-[11px] text-stone-400 mt-2 leading-relaxed">Fosil autentik prasejarah yang berhasil diekskavasi oleh tim peneliti.</p>
            </div>
            <button @click="openFossil = null" class="w-full py-2.5 bg-stone-800 text-stone-300 font-bold text-xs rounded-xl hover:bg-stone-700 cursor-pointer">Tutup Detail</button>
        </div>
    </div>

</div>
@endsection