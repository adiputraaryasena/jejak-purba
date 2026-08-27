@extends('layouts.app')

@section('bgm_file', asset('assets/audio/bgm_' . $era->slug . '.mp3'))

@section('content')
<div class="w-full max-w-sm bg-[#16151a] border-2 border-stone-800 rounded-3xl p-6 space-y-4 shadow-2xl relative" 
     x-data="eraSequentialEngine('{{ asset($era->bgm_file) }}', '{{ $era->slug }}')">
    
    <!-- Top Header Presisi & Simetris -->
    <div class="flex items-center justify-between border-b border-stone-800/80 pb-3.5 mb-2">
        <!-- Tombol Back Modern -->
        <a href="{{ route('game.timeline') }}" 
           @click="playSfx()" 
           class="w-9 h-9 rounded-xl bg-stone-900 border border-stone-700/80 flex items-center justify-center text-amber-400 hover:bg-amber-500 hover:text-stone-950 hover:border-amber-400 shadow-md active:scale-95 transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <!-- Judul & Subtitle Presisi di Tengah -->
        <div class="text-center">
            <h2 class="font-purba text-sm font-bold text-amber-300 tracking-wide leading-tight">
                Ekspedisi Era {{ $era->name }}
            </h2>
            <span class="text-[9px] text-stone-400 font-mono mt-0.5 block">
                Tahap <span x-text="currentStep + 1" class="text-amber-400 font-bold"></span> dari <span x-text="totalSteps"></span>
            </span>
        </div>

        <!-- Penyeimbang Kanan -->
        <div class="w-9 h-9"></div>
    </div>

    <!-- AREA 1: VISUAL CERITA (Story Mode) -->
    <div x-show="stepType === 'story'" class="relative w-full h-48 rounded-2xl overflow-hidden border-2 border-amber-700/60 bg-[#0d0c10] flex items-center justify-center shadow-inner">
        <template x-if="currentStoryData?.video">
            <video class="w-full h-full object-cover" autoplay loop muted playsinline :src="currentStoryData.video"></video>
        </template>

        <template x-if="!currentStoryData?.video">
            <div class="flex flex-col items-center justify-center text-center p-4">
                <span class="text-6xl animate-pulse" x-text="currentStoryData?.icon || '🌋'"></span>
                <span class="text-[10px] text-amber-400/80 font-mono mt-2" x-text="currentStoryData?.visualLabel"></span>
            </div>
        </template>
    </div>

    <!-- AREA 2: SISIPAN MINI-GAME INTERAKTIF -->
    <div x-show="stepType === 'minigame'" class="relative w-full h-52 rounded-2xl overflow-hidden border-2 border-amber-500 bg-[#0d0c10] flex items-center justify-center shadow-inner select-none">
        
        <!-- 1. ERA 1: SCRATCH (GOSOK LAHAR - ARKAIKUM) -->
        <template x-if="currentGameType === 'scratch'">
            <div class="relative w-full h-full flex flex-col items-center justify-center bg-stone-900">
                <img src="{{ asset('assets/images/minigames/stromatolite.png') }}" class="w-28 h-28 object-contain">
                <p class="font-purba text-xs text-amber-300 font-bold mt-1">{{ $era->fossil_name }}</p>
                <canvas id="scratchCanvas" class="absolute inset-0 w-full h-full cursor-pointer z-10" x-show="!minigamePassed"></canvas>
            </div>
        </template>

        <!-- 2. ERA 2: CATCH (TANGKAP TRILOBITA BERGERAK - PALEOZOIKUM) -->
        <template x-if="currentGameType === 'catch'">
            <div class="relative w-full h-full bg-blue-950/90 overflow-hidden flex items-center justify-center" id="catchArea">
                <div class="absolute top-2 text-center z-0">
                    <p class="text-[10px] text-amber-300 font-bold" x-text="'Tangkap Trilobita: ' + catchScore + '/3'"></p>
                </div>
                <button @click="hitTrilobite()" 
                        class="absolute transition-all duration-300 cursor-pointer hover:scale-110 active:scale-90 z-10"
                        :style="`top: ${trilobiteY}%; left: ${trilobiteX}%;`"
                        x-show="!minigamePassed">
                    <img src="{{ asset('assets/images/minigames/trilobite.png') }}" class="w-16 h-16 object-contain animate-bounce">
                </button>
            </div>
        </template>

        <!-- 3. ERA 3: PUZZLE (SUSUN TENGKORAK T-REX - MESOZOIKUM) -->
        <template x-if="currentGameType === 'puzzle'">
            <div class="relative w-full h-full bg-stone-900/95 flex flex-col items-center justify-center gap-2 p-4">
                <p class="text-[10px] text-amber-300 font-bold" x-text="puzzleProgress < 3 ? 'Klik pecahan fosil secara berurutan ('+puzzleProgress+'/3)' : 'Fosil Sempurna!'"></p>
                <div class="flex gap-2">
                    <template x-for="(part, index) in puzzleParts">
                        <button @click="clickPuzzle(index)" 
                                :class="part.clicked ? 'opacity-30 scale-95 border-emerald-500 bg-emerald-500/20' : 'border-amber-500 bg-amber-500/10 hover:bg-amber-500/20'"
                                class="p-2 border-2 rounded-xl transition cursor-pointer">
                            <img src="{{ asset('assets/images/minigames/trex_skull.png') }}" class="w-12 h-12 object-contain">
                        </button>
                    </template>
                </div>
            </div>
        </template>

        <!-- 4. ERA 4: TIMING (REFLEKS TARING SMILODON - NEOZOIKUM TERSIER) -->
        <template x-if="currentGameType === 'timing'">
            <div class="relative w-full h-full bg-stone-900/95 flex flex-col items-center justify-center gap-2 p-4">
                <img src="{{ asset('assets/images/minigames/smilodon_fang.png') }}" class="w-12 h-12 object-contain">
                <p class="text-[10px] text-amber-300 font-bold">Hentikan jarum tepat di area hijau!</p>
                <div class="w-48 h-4 bg-stone-800 rounded-full relative overflow-hidden border border-stone-700">
                    <!-- Area Hijau diatur persentase pastinya (35% sampai 65%) -->
                    <div class="absolute top-0 bottom-0 left-[35%] right-[35%] bg-emerald-500/60 border-x border-emerald-400"></div>
                    <!-- Posisi Jarum Bergerak -->
                    <div class="absolute top-0 bottom-0 w-2 bg-amber-400 rounded-full shadow transition-all duration-75 -ml-1" :style="`left: ${timingPos}%`"></div>
                </div>
                <button @click="checkTiming()" class="px-4 py-1.5 bg-amber-500 text-stone-950 font-bold text-xs rounded-lg active:scale-95 transition cursor-pointer shadow">
                    TEPATI! 🎯
                </button>
            </div>
        </template>

        <!-- 5. ERA 5: ICEBREAKER (PECAHKAN ES MAMMOTH - PLEISTOSEN) -->
        <template x-if="currentGameType === 'icebreaker'">
            <div class="relative w-full h-full bg-cyan-950/95 flex flex-col items-center justify-center gap-2">
                <p class="text-[10px] text-cyan-200 font-bold">Tap cepat untuk memecahkan es permafrost!</p>
                <div @click="tapIce()" class="cursor-pointer active:scale-95 transition select-none relative p-2 bg-cyan-900/40 border-2 border-cyan-400/50 rounded-2xl">
                    <img src="{{ asset('assets/images/minigames/mammoth_tusk.png') }}" class="w-16 h-16 object-contain" :class="iceTaps < 8 ? 'filter blur-[1px]' : ''">
                </div>
                <div class="w-32 h-2 bg-stone-800 rounded-full overflow-hidden border border-cyan-800">
                    <div class="h-full bg-cyan-400 transition-all duration-100" :style="`width: ${(iceTaps / 8) * 100}%`"></div>
                </div>
            </div>
        </template>

        <!-- 6. ERA 6: RESTORATION (BERSIHKAN PRASASTI - HOLOSEN) -->
        <template x-if="currentGameType === 'restoration'">
            <div class="relative w-full h-full flex flex-col items-center justify-center bg-stone-900">
                <img src="{{ asset('assets/images/minigames/prasasti.png') }}" class="w-28 h-28 object-contain">
                <p class="font-purba text-xs text-amber-300 font-bold mt-1">{{ $era->fossil_name }}</p>
                <canvas id="restoreCanvas" class="absolute inset-0 w-full h-full cursor-pointer z-10" x-show="!minigamePassed"></canvas>
            </div>
        </template>

        <!-- Status Badge Mini-Game -->
        <div class="absolute bottom-2 right-2 bg-black/80 px-2.5 py-1 rounded-lg border border-amber-500 text-[9px] text-amber-300 font-mono z-20" 
             x-text="minigamePassed ? '✅ FOSIL TERKUMPUL!' : '🎮 TUNTASKAN MISI'"></div>
    </div>

    <!-- KOTAK DESKRIPSI TEKS & PENJELASAN -->
    <div class="bg-[#1c1b22] p-4 rounded-2xl border border-stone-700/80 min-h-[140px] space-y-2 flex flex-col justify-between">
        <div class="space-y-1">
            <h3 class="text-xs font-bold text-amber-400 flex items-center gap-1.5">
                <span x-text="stepType === 'minigame' ? '🎮 SISIPAN MINI-GAME' : '📜 SEJARAH GEOLOGI'"></span>: 
                <span x-text="currentTitle"></span>
            </h3>
            <!-- Perbaikan Text Typewriter agar tidak rusak/glitch -->
            <p class="text-[11px] text-stone-300 leading-relaxed italic" x-text="displayedText"></p>
        </div>
        
        <div class="p-2.5 bg-stone-900/80 border border-amber-900/40 rounded-xl text-[10px] text-amber-200/90 leading-normal">
            <strong class="text-amber-400">💡 Catatan Ilmiah:</strong>
            <span x-text="currentDetail"></span>
        </div>
    </div>

    <!-- NAVIGASI TOMBOL ALUR ERA -->
    <div class="flex items-center gap-2 pt-1">
        <button x-show="currentStep > 0" @click="prevStep()" class="w-1/3 py-2.5 bg-stone-800 text-stone-300 font-bold text-xs rounded-xl hover:bg-stone-700 transition cursor-pointer">
            ← Sebelum
        </button>

        <button x-show="stepType === 'story' && currentStep < totalSteps - 1" @click="nextStep()" class="flex-1 py-2.5 bg-amber-500 text-stone-950 font-black text-xs rounded-xl hover:bg-amber-400 shadow transition cursor-pointer">
            Lanjut →
        </button>

        <button x-show="stepType === 'minigame' && !minigamePassed" class="flex-1 py-2.5 bg-stone-800 text-stone-500 font-bold text-xs rounded-xl cursor-not-allowed text-center border border-stone-700">
            🔒 Selesaikan Mini-Game Dulu
        </button>

        <button x-show="stepType === 'minigame' && minigamePassed && currentStep < totalSteps - 1" @click="nextStep()" class="flex-1 py-2.5 bg-emerald-500 text-stone-950 font-black text-xs rounded-xl hover:bg-emerald-400 shadow transition animate-bounce cursor-pointer">
            Lanjut Cerita →
        </button>

        <a x-show="currentStep === totalSteps - 1" href="{{ route('game.quiz', $era->slug) }}" @click="playSfx()" class="flex-1 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-stone-950 font-black text-xs text-center rounded-xl shadow-lg hover:brightness-110 transition">
            Uji Pemahaman (Kuis) 🧠
        </a>
    </div>

</div>

<script>
    function eraSequentialEngine(bgmFile, eraSlug) {
        return {
            eraSlug: eraSlug,
            currentStep: 0,
            totalSteps: 0,
            stepType: 'story',
            currentGameType: 'scratch',
            minigamePassed: false,
            timelineFlow: [],
            currentTitle: '',
            currentDetail: '',
            currentStoryData: null,
            displayedText: '', // Variabel khusus Alpine untuk efek typewriter yang bersih
            
            // State Minigame Interaktif
            catchScore: 0,
            trilobiteX: 50,
            trilobiteY: 40,
            puzzleProgress: 0,
            puzzleParts: [{clicked: false}, {clicked: false}, {clicked: false}],
            timingPos: 0,
            timingDir: 3.5, // Kecepatan gerak jarum agar seimbang
            timingInterval: null,
            iceTaps: 0,

            init() {
                if (eraSlug === 'arkaikum') {
                    this.timelineFlow = [
                        { type: 'story', title: "Fase 1: Pembentukan Kerak Bumi", text: "Sekitar 4,6 miliar tahun lalu, bumi baru terbentuk dari kumpulan debu & gas kosmik.", detail: "Suhu awal bumi sangat tinggi dan belum memiliki daratan padat.", video: "{{ asset('assets/videos/arkaikum_fase1.mp4') }}" },
                        { type: 'story', title: "Fase 2: Samudra Magma Cair", text: "Permukaan bumi tertutup lautan magma yang terus bergejolak tanpa henti.", detail: "Hujan meteorit raksasa membentur permukaan secara terus-menerus.", video: "{{ asset('assets/videos/arkaikum_fase2.mp4') }}" },
                        { type: 'story', title: "Fase 3: Atmosfer Purba Beracun", text: "Atmosfer awal dipenuhi gas metana, amonia, dan CO2 tanpa kandungan oksigen.", detail: "Tidak ada organisme aerobik yang mampu bertahan hidup di fase ini.", video: "{{ asset('assets/videos/arkaikum_fase3.mp4') }}" },
                        { type: 'minigame', gameType: 'scratch', title: "Misi Ekskavasi: Kerak Magma Beku", text: "Gosok lapisan lahar beku ini untuk menemukan bukti mikroorganisme pertama!", detail: "Usap permukaan canvas hingga fosil tersembunyi terlihat." },
                        { type: 'story', title: "Fase 5: Pembentukan Lautan Panas", text: "Uap air di atmosfer mendingin dan jatuh sebagai hujan lebat selama jutaan tahun.", detail: "Hujan purba ini melarutkan mineral dan membentuk lautan asam hangat pertama.", video: "{{ asset('assets/videos/arkaikum_fase5.mp4') }}" },
                        { type: 'story', title: "Fase 6: Sintesis Kimia Organik", text: "Lautan hangat menjadi tempat terjadinya reaksi kimia molekul organik awal.", detail: "Eksperimen alam ini memicu lahirnya rantai RNA & molekul kehidupan.", video: "{{ asset('assets/videos/arkaikum_fase6.mp4') }}" },
                        { type: 'story', title: "Fase 7: Sianobakteri Uniseluler", text: "Organisme hidup pertama lahir di laut, berupa bakteri bersel tunggal anaerob.", detail: "Bakteri ini hidup tanpa memerlukan oksigen bebas di atmosfer.", video: "{{ asset('assets/videos/arkaikum_fase7.mp4') }}" },
                        { type: 'story', title: "Fase 8: Kemunculan Stromatolit", text: "Koloni sianobakteri mengendapkan kalsium karbonat dan membentuk fosil Stromatolit.", detail: "Stromatolit merupakan struktur fosil biologis tertua di bumi.", video: "{{ asset('assets/videos/arkaikum_fase8.mp4') }}" },
                        { type: 'story', title: "Fase 9: Awal Pelepasan Oksigen", text: "Melalui fotosintesis purba, sianobakteri mulai memproduksi gas oksigen tipis.", detail: "Oksigen ini memicu pelepasan racun besi di samudra purba.", video: "{{ asset('assets/videos/arkaikum_fase9.mp4') }}" },
                        { type: 'story', title: "Fase 10: Akhir Era Arkaikum", text: "Kerak bumi mulai stabil dan menjadi pondasi awal masuknya era Paleozoikum.", detail: "Bumi siap memasuki era keanekaragaman kehidupan lautan.", video: "{{ asset('assets/videos/arkaikum_fase10.mp4') }}" }
                    ];
                } else if (eraSlug === 'paleozoikum') {
                    this.timelineFlow = [
                        { type: 'story', title: "Fase 1: Mendinginnya Iklim Bumi", text: "Awal Paleozoikum ditandai dengan suhu bumi yang semakin stabil dan dingin.", detail: "Lautan meluas dan menjadi pusat perkembangan biologi utama.", video: "{{ asset('assets/videos/paleozoikum_fase1.mp4') }}" },
                        { type: 'story', title: "Fase 2: Ledakan Kambrium", text: "Terjadi kemunculan masal secara mendadak jutaan spesies hewan laut.", detail: "Hewan mulai mengembangkan cangkang dan jaringan tubuh keras.", video: "{{ asset('assets/videos/paleozoikum_fase2.mp4') }}" },
                        { type: 'story', title: "Fase 3: Dominasi Invertebrata Laut", text: "Siput laut, Amonit, dan ubur-ubur purba mendominasi terumbu karang pertama.", detail: "Rantai makanan samudra terbentuk secara kompleks.", video: "{{ asset('assets/videos/paleozoikum_fase3.mp4') }}" },
                        { type: 'minigame', gameType: 'catch', title: "Misi Perburuan Laut: Tangkap Trilobita", text: "Gunakan jaring eksplorasi untuk menangkap Trilobita yang berenang cepat!", detail: "Klik/Tap spesimen Trilobita yang bergerak sebelum menghilang." },
                        { type: 'story', title: "Fase 5: Penemuan Fosil Trilobita", text: "Fosil Trilobita berhasil diangkat! Organisme bertulang luar keras ini mendominasi laut.", detail: "Trilobita adalah fosil indeks utama zaman Paleozoikum.", video: "{{ asset('assets/videos/paleozoikum_fase5.mp4') }}" },
                        { type: 'story', title: "Fase 6: Zaman Ikan (Devon)", text: "Vertebrata berahang berkembang pesat; ikan berkulit zirah menguasai lautan.", detail: "Muncul spesies ikan Dunkleosteus dengan gigitan penghancur.", video: "{{ asset('assets/videos/paleozoikum_fase6.mp4') }}" },
                        { type: 'story', title: "Fase 7: Invasi Tumbuhan ke Darat", text: "Tumbuhan paku raksasa mulai menghijaukan daratan dan menghasilkan oksigen melimpah.", detail: "Kadar oksigen bumi meningkat pesat hingga 35%.", video: "{{ asset('assets/videos/paleozoikum_fase7.mp4') }}" },
                        { type: 'story', title: "Fase 8: Kemunculan Amfibi Pertama", text: "Hewan bertulang belakang seperti Ichthyostega mulai merayap naik ke daratan.", detail: "Amfibi menjadi jembatan evolusi dari kehidupan laut ke darat.", video: "{{ asset('assets/videos/paleozoikum_fase8.mp4') }}" },
                        { type: 'story', title: "Fase 9: Hutan Karbon & Batubara", text: "Pohon-pohon raksasa yang tumbang tertimbun lumpur membentuk cadangan batubara dunia.", detail: "Serangga raksasa seperti Meganeura terbang di antara rawa.", video: "{{ asset('assets/videos/paleozoikum_fase9.mp4') }}" },
                        { type: 'story', title: "Fase 10: Kepunahan Masal Permian", text: "Era berakhir akibat bencana gunung berapi masal yang memusnahkan 95% spesies laut.", detail: "Peristiwa ini membuka jalan bagi kejayaan Dinosaurus.", video: "{{ asset('assets/videos/paleozoikum_fase10.mp4') }}" }
                    ];
                } else if (eraSlug === 'mesozoikum') {
                    this.timelineFlow = [
                        { type: 'story', title: "Fase 1: Pangea & Iklim Tropis", text: "Superbenua Pangea membentang luas dengan iklim yang hangat dan lembap.", detail: "Lingkungan sangat mendukung pertumbuhan reptil berukuran raksasa.", video: "{{ asset('assets/videos/mesozoikum_fase1.mp4') }}" },
                        { type: 'story', title: "Fase 2: Periode Trias (Reptil Awal)", text: "Dinosaurus kecil awal seperti Coelophysis mulai bermunculan di daratan.", detail: "Reptil memenangkan persaingan evolusi melawan amfibi purba.", video: "{{ asset('assets/videos/mesozoikum_fase2.mp4') }}" },
                        { type: 'story', title: "Fase 3: Periode Jura (Kejayaan Sauropoda)", text: "Dinosaurus leher panjang raksasa seperti Brachiosaurus mendominasi hutan.", detail: "Berat Brachiosaurus bisa mencapai lebih dari 50 ton.", video: "{{ asset('assets/videos/mesozoikum_fase3.mp4') }}" },
                        { type: 'minigame', gameType: 'puzzle', title: "Misi Rekonstruksi: Susun Rahang T-Rex", text: "Cocokkan potongan tulang raksasa ini menjadi susunan tengkorak utuh T-Rex!", detail: "Geser/klik bagian pecahan fosil hingga menempel sempurna." },
                        { type: 'story', title: "Fase 5: Penemuan Fosil T-Rex", text: "Tengkorak T-Rex ditemukan! Rahang raksasa ini dilengkapi gigi sepanjang 30 cm.", detail: "T-Rex adalah predator puncak karnivora di Periode Kapur.", video: "{{ asset('assets/videos/mesozoikum_fase5.mp4') }}" },
                        { type: 'story', title: "Fase 6: Penguasa Langit & Laut", text: "Pterodactyl terbang di udara, sementara Plesiosaurus berburu di dalam samudra.", detail: "Reptil menguasai seluruh domain darat, udara, dan laut.", video: "{{ asset('assets/videos/mesozoikum_fase6.mp4') }}" },
                        { type: 'story', title: "Fase 7: Kemunculan Tumbuhan Berbunga", text: "Bunga pertama dan serangga penyerbuk seperti lebah mulai berevolusi.", detail: "Vegetasi bumi menjadi lebih beragam dan berwarna.", video: "{{ asset('assets/videos/mesozoikum_fase7.mp4') }}" },
                        { type: 'story', title: "Fase 8: Mamalia Purba Kecil", text: "Nenek moyang mamalia berukuran kecil mirip tikus bersembunyi di dalam tanah.", detail: "Mamalia beraktivitas di malam hari untuk menghindari dinosaurus.", video: "{{ asset('assets/videos/mesozoikum_fase8.mp4') }}" },
                        { type: 'story', title: "Fase 9: Hantaman Asteroid Chicxulub", text: "Asteroid seluas 10 km menghantam bumi, memicu badai api dan tsunami global.", detail: "Debu vulkanik menutupi sinar matahari selama bertahun-tahun.", video: "{{ asset('assets/videos/mesozoikum_fase9.mp4') }}" },
                        { type: 'story', title: "Fase 10: Kepunahan Dinosaurus", text: "Seluruh dinosaurus raksasa punah, mengakhiri era Mesozoikum.", detail: "Hanya mamalia kecil dan burung yang berhasil selamat.", video: "{{ asset('assets/videos/mesozoikum_fase10.mp4') }}" }
                    ];
                } else if (eraSlug === 'neozoikum-tersier') {
                    this.timelineFlow = [
                        { type: 'story', title: "Fase 1: Kebangkitan Mamalia", text: "Punahnya dinosaurus memberi kesempatan bagi mamalia untuk berkembang pesat.", detail: "Mamalia mengalami radiasi adaptif mengisi relung ekosistem.", video: "{{ asset('assets/videos/neozoikum-tersier_fase1.mp4') }}" },
                        { type: 'story', title: "Fase 2: Perubahan Vegetasi", text: "Hutan lebat berkurang dan digantikan oleh padang rumput (sabana) yang meluas.", detail: "Mamalia pemakan rumput berkembang pesat di berbagai benua.", video: "{{ asset('assets/videos/neozoikum-tersier_fase2.mp4') }}" },
                        { type: 'story', title: "Fase 3: Munculnya Megafauna Tersier", text: "Lahir mamalia raksasa seperti Paraceratherium (mamalia darat terbesar).", detail: "Tinggi Paraceratherium mencapai 5 meter di bahunya.", video: "{{ asset('assets/videos/neozoikum-tersier_fase3.mp4') }}" },
                        { type: 'minigame', gameType: 'timing', title: "Misi Cabut Taring: Refleks Smilodon", text: "Hentikan garis indikator di zona hijau tepat waktu untuk mencabut Fosil Taring Smilodon!", detail: "Tekan tombol saat jarum tepat berada di area tengah." },
                        { type: 'story', title: "Fase 5: Temuan Taring Smilodon", text: "Kamu menemukan Fosil Taring Smilodon! Kucing ini memiliki taring sepanjang 28 cm.", detail: "Smilodon berburu megafauna pemakan rumput berukuran besar.", video: "{{ asset('assets/videos/neozoikum-tersier_fase5.mp4') }}" },
                        { type: 'story', title: "Fase 6: Penguasa Lautan Megalodon", text: "Hiu raksasa Megalodon mendominasi lautan purba, memangsa paus kecil.", detail: "Panjang Megalodon diperkirakan mencapai 18 meter.", video: "{{ asset('assets/videos/neozoikum-tersier_fase6.mp4') }}" },
                        { type: 'story', title: "Fase 7: Evolusi Primata Awal", text: "Kera dan primata awal mulai berkembang di atas pepohonan hutan tropis.", detail: "Primata mengembangkan penglihatan stereoskopis dan tangan pencengkeram.", video: "{{ asset('assets/videos/neozoikum-tersier_fase7.mp4') }}" },
                        { type: 'story', title: "Fase 8: Pembentukan Pegunungan Modern", text: "Tumbukan lempeng benua membentuk Pegunungan Himalaya dan Alpen.", detail: "Lanskap geografi bumi semakin mirip dengan kondisi modern.", video: "{{ asset('assets/videos/neozoikum-tersier_fase8.mp4') }}" },
                        { type: 'story', title: "Fase 9: Pendinginan Global Awal", text: "Suhu bumi perlahan menurun, menandai berakhirnya Masa Tersier.", detail: "Kutub bumi mulai membentuk lapisan es permanen.", video: "{{ asset('assets/videos/neozoikum-tersier_fase9.mp4') }}" },
                        { type: 'story', title: "Fase 10: Transisi Menuju Zaman Es", text: "Bumi bersiap memasuki Masa Kuarter (Kala Pleistosen & Holosen).", detail: "Megafauna berbulu tebal mulai mendominasi belahan utara.", video: "{{ asset('assets/videos/neozoikum-tersier_fase10.mp4') }}" }
                    ];
                } else if (eraSlug === 'pleistosen') {
                    this.timelineFlow = [
                        { type: 'story', title: "Fase 1: Puncak Zaman Es", text: "Gelombang glasial membekukan sebagian besar wilayah utara bumi.", detail: "Permukaan air laut merosot tajam karena air terperangkap menjadi es.", video: "{{ asset('assets/videos/pleistosen_fase1.mp4') }}" },
                        { type: 'story', title: "Fase 2: Adaptasi Megafauna Es", text: "Hewan mengembangkan bulu ganda yang tebal untuk bertahan di suhu sub-nol.", detail: "Mammoth dan Badak Berbulu mendominasi tundra beku.", video: "{{ asset('assets/videos/pleistosen_fase2.mp4') }}" },
                        { type: 'story', title: "Fase 3: Jembatan Darat Nusantara", text: "Turunnya laut menyatukan Jawa, Sumatra, dan Kalimantan dengan Asia (Paparan Sunda).", detail: "Hewan dan manusia purba bermigrasi melintasi daratan kering.", video: "{{ asset('assets/videos/pleistosen_fase3.mp4') }}" },
                        { type: 'minigame', gameType: 'icebreaker', title: "Misi Hancurkan Es: Permafrost Mammoth", text: "Pukul & hancurkan bongkahan es tebal ini untuk menyelamatkan Gading Mammoth!", detail: "Ketuk/Tap bongkahan es secara cepat sampai retak dan pecah total." },
                        { type: 'story', title: "Fase 5: Temuan Gading Mammoth", text: "Gading Mammoth berhasil diangkat utuh dari permafrost beku!", detail: "Mammoth menggunakan gading melengkungnya untuk menyapu es saat mencari rumput.", video: "{{ asset('assets/videos/pleistosen_fase5.mp4') }}" },
                        { type: 'story', title: "Fase 6: Kemunculan Homo Erectus", text: "Manusia purba Homo erectus berkembang pesat di Jawa (Sangiran & Trinil).", detail: "Mereka adalah hominid pertama yang berjalan tegak secara sempurna.", video: "{{ asset('assets/videos/pleistosen_fase6.mp4') }}" },
                        { type: 'story', title: "Fase 7: Penguasaan Api & Peralatan", text: "Homo erectus mulai memanfaatkan api untuk memasak dan membuat kapak perimbas batu.", detail: "Penguasaan api meningkatkan nutrisi otak dan kelangsungan hidup.", video: "{{ asset('assets/videos/pleistosen_fase7.mp4') }}" },
                        { type: 'story', title: "Fase 8: Berburu Megafauna", text: "Kelompok manusia purba bekerja sama berburu hewan besar menggunakan tombak.", detail: "Strategi kelompok menjadi kunci bertahan hidup di era Pleistosen.", video: "{{ asset('assets/videos/pleistosen_fase8.mp4') }}" },
                        { type: 'story', title: "Fase 9: Kepunahan Masal Megafauna Es", text: "Pemanasan suhu akhir Pleistosen memicu hilangnya habitat Mammoth.", detail: "Sebagian besar megafauna es mengalami kepunahan masal.", video: "{{ asset('assets/videos/pleistosen_fase9.mp4') }}" },
                        { type: 'story', title: "Fase 10: Fajar Manusia Modern", text: "Homo sapiens mulai menggantikan spesies manusia purba terdahulu.", detail: "Bumi bersiap memasuki Kala Holosen dan peradaban.", video: "{{ asset('assets/videos/pleistosen_fase10.mp4') }}" }
                    ];
                } else {
                    this.timelineFlow = [
                        { type: 'story', title: "Fase 1: Berakhirnya Zaman Es", text: "Suhu bumi meningkat, gletser mencair, dan air laut naik ke tingkatan modern.", detail: "Paparan Sunda tenggelam dan membentuk Kepulauan Indonesia.", video: "{{ asset('assets/videos/holosen_fase1.mp4') }}" },
                        { type: 'story', title: "Fase 2: Iklim Stabil Holosen", text: "Iklim bumi menjadi sangat stabil dan bersahabat bagi pemukiman.", detail: "Pola musim yang teratur memudahkan manusia memprediksi alam.", video: "{{ asset('assets/videos/holosen_fase2.mp4') }}" },
                        { type: 'story', title: "Fase 3: Revolusi Neolitikum", text: "Manusia Homo sapiens beralih dari pola berburu ke bercocok tanam (pertanian).", detail: "Perubahan pola hidup memicu lahirnya desa dan komunitas tetap.", video: "{{ asset('assets/videos/holosen_fase3.mp4') }}" },
                        { type: 'minigame', gameType: 'restoration', title: "Misi Restorasi: Bersihkan Prasasti Batu", text: "Usap debu purba dan susun ukiran huruf kuno hingga Prasasti terlihat utuh!", detail: "Bersihkan sisa tanah dan pasang kepingan ukiran prasasti." },
                        { type: 'story', title: "Fase 5: Temuan Prasasti Batu", text: "Prasasti dan artefak batu halus berhasil dikumpulkan!", detail: "Prasasti menjadi penanda dimulainya era sejarah dan budaya tulis.", video: "{{ asset('assets/videos/holosen_fase5.mp4') }}" },
                        { type: 'story', title: "Fase 6: Pengolahan Logam Awal", text: "Manusia menemukan teknik peleburan perunggu dan besi untuk membuat alat.", detail: "Era Zaman Perunggu & Besi mempercepat kemajuan teknologi.", video: "{{ asset('assets/videos/holosen_fase6.mp4') }}" },
                        { type: 'story', title: "Fase 7: Lahirnya Kerajaan Purba", text: "Pemukiman berkembang menjadi kota, pusat perdagangan, dan kerajaan besar.", detail: "Sistem sosial, hukum, dan struktur pemerintahan mulai terbentuk.", video: "{{ asset('assets/videos/holosen_fase7.mp4') }}" },
                        { type: 'story', title: "Fase 8: Peradaban Berkelanjutan", text: "Manusia membangun arsitektur megah, candi, dan pelayaran antar-benua.", detail: "Interaksi budaya global berkembang pesat di seluruh benua.", video: "{{ asset('assets/videos/holosen_fase8.mp4') }}" },
                        { type: 'story', title: "Fase 9: Era Teknologi Modern", text: "Perkembangan sains dan industri mengubah secara total cara hidup manusia.", detail: "Manusia menjelajahi angkasa luar dan menguasai informasi digital.", video: "{{ asset('assets/videos/holosen_fase9.mp4') }}" },
                        { type: 'story', title: "Fase 10: Penjelajah Waktu Selesai", text: "Kamu telah menuntaskan seluruh rangkaian ekspedisi sejarah geologi bumi!", detail: "Saatnya menguji seluruh pemahaman kamu di menu kuis.", video: "{{ asset('assets/videos/holosen_fase10.mp4') }}" }
                    ];
                }

                this.totalSteps = this.timelineFlow.length;

                // Play BGM
                const bgm = document.getElementById('globalBgm');
                if (bgm && bgmFile) {
                    bgm.src = bgmFile;
                    if (localStorage.getItem('bgm_active') === 'true') bgm.play().catch(function() {});
                }

                this.updateStepView();
            },

            updateStepView() {
                const currentData = this.timelineFlow[this.currentStep];
                this.stepType = currentData.type;
                this.currentGameType = currentData.gameType || 'scratch';
                this.currentTitle = currentData.title;
                this.currentDetail = currentData.detail;
                this.currentStoryData = currentData;

                this.renderTypewriter(currentData.text);

                if (this.stepType === 'minigame' && !this.minigamePassed) {
                    this.$nextTick(() => {
                        if (this.currentGameType === 'scratch') this.initScratchGame(eraSlug, 'scratchCanvas');
                        if (this.currentGameType === 'restoration') this.initScratchGame(eraSlug, 'restoreCanvas');
                        if (this.currentGameType === 'catch') this.startCatchGame();
                        if (this.currentGameType === 'timing') this.startTimingGame();
                    });
                }
            },

            nextStep() {
                if (typeof playSfx === 'function') playSfx();
                if (this.timingInterval) clearInterval(this.timingInterval);
                if (this.currentStep < this.totalSteps - 1) {
                    this.currentStep++;
                    this.updateStepView();
                }
            },

            prevStep() {
                if (typeof playSfx === 'function') playSfx();
                if (this.timingInterval) clearInterval(this.timingInterval);
                if (this.currentStep > 0) {
                    this.currentStep--;
                    this.updateStepView();
                }
            },

            // LOGIKA INTERAKTIF ERA 2: CATCH TRILOBITE
            startCatchGame() {
                this.catchScore = 0;
                this.moveTrilobite();
            },
            moveTrilobite() {
                if (this.minigamePassed) return;
                this.trilobiteX = Math.floor(Math.random() * 65) + 10;
                this.trilobiteY = Math.floor(Math.random() * 55) + 20;
            },
            hitTrilobite() {
                this.catchScore++;
                if (typeof playSfx === 'function') playSfx();
                if (this.catchScore >= 3) {
                    this.passMinigame();
                } else {
                    this.moveTrilobite();
                }
            },

            // LOGIKA INTERAKTIF ERA 3: PUZZLE T-REX
            clickPuzzle(index) {
                if (this.puzzleParts[index].clicked || this.minigamePassed) return;
                this.puzzleParts[index].clicked = true;
                this.puzzleProgress++;
                if (typeof playSfx === 'function') playSfx();
                if (this.puzzleProgress >= 3) {
                    this.passMinigame();
                }
            },

            // LOGIKA INTERAKTIF ERA 4: TIMING BAR SMILODON (DIPERBAIKI)
            startTimingGame() {
                if (this.timingInterval) clearInterval(this.timingInterval);
                this.timingPos = 0;
                this.timingDir = 3;
                this.timingInterval = setInterval(() => {
                    this.timingPos += this.timingDir;
                    if (this.timingPos >= 95 || this.timingPos <= 0) {
                        this.timingDir *= -1;
                    }
                }, 20);
            },
            checkTiming() {
                if (this.minigamePassed) return;
                // Zona hijau diatur presisi di 35% sampai 65%
                if (this.timingPos >= 35 && this.timingPos <= 65) {
                    clearInterval(this.timingInterval);
                    if (typeof playSfx === 'function') playSfx();
                    this.passMinigame();
                } else {
                    if (typeof playSfx === 'function') playSfx();
                    // Efek mental ketika meleset sedikit agar tidak stuck
                }
            },

            // LOGIKA INTERAKTIF ERA 5: ICEBREAKER
            tapIce() {
                this.iceTaps++;
                if (typeof playSfx === 'function') playSfx();
                if (this.iceTaps >= 8) {
                    this.passMinigame();
                }
            },

            passMinigame() {
                if (this.minigamePassed) return;
                this.minigamePassed = true;

                // SIMPAN FOSIL KE DATABASE VIA AJAX
                const currentEraId = "{{ $era->id }}";
                const saveUrl = "{{ route('game.saveFossil') }}";
                const csrfToken = "{{ csrf_token() }}";

                fetch(saveUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({
                        era_id: currentEraId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (typeof playSfx === 'function') playSfx();
                    console.log("Fosil berhasil disimpan ke galeri koleksi!");
                })
                .catch(err => console.error(err));
            },

            // Perbaikan Typewriter agar aman dari glitch HTML (menggunakan x-text)
            renderTypewriter(text) {
                let i = 0;
                this.displayedText = "";
                
                const type = () => {
                    if (i < text.length) {
                        this.displayedText += text.charAt(i);
                        i++;
                        setTimeout(type, 18);
                    }
                };
                type();
            },

            // LOGIKA CANVAS ERA 1 & ERA 6
            initScratchGame(eraSlug, canvasId) {
                const canvas = document.getElementById(canvasId);
                if (!canvas) return;
                const ctx = canvas.getContext('2d');

                canvas.width = canvas.offsetWidth;
                canvas.height = canvas.offsetHeight;

                ctx.fillStyle = canvasId === 'scratchCanvas' ? '#3f0e0e' : '#44403c';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                for (let i = 0; i < 200; i++) {
                    ctx.fillStyle = 'rgba(255,255,255,0.15)';
                    ctx.fillRect(Math.random() * canvas.width, Math.random() * canvas.height, 3, 3);
                }

                let isDrawing = false;
                let scratchCount = 0;

                const doScratch = (e) => {
                    if (!isDrawing || this.minigamePassed) return;
                    const rect = canvas.getBoundingClientRect();
                    const x = (e.clientX || (e.touches && e.touches[0].clientX)) - rect.left;
                    const y = (e.clientY || (e.touches && e.touches[0].clientY)) - rect.top;

                    ctx.globalCompositeOperation = 'destination-out';
                    ctx.beginPath();
                    ctx.arc(x, y, 22, 0, Math.PI * 2);
                    ctx.fill();

                    scratchCount++;
                    if (scratchCount > 35) {
                        this.passMinigame();
                    }
                };

                canvas.addEventListener('mousedown', () => isDrawing = true);
                canvas.addEventListener('mouseup', () => isDrawing = false);
                canvas.addEventListener('mousemove', doScratch);

                canvas.addEventListener('touchstart', () => isDrawing = true);
                canvas.addEventListener('touchend', () => isDrawing = false);
                canvas.addEventListener('touchmove', doScratch);
            }
        }
    }
</script>
@endsection