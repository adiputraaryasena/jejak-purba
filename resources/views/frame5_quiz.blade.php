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

<div class="w-full max-w-sm bg-[#16151a] border-2 border-stone-800 rounded-3xl p-6 space-y-4 shadow-2xl relative min-h-[580px] flex flex-col justify-between"
     id="quizContainer"
     data-quizzes="{{ json_encode($quizzes) }}"
     x-data="quizEngine()">

    <div class="space-y-3">
        <!-- Top Header Presisi & Simetris (Kembali ke Menu Pilih Kuis Era) -->
        <div class="flex items-center justify-between border-b border-stone-800/80 pb-3 mb-1">
            <a href="{{ route('game.quiz.list') }}" 
               @click="playSfx()" 
               class="w-9 h-9 rounded-xl bg-stone-900 border border-stone-700/80 flex items-center justify-center text-amber-400 hover:bg-amber-500 hover:text-stone-950 hover:border-amber-400 shadow-md active:scale-95 transition-all duration-200 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <h2 class="font-purba text-sm font-bold text-amber-300 tracking-wide uppercase text-center">
                Kuis Era {{ $era->name }}
            </h2>

            <div class="w-9 h-9"></div>
        </div>

        <!-- Progress Bar Soal -->
        <div class="space-y-1">
            <div class="flex justify-between text-[10px] text-stone-400 font-bold">
                <span>SOAL <span x-text="currentIndex + 1"></span> DARI {{ count($quizzes) }}</span>
                <span class="text-amber-400" x-text="Math.round(((currentIndex + 1) / {{ count($quizzes) }}) * 100) + '%'"></span>
            </div>
            <div class="w-full bg-stone-900 rounded-full h-2 border border-stone-800 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-emerald-500 h-2 rounded-full transition-all duration-300"
                     :style="'width: ' + (((currentIndex + 1) / {{ count($quizzes) }}) * 100) + '%'"></div>
            </div>
        </div>

        <!-- Area Soal & Jawaban (Bisa Di-Scroll Agar Tombol Tidak Hilang) -->
        <template x-if="!isFinished">
            <div class="max-h-[380px] overflow-y-auto custom-scroll pr-1 space-y-3">
                <!-- Pertanyaan -->
                <div class="bg-[#1c1b22] p-3.5 rounded-2xl border border-stone-700/70 text-xs text-stone-200 leading-relaxed text-center shadow-inner font-medium"
                     x-text="currentQuestion.question"></div>

                <!-- Pilihan Jawaban -->
                <div class="space-y-2">
                    <template x-for="opt in ['a', 'b', 'c', 'd']" :key="opt">
                        <button @click="selectAnswer(opt)"
                                :disabled="showFeedback"
                                :class="{
                                    'border-amber-500 bg-amber-950/40': answers[currentQuestion.id] === opt,
                                    'border-emerald-500 bg-emerald-950/40 text-emerald-200': showFeedback && opt === currentQuestion.correct_answer,
                                    'border-rose-500 bg-rose-950/40 text-rose-200': showFeedback && answers[currentQuestion.id] === opt && opt !== currentQuestion.correct_answer,
                                    'border-stone-700 bg-[#1f1d26] hover:border-amber-500/80': !showFeedback && answers[currentQuestion.id] !== opt
                                }"
                                class="w-full p-3 rounded-xl border text-left text-xs font-semibold transition flex items-center justify-between cursor-pointer">
                            <span x-text="opt.toUpperCase() + '. ' + currentQuestion['option_' + opt]"></span>
                        </button>
                    </template>
                </div>

                <!-- Penjelasan Edukasi Jawaban -->
                <div x-show="showFeedback" x-transition class="p-3 bg-amber-950/40 border border-amber-700/50 rounded-xl text-[11px] text-amber-200 leading-relaxed">
                    <span class="font-bold block text-amber-400 mb-0.5">💡 Penjelasan Sejarah:</span>
                    <span x-text="currentQuestion.explanation"></span>
                </div>

                <!-- Tombol Lanjut Soal -->
                <button x-show="showFeedback" @click="nextQuestion()"
                        class="w-full py-3 bg-amber-500 text-stone-950 font-black text-xs rounded-xl hover:bg-amber-400 shadow-md transition cursor-pointer my-2">
                    <span x-text="currentIndex + 1 < {{ count($quizzes) }} ? 'Soal Berikutnya →' : 'Selesaikan Kuis 🏆'"></span>
                </button>
            </div>
        </template>
    </div>

    <!-- Modal Pop-Up Hasil Akhir Kuis -->
    <div x-show="isFinished" x-transition class="fixed inset-0 bg-black/85 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-cloak>
        <div class="bg-[#1c1b22] border-2 border-stone-700 p-6 rounded-3xl max-w-sm w-full text-center space-y-4 shadow-2xl relative">
            <span class="text-xs font-bold px-3 py-1 rounded-full border uppercase"
                  :class="finalScore >= 70 ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30' : 'bg-rose-500/20 text-rose-400 border-rose-500/30'"
                  x-text="finalScore >= 70 ? 'HASIL KUIS: LULUS!' : 'HASIL KUIS: COBA LAGI'"></span>

            <div class="space-y-1">
                <p class="text-stone-400 text-xs">Skor Kamu di Era Ini:</p>
                <h3 class="font-purba text-4xl font-bold text-amber-300" x-text="finalScore + ' PTS'"></h3>
            </div>

            <p class="text-stone-300 text-[11px] leading-relaxed bg-[#121116] p-3 rounded-xl border border-stone-800"
               x-text="finalScore >= 70 ? 'Selamat! Era berikutnya resmi terbuka & Badge Penyelidik didapatkan.' : 'Skor minimal 70 diperlukan untuk membuka era berikutnya.'"></p>

            <div class="space-y-2 pt-2">
                <a href="{{ route('game.pencapaian') }}" class="block w-full py-3 bg-amber-500 text-stone-950 font-black text-xs rounded-xl shadow-lg hover:bg-amber-400 transition">
                    🏆 Lihat Pencapaian & Badge
                </a>
                <a href="{{ route('game.quiz.list') }}" class="block w-full py-2.5 bg-stone-800 text-stone-300 font-bold text-xs rounded-xl hover:bg-stone-700 transition">
                    Kembali ke Pilih Kuis Era
                </a>
            </div>
        </div>
    </div>

</div>

<script>
    function quizEngine() {
        const container = document.getElementById('quizContainer');
        const quizzesData = JSON.parse(container.getAttribute('data-quizzes') || '[]');

        return {
            quizzes: quizzesData,
            currentIndex: 0,
            answers: {},
            showFeedback: false,
            isFinished: false,
            finalScore: 0,
            get currentQuestion() {
                return this.quizzes[this.currentIndex] || {};
            },
            selectAnswer(opt) {
                if (typeof playSfx === 'function') playSfx();
                this.answers[this.currentQuestion.id] = opt;
                this.showFeedback = true;
            },
            nextQuestion() {
                if (typeof playSfx === 'function') playSfx();
                if (this.currentIndex + 1 < this.quizzes.length) {
                    this.currentIndex++;
                    this.showFeedback = false;
                } else {
                    this.submitQuiz();
                }
            },
            submitQuiz() {
                const submitUrl = "{{ route('game.quiz.submit', $era->slug) }}";
                const token = "{{ csrf_token() }}";

                fetch(submitUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({ answers: this.answers })
                })
                .then(res => res.json())
                .then(data => {
                    this.finalScore = data.score;
                    this.isFinished = true;
                });
            }
        };
    }
</script>
@endsection