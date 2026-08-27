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

<div class="w-full max-w-sm bg-[#16151a] border-2 border-stone-800 rounded-3xl p-6 space-y-4 shadow-2xl relative min-h-[580px] flex flex-col justify-between">
    
    <!-- Header dan List Era -->
    <div class="space-y-4">
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
                Pilih Kuis Era
            </h2>

            <!-- Penyeimbang Kanan -->
            <div class="w-9 h-9"></div>
        </div>

        <!-- List Era Kuis (Dapat Di-scroll) -->
        <div class="space-y-3 max-h-[380px] overflow-y-auto custom-scroll pr-1">
            @foreach($quizEras as $item)
                @if($item['is_unlocked'])
                    <a href="{{ route('game.quiz', $item['era']->slug) }}" @click="playSfx()" class="block p-4 rounded-2xl bg-[#1c1b22] border border-stone-700 hover:border-amber-500 transition shadow group">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-amber-400 font-bold block">LEVEL {{ $item['era']->order_level }}</span>
                                <h3 class="font-purba text-sm font-bold text-stone-100 group-hover:text-amber-300">Kuis Era {{ $item['era']->name }}</h3>
                            </div>
                            <span class="px-3 py-1 bg-amber-500/20 text-amber-300 text-xs font-bold rounded-xl border border-amber-500/40">Mulai →</span>
                        </div>
                    </a>
                @else
                    <div class="p-4 rounded-2xl bg-stone-900/60 border border-stone-800 flex items-center justify-between opacity-50 cursor-not-allowed">
                        <div>
                            <span class="text-[10px] text-stone-500 font-bold block">LEVEL {{ $item['era']->order_level }} (TERKUNCI)</span>
                            <h3 class="font-purba text-sm font-bold text-stone-400">Kuis Era {{ $item['era']->name }}</h3>
                        </div>
                        <span class="text-xs text-stone-600 font-bold">🔒 Terkunci</span>
                    </div>
                @endif
            @endforeach
            
            @if(empty($quizEras))
                <div class="text-center text-xs text-stone-500 py-8">Belum ada kuis yang tersedia.</div>
            @endif
        </div>
    </div>

    <!-- Footer Note (Tetap di Paling Bawah) -->
    <div class="text-center text-[10px] text-stone-500 bg-[#111014] p-2.5 rounded-xl border border-stone-800">
        💡 Selesaikan kuis era sebelumnya untuk membuka kuis era berikutnya.
    </div>

</div>
@endsection