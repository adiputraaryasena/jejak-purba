@extends('layouts.app')

@section('bgm_file', asset('assets/audio/bgm_timeline.mp3'))

@section('content')
<div class="w-full max-w-sm bg-[#16151a] border-2 border-stone-800 rounded-3xl p-6 space-y-4 shadow-2xl relative min-h-[580px] flex flex-col justify-between">
    
    <!-- Top Header -->
    <div class="flex items-center justify-between border-b border-stone-800/80 pb-3.5 mb-4">
        <!-- Tombol Back Presisi -->
        <a href="{{ route('game.home') }}" 
        @click="playSfx()" 
        class="w-9 h-9 rounded-xl bg-stone-900 border border-stone-700/80 flex items-center justify-center text-amber-400 hover:bg-amber-500 hover:text-stone-950 hover:border-amber-400 shadow-md active:scale-95 transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <!-- Judul Presisi di Tengah -->
        <h2 class="font-purba text-sm font-bold text-amber-300 tracking-wide text-center uppercase">
            Peta Garis Waktu
        </h2>

        <!-- Penyeimbang Kanan (Sama persis dengan ukuran tombol kiri) -->
        <div class="w-9 h-9"></div>
    </div>
    <!-- Area Scroll Container -->
    <div class="py-1 max-h-[320px] overflow-y-auto pr-2 custom-scrollbar">
        
        <!-- Wrapper Relatif (Garis mengikuti tinggi total seluruh era) -->
        <div class="relative space-y-6 py-2">

            <!-- Garis Putus-Putus Jalur Peta (Top to Bottom sepanjang list) -->
            <div class="absolute left-1/2 top-4 bottom-4 w-0.5 border-r-2 border-dashed border-amber-700/50 -translate-x-1/2 pointer-events-none z-0"></div>

            @foreach($timelineData as $index => $data)
            <div class="flex items-center justify-between relative z-10 {{ $index % 2 == 0 ? 'flex-row' : 'flex-row-reverse' }}">
                
                @if($data['is_unlocked'])
                    <!-- Level Terbuka -->
                    <a href="{{ route('game.era', $data['era']->slug) }}" @click="playSfx()" 
                       class="w-14 h-14 rounded-2xl bg-amber-950 border-2 border-amber-500/80 flex items-center justify-center text-2xl shadow-lg shadow-amber-950/80 hover:scale-110 active:scale-95 transition cursor-pointer relative group bg-[#16151a]">
                        @if($data['era']->slug == 'arkaikum') 🌋 
                        @elseif($data['era']->slug == 'paleozoikum') 🐚 
                        @elseif($data['era']->slug == 'mesozoikum') 🦖 
                        @elseif($data['era']->slug == 'neozoikum-tersier') 🐅
                        @elseif($data['era']->slug == 'pleistosen') 🦣
                        @elseif($data['era']->slug == 'holosen') 🏛️
                        @else 🗿
                        @endif
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full border-2 border-[#16151a]"></span>
                    </a>
                @else
                    <!-- Level Terkunci -->
                    <div class="w-14 h-14 rounded-2xl bg-stone-900 border-2 border-stone-800 flex items-center justify-center text-xl text-stone-600 shadow cursor-not-allowed opacity-80 relative bg-[#16151a]" 
                         title="Selesaikan kuis era sebelumnya dengan skor minimal {{ $data['era']->min_score_unlock }}">
                        🔒
                    </div>
                @endif

                <!-- Info Box Nama Era -->
                <div class="bg-[#1c1b22] px-4 py-2 rounded-xl border {{ $data['is_unlocked'] ? 'border-stone-700 text-amber-200' : 'border-stone-800 text-stone-500' }} text-xs font-bold w-36 text-center shadow">
                    {{ $data['era']->name }}
                    <span class="block text-[9px] {{ $data['is_unlocked'] ? 'text-amber-400/80' : 'text-stone-600' }} font-normal">
                        {{ $data['is_unlocked'] ? 'Level ' . $data['era']->order_level : 'Terkunci' }}
                    </span>
                </div>

            </div>
            @endforeach
        </div>
    </div>

    <!-- Footer Guide -->
    <div class="text-center text-[10px] text-stone-500 bg-[#111014] p-2.5 rounded-xl border border-stone-800">
        💡 Scroll ke atas/bawah jika era bertambah.
    </div>

</div>

<!-- CSS Scrollbar -->
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #111014;
        border-radius: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #78350f;
        border-radius: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d97706;
    }
</style>
@endsection