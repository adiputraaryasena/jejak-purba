<?php

namespace Database\Seeders;

use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan data lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('quizzes')->truncate();
        DB::table('eras')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. DATA ERA PURBA (6 LEVEL) + NARASI PANJANG & KONSEP MINI-GAME

        // ERA 1: ARKAIKUM
        $era1 = DB::table('eras')->insertGetId([
            'name' => 'Arkaikum',
            'slug' => 'arkaikum',
            'story_text' => 'Bumi terbentuk sekitar 4,6 hingga 2,5 miliar tahun yang lalu. Pada awal Arkaikum, planet ini berupa bola magma cair yang sangat panas dengan permukaan yang membara akibat serbuan hujan meteorit beruntun. Gunung berapi meletus tanpa henti, memuntahkan lahar dan gas beracun. Atmosfer bumi purba belum memiliki oksigen bebas, melainkan dipenuhi metana, karbon dioksida, dan amonia. Seiring berjalannya waktu, uap air terkondensasi membentuk lautan panas pertama. Di lautan asam yang hangat inilah muncul tanda kehidupan paling awal di bumi: mikroorganisme uniseluler anaerob (sianobakteri) yang membentuk koloni berlapis bernama Stromatolit.',
            'bgm_file' => 'bgm_arkaikum.mp3',
            'order_level' => 1,
            'min_score_unlock' => 0,
            'fossil_name' => 'Batu Magma & Fosil Stromatolit',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // ERA 2: PALEOZOIKUM
        $era2 = DB::table('eras')->insertGetId([
            'name' => 'Paleozoikum',
            'slug' => 'paleozoikum',
            'story_text' => 'Berlangsung antara 541 hingga 252 juta tahun lalu, Paleozoikum ditandai dengan mendinginnya suhu bumi dan meluasnya lautan. Era ini diawali oleh peristiwa "Ledakan Kambrium", di mana jutaan spesies hewan bercangkang keras bermunculan di laut, seperti Trilobita dan Amonit. Memasuki Periode Devon ("Zaman Ikan"), vertebrata berahang berkembang pesat dan amfibi pertama mulai merayap naik ke daratan. Pada Periode Karbon, hutan tumbuhan paku raksasa menutupi bumi, menghasilkan kadar oksigen tinggi (35%) dan serangga raksasa seperti Meganeura. Era ini diakhiri oleh kepunahan masal terhebat sepanjang sejarah (Permian Mass Extinction) yang memusnahkan 95% spesies laut.',
            'bgm_file' => 'bgm_paleozoikum.mp3',
            'order_level' => 2,
            'min_score_unlock' => 70,
            'fossil_name' => 'Fosil Trilobita & Ikan Zirah Purba',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // ERA 3: MESOZOIKUM
        $era3 = DB::table('eras')->insertGetId([
            'name' => 'Mesozoikum',
            'slug' => 'mesozoikum',
            'story_text' => 'Berlangsung 252 hingga 66 juta tahun lalu, Mesozoikum dikenal sebagai "Zaman Reptil Raksasa" atau "Zaman Dinosaurus". Era ini terbagi atas Periode Trias, Jura, dan Kapur. Superbenua Pangea mulai terbelah menjadi daratan Laurasia dan Gondwana dengan iklim hangat tropis. Sauropoda raksasa seperti Brachiosaurus mendominasi hutan, sementara predator puncak seperti Tyrannosaurus Rex dan Velociraptor menguasai akhir Periode Kapur. Tanaman berbunga (Angiospermae) dan burung pertama (Archaeopteryx) mulai berevolusi. Kejayaan dinosaurus berakhir dramatis saat asteroid berdiameter 10 km menghantam Kawah Chicxulub di Meksiko.',
            'bgm_file' => 'bgm_mesozoikum.mp3',
            'order_level' => 3,
            'min_score_unlock' => 70,
            'fossil_name' => 'Tengkorak & Gigi T-Rex',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // ERA 4: NEOZOIKUM TERSIER
        $era4 = DB::table('eras')->insertGetId([
            'name' => 'Neozoikum Tersier',
            'slug' => 'neozoikum-tersier',
            'story_text' => 'Memasuki 66 hingga 2,6 juta tahun lalu, punahnya dinosaurus membuka jalan bagi radiasi adaptif mamalia. Mamalia kecil yang selamat berevolusi menjadi beragam spesies megafauna purba. Hutan lebat berganti menjadi padang rumput meluas, memicu perkembangan mamalia herbivora pemamah biak. Daratan dikuasai oleh predator puncak seperti Smilodon (kucing bergigi pedang) dan Paraceratherium (mamalia darat terbesar). Di lautan purba, hiu raksasa Megalodon menjadi penguasa rantai makanan samudra.',
            'bgm_file' => 'bgm_neozoikum.mp3',
            'order_level' => 4,
            'min_score_unlock' => 70,
            'fossil_name' => 'Taring Smilodon & Gigi Megalodon',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // ERA 5: KALA PLEISTOSEN
        $era5 = DB::table('eras')->insertGetId([
            'name' => 'Kala Pleistosen',
            'slug' => 'pleistosen',
            'story_text' => 'Berlangsung dari 2,6 juta hingga 11.700 tahun lalu, Pleistosen adalah zaman es di mana gletser tebal meluas menutupi sebagian besar belahan bumi utara. Hewan-hewan megafauna mengembangkan adaptasi ekstrem berupa bulu ganda yang sangat tebal, seperti Mammoth (Gajah Purba) dan Rhinoceros Berbulu. Di saat yang sama, spesies manusia purba (Hominid) seperti Homo erectus berkembang pesat di berbagai bagian dunia, termasuk Jawa (Pithecanthropus erectus). Mereka mulai menguasai penggunaan api dan berburu menggunakan tombak batu sederhana.',
            'bgm_file' => 'bgm_pleistosen.mp3',
            'order_level' => 5,
            'min_score_unlock' => 70,
            'fossil_name' => 'Gading Mammoth & Tengkorak Homo Erectus',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // ERA 6: KALA HOLOSEN
        $era6 = DB::table('eras')->insertGetId([
            'name' => 'Kala Holosen',
            'slug' => 'holosen',
            'story_text' => 'Dimulai sejak 11.700 tahun lalu hingga saat ini, Kala Holosen ditandai dengan melehlehnya es glasial dan stabilnya iklim bumi. Mencairnya es meningkatkan volume air laut, memisahkan daratan utama dan membentuk kepulauan modern (termasuk Kepulauan Nusantara). Sebagian besar megafauna es mengalami kepunahan. Manusia modern (Homo sapiens) mendominasi bumi, mengalami Revolusi Neolitikum dengan beralih dari pola berburu ke bercocok tanam, membangun desa, kerajaan, hingga menciptakan teknologi peradaban modern.',
            'bgm_file' => 'bgm_holosen.mp3',
            'order_level' => 6,
            'min_score_unlock' => 80,
            'fossil_name' => 'Prasasti Batu & Artefak Kapak Persegi',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // 3. BANK SOAL KUIS UNTUK SEMUA ERA (1-6)
        DB::table('quizzes')->insert([
            // ERA 1
            // Pertanyaan 1 (Fase 1: Pembentukan Kerak Bumi)
            [
                'era_id' => $era1,
                'question' => 'Bagaimana kondisi awal pembentukan bumi sekitar 4,6 miliar tahun lalu pada Fase 1?',
                'option_a' => 'Terbentuk dari daratan es yang membeku',
                'option_b' => 'Terbentuk dari kumpulan debu dan gas kosmik dengan suhu sangat tinggi',
                'option_c' => 'Sudah dipenuhi samudra air tawar yang dingin',
                'option_d' => 'Langsung dikelilingi oleh atmosfer berbahan oksigen murni',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Pada awal terbentuknya, bumi berasal dari kumpulan debu & gas kosmik dengan suhu ekstrem tinggi dan belum ada daratan padat.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 2 (Fase 2: Samudra Magma Cair)
            [
                'era_id' => $era1,
                'question' => 'Apa yang menutupi seluruh permukaan bumi pada Fase 2 Era Arkaikum?',
                'option_a' => 'Hutan hujan tropis yang lebat',
                'option_b' => 'Lautan magma cair yang gejolaknya dipicu hujan meteorit raksasa',
                'option_c' => 'Lapisan es abadi yang tebal',
                'option_d' => 'Terumbu karang purba yang luas',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Permukaan bumi awal ditutupi lautan magma cair bergejolak akibat benturan hujan meteorit raksasa secara terus-menerus.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 3 (Fase 3: Atmosfer Purba Beracun)
            [
                'era_id' => $era1,
                'question' => 'Kandungan gas apa yang mendominasi atmosfer purba bumi pada Fase 3?',
                'option_a' => 'Metana, amonia, dan karbon dioksida (CO2) tanpa oksigen',
                'option_b' => 'Oksigen murni dan nitrogen',
                'option_c' => 'Uap air tawar dan helium murni',
                'option_d' => 'Ozon tebal dan hidrogen murni',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Atmosfer awal dipenuhi gas metana, amonia, dan CO2 tanpa oksigen, sehingga organisme aerobik belum bisa hidup.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 4 (Minigame / Fase 4: Kerak Magma Beku)
            [
                'era_id' => $era1,
                'question' => 'Apa yang dapat ditemukan di balik lapisan lahar/magma beku hasil ekskavasi purba?',
                'option_a' => 'Fosil dinosaurus raksasa',
                'option_b' => 'Jejak fosil mikroorganisme pertama di bumi',
                'option_c' => 'Tulang belulang mamut purba',
                'option_d' => 'Alat-alat batu manusia purba',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Ekskavasi pada lapisan kerak lahar beku bertujuan untuk menemukan bukti mikroorganisme paling awal di bumi.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 5 (Fase 5: Pembentukan Lautan Panas)
            [
                'era_id' => $era1,
                'question' => 'Bagaimana lautan asam hangat pertama di bumi terbentuk pada Fase 5?',
                'option_a' => 'Pencairan gletser es secara mendadak',
                'option_b' => 'Uap air atmosfer mendingin dan turun sebagai hujan lebat selama jutaan tahun',
                'option_c' => 'Luapan air dari dasar inti bumi',
                'option_d' => 'Serapan air dari benturan komet es murni',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Proses pendinginan uap air di atmosfer memicu hujan lebat jutaan tahun yang melarutkan mineral menjadi lautan asam hangat.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 6 (Fase 6: Sintesis Kimia Organik)
            [
                'era_id' => $era1,
                'question' => 'Reaksi apa yang terjadi di dalam lautan hangat pada Fase 6 yang memicu awal kehidupan?',
                'option_a' => 'Sintesis reaksi kimia molekul organik (rantai RNA)',
                'option_b' => 'Pembelahan inti atom uranium',
                'option_c' => 'Pembentukan zat klorofil tanaman hijau',
                'option_d' => 'Reaksi pembekuan mineral besi secara massal',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Lautan hangat menjadi tempat terjadinya reaksi kimia molekul organik yang melahirkan molekul kehidupan awal (RNA).',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 7 (Fase 7: Sianobakteri Uniseluler)
            [
                'era_id' => $era1,
                'question' => 'Bagaimana sifat dari organisme bersel tunggal pertama (sianobakteri) yang muncul di laut purba?',
                'option_a' => 'Membutuhkan oksigen tinggi untuk bernapas (Aerobik)',
                'option_b' => 'Hidup tanpa membutuhkan oksigen bebas (Anaerob)',
                'option_c' => 'Memiliki organ tubuh kompleks dan tulang belakang',
                'option_d' => 'Mampu terbang dan hidup di daratan kering',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Sianobakteri uniseluler adalah organisme anaerob yang dapat bertahan hidup di laut tanpa adanya oksigen bebas.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 8 (Fase 8: Kemunculan Stromatolit)
            [
                'era_id' => $era1,
                'question' => 'Struktur fosil biologis tertua di bumi yang dibentuk oleh koloni sianobakteri disebut...',
                'option_a' => 'Trilobit',
                'option_b' => 'Stromatolit',
                'option_c' => 'Ammonite',
                'option_d' => 'Megatherium',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Stromatolit adalah fosil struktur biologis tertua di bumi hasil endapan kalsium karbonat koloni sianobakteri.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 9 (Fase 9: Awal Pelepasan Oksigen)
            [
                'era_id' => $era1,
                'question' => 'Proses apa yang dilakukan sianobakteri sehingga mulai menghasilkan gas oksigen tipis pada Fase 9?',
                'option_a' => 'Fermentasi racun besi',
                'option_b' => 'Fotosintesis purba',
                'option_c' => 'Respirasi anaerobik ekstrem',
                'option_d' => 'Penguapan air laut',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Sianobakteri mulai melakukan fotosintesis purba yang perlahan memproduksi tipis gas oksigen ke lingkungan.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 10 (Fase 10: Akhir Era Arkaikum)
            [
                'era_id' => $era1,
                'question' => 'Apa yang menandai berakhirnya Era Arkaikum menuju Era Paleozoikum pada Fase 10?',
                'option_a' => 'Seluruh daratan bumi hancur menjadi debu',
                'option_b' => 'Bumi membeku total tanpa ada sisa air',
                'option_c' => 'Kerak bumi mulai stabil dan siap mendukung keanekaragaman kehidupan laut',
                'option_d' => 'Dinosaurus pertama mulai menguasai daratan',
                'correct_answer' => 'c',
                'score_points' => 10,
                'explanation' => 'Akhir Arkaikum ditandai dengan mulai stabilnya kerak bumi sebagai pondasi penting memasuki era keanekaragaman laut (Paleozoikum).',
                'created_at' => now(), 'updated_at' => now()
            ],

            // ERA 2
            // Pertanyaan 1 (Fase 1: Mendinginnya Iklim Bumi)
            [
                'era_id' => $era2,
                'question' => 'Apa ciri khas kondisi iklim dan lingkungan bumi pada awal Zaman Paleozoikum?',
                'option_a' => 'Seluruh permukaan bumi tertutup magma cair',
                'option_b' => 'Suhu bumi semakin mendingin, stabil, dan lautan meluas menjadi pusat biologi',
                'option_c' => 'Atmosfer bumi belum memiliki uap air sama sekali',
                'option_d' => 'Bumi mengalami pemanasan global ekstrem hingga lautan mengering',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Awal Paleozoikum ditandai dengan iklim yang semakin stabil dan dingin, membuat lautan meluas dan menjadi pusat perkembangan biologi.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 2 (Fase 2: Ledakan Kambrium)
            [
                'era_id' => $era2,
                'question' => 'Peristiwa penting apa yang terjadi pada Fase 2 yang dikenal dengan sebutan "Ledakan Kambrium"?',
                'option_a' => 'Kepunahan seluruh makhluk hidup di lautan',
                'option_b' => 'Kemunculan massal secara mendadak jutaan spesies hewan laut bercangkang',
                'option_c' => 'Ledakan gunung berapi terbesar di inti bumi',
                'option_d' => 'Bumi tertutup oleh lapisan es tebal selama jutaan tahun',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Ledakan Kambrium adalah peristiwa kemunculan mendadak berbagai spesies hewan laut yang mulai mengembangkan jaringan keras dan cangkang.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 3 (Fase 3: Dominasi Invertebrata Laut)
            [
                'era_id' => $era2,
                'question' => 'Kelompok hewan apa yang mendominasi terumbu karang purba pada Fase 3 Paleozoikum?',
                'option_a' => 'Invertebrata laut seperti siput laut, Amonit, dan ubur-ubur purba',
                'option_b' => 'Mamalia besar dan berbulu tebal',
                'option_c' => 'Dinosaurus pemakan daging',
                'option_d' => 'Reptil raksasa bersayap',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Laut Paleozoikum awal didominasi oleh invertebrata laut tanpa tulang belakang yang membentuk rantai makanan kompleks.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 4 (Minigame / Fase 4: Sedimen Laut Purba)
            [
                'era_id' => $era2,
                'question' => 'Lapisan batuan apa yang harus dikikis pada misi ekskavasi untuk menemukan fosil bercangkang Paleozoikum?',
                'option_a' => 'Batu granit vulkanik panas',
                'option_b' => 'Sedimen dasar laut purba',
                'option_c' => 'Lapisan es abadi Kutub Utara',
                'option_d' => 'Lahar dingin hasil letusan dahsyat',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Fosil organisme bercangkang Paleozoikum tersimpan di dalam endapan batuan sedimen dasar laut purba.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 5 (Fase 5: Penemuan Fosil Trilobita)
            [
                'era_id' => $era2,
                'question' => 'Mengapa Trilobita menjadi salah satu fosil paling penting pada zaman Paleozoikum?',
                'option_a' => 'Karena Trilobita adalah dinosaurus terbesar di lautan',
                'option_b' => 'Karena Trilobita merupakan fosil indeks utama organisme bertulang luar keras yang mendominasi laut',
                'option_c' => 'Karena Trilobita dapat terbang di daratan',
                'option_d' => 'Karena Trilobita adalah tumbuhan bersel satu pertama',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Trilobita memiliki tubuh bertulang luar (eksoskeleton) keras dan menjadi fosil panduan/indeks utama era Paleozoikum.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 6 (Fase 6: Zaman Ikan / Devon)
            [
                'era_id' => $era2,
                'question' => 'Spesies ikan bertulang zirah dengan gigitan sangat kuat yang menguasai lautan pada Zaman Devon adalah...',
                'option_a' => 'Megalodon',
                'option_b' => 'Dunkleosteus',
                'option_c' => 'Ichthyostega',
                'option_d' => 'Trilobita',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Dunkleosteus adalah predator puncak Zaman Devon (Zaman Ikan) dengan kulit zirah pelindung dan gigitan pemungkas.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 7 (Fase 7: Invasi Tumbuhan ke Darat)
            [
                'era_id' => $era2,
                'question' => 'Dampak utama dari invasi tumbuhan paku raksasa ke daratan pada Fase 7 adalah...',
                'option_a' => 'Penurunan kadar air laut secara drastis',
                'option_b' => 'Peningkatan kadar oksigen bumi pesat hingga mencapai 35%',
                'option_c' => 'Penyebab utama dari letusan gunung berapi masal',
                'option_d' => 'Matinya seluruh biota laut karena racun daun',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Melimpahnya tumbuhan paku raksasa di daratan memicu produksi oksigen besar-besaran hingga kadar oksigen atmosfer menyentuh 35%.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 8 (Fase 8: Kemunculan Amfibi Pertama)
            [
                'era_id' => $era2,
                'question' => 'Hewan bertulang belakang pertama yang menjadi jembatan evolusi dari air ke darat (seperti Ichthyostega) tergolong dalam kelompok...',
                'option_a' => 'Reptil',
                'option_b' => 'Amfibi',
                'option_c' => 'Mamalia',
                'option_d' => 'Unggas',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Amfibi purba seperti Ichthyostega merupakan pioneer hewan berkaki empat (tetrapoda) yang mulai merayap dan hidup di dua alam.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 9 (Fase 9: Hutan Karbon & Batubara)
            [
                'era_id' => $era2,
                'question' => 'Pohon-pohon raksasa yang tumbang dan tertimbun di rawa-rawa purba Zaman Karbon menjadi cikal bakal terbentuknya...',
                'option_a' => 'Cadangan batubara dunia',
                'option_b' => 'Intan dan permata murni',
                'option_c' => 'Lautan garam raksasa',
                'option_d' => 'Gas helium atmosfer',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Hutan raksasa yang tertimbun lumpur tanpa pembusukan sempurna selama jutaan tahun membentuk deposit batubara bumi saat ini.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 10 (Fase 10: Kepunahan Masal Permian)
            [
                'era_id' => $era2,
                'question' => 'Bencana apa yang mengakhiri Era Paleozoikum dan memusnahkan hingga 95% spesies laut pada peristiwa Kepunahan Permian?',
                'option_a' => 'Hantaman meteorit es raksasa',
                'option_b' => 'Bencana vulkanisme gunung berapi massal',
                'option_c' => 'Zaman es yang berlangsung seribu tahun',
                'option_d' => 'Serangan bakteri pemakan oksigen',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Letusan gunung berapi dahsyat secara masal di akhir Zaman Permian memicu kepunahan terbesar dalam sejarah bumi, membukakan jalan bagi era Mesozoikum.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // ERA 3
            // Pertanyaan 1 (Fase 1: Pangea & Iklim Tropis)
            [
                'era_id' => $era3,
                'question' => 'Bagaimana kondisi benua dan iklim bumi pada awal Era Mesozoikum?',
                'option_a' => 'Seluruh benua terpisah oleh samudra es yang dingin',
                'option_b' => 'Daratan menyatu dalam superbenua Pangea dengan iklim hangat dan lembap',
                'option_c' => 'Bumi tertutup oleh lautan magma cair tanpa daratan',
                'option_d' => 'Permukaan bumi diselimuti oleh gurun pasir tanpa tumbuh-tumbuhan',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Mesozoikum diawali dengan keberadaan superbenua Pangea yang beriklim hangat dan lembap, sangat mendukung evolusi reptil raksasa.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 2 (Fase 2: Periode Trias - Reptil Awal)
            [
                'era_id' => $era3,
                'question' => 'Dinosaurus kecil awal seperti Coelophysis mulai bermunculan pada periode apa?',
                'option_a' => 'Periode Trias',
                'option_b' => 'Periode Jura',
                'option_c' => 'Periode Kapur',
                'option_d' => 'Periode Silur',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Periode Trias merupakan awal kemunculan dinosaurus kecil seperti Coelophysis yang berhasil mengungguli amfibi purba.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 3 (Fase 3: Periode Jura - Kejayaan Sauropoda)
            [
                'era_id' => $era3,
                'question' => 'Dinosaurus leher panjang raksasa seperti Brachiosaurus mendominasi hutan bumi pada periode...',
                'option_a' => 'Trias',
                'option_b' => 'Jura',
                'option_c' => 'Permian',
                'option_d' => 'Devon',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Periode Jura adalah masa kejayaan dinosaurus Sauropoda berleher panjang seperti Brachiosaurus yang bobotnya mencapai lebih dari 50 ton.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 4 (Minigame / Fase 4: Batuan Endapan Kapur)
            [
                'era_id' => $era3,
                'question' => 'Lapisan batuan apa yang digali pada misi ekskavasi untuk menemukan fosil sang predator puncak Mesozoikum?',
                'option_a' => 'Batuan vulkanik lahar beku',
                'option_b' => 'Batuan endapan Kapur',
                'option_c' => 'Sedimen es purba',
                'option_d' => 'Batuan granit metamorf',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Fosil predator puncak Periode Kapur tertimbun di dalam lapisan batuan endapan Kapur.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 5 (Fase 5: Penemuan Fosil T-Rex)
            [
                'era_id' => $era3,
                'question' => 'Ciri khas utama dari Tyrannosaurus Rex (T-Rex) sebagai predator puncak Periode Kapur adalah...',
                'option_a' => 'Memiliki sayap lebar untuk terbang',
                'option_b' => 'Rahang raksasa dengan gigi tajam mencapai panjang 30 cm',
                'option_c' => 'Leher sangat panjang untuk memakan daun pohon tinggi',
                'option_d' => 'Memiliki cangkang keras di punggungnya',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'T-Rex merupakan carnivora puncak Periode Kapur yang dilengkapi rahang kuat dan gigi sepanjang 30 cm.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 6 (Fase 6: Penguasa Langit & Laut)
            [
                'era_id' => $era3,
                'question' => 'Reptil purba yang menguasai wilayah lautan pada Era Mesozoikum adalah...',
                'option_a' => 'Pterodactyl',
                'option_b' => 'Plesiosaurus',
                'option_c' => 'Brachiosaurus',
                'option_d' => 'Stegosaurus',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Plesiosaurus berburu di dalam lautan, sedangkan Pterodactyl menjadi penguasa wilayah udara.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 7 (Fase 7: Kemunculan Tumbuhan Berbunga)
            [
                'era_id' => $era3,
                'question' => 'Perkembangan penting pada dunia tumbuhan yang muncul pada Era Mesozoikum adalah...',
                'option_a' => 'Munculnya tumbuhan berbunga dan serangga penyerbuk seperti lebah',
                'option_b' => 'Punahnya seluruh jenis pohon paku raksasa',
                'option_c' => 'Daratan bumi kehilangan seluruh vegetasi hijau',
                'option_d' => 'Tumbuhan mulai memangsa dinosaurus kecil',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Mesozoikum menjadi saksi evolusi pertama tumbuhan berbunga (Angiospermae) bersama serangga penyerbuk seperti lebah.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 8 (Fase 8: Mamalia Purba Kecil)
            [
                'era_id' => $era3,
                'question' => 'Bagaimana cara mamalia purba pertama bertahan hidup di tengah dominasi dinosaurus?',
                'option_a' => 'Mengembangkan ukuran tubuh yang lebih besar dari T-Rex',
                'option_b' => 'Berukuran kecil mirip tikus, bersembunyi di dalam tanah, dan aktif di malam hari',
                'option_c' => 'Terbang bebas di udara bersama Pterodactyl',
                'option_d' => 'Membentuk kelompok berburu untuk menyerang Sauropoda',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Nenek moyang mamalia berukuran kecil dan memilih beraktivitas pada malam hari (nokturnal) untuk menghindari ancaman dinosaurus.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 9 (Fase 9: Hantaman Asteroid Chicxulub)
            [
                'era_id' => $era3,
                'question' => 'Bencana utama yang menjadi pemicu badai api dan penutupan sinar matahari secara global adalah...',
                'option_a' => 'Letusan gunung berapi bawah laut',
                'option_b' => 'Hantaman asteroid Chicxulub seluas 10 km',
                'option_c' => 'Kebocoran gas metana massal dari lautan',
                'option_d' => 'Gelombang Zaman Es yang datang secara tiba-tiba',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Hantaman asteroid Chicxulub berdiameter 10 km memicu tsunami, badai api, dan debu vulkanik yang menghalangi sinar matahari bertahun-tahun.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 10 (Fase 10: Kepunahan Dinosaurus)
            [
                'era_id' => $era3,
                'question' => 'Kelompok hewan apa yang berhasil bertahan hidup dari peristiwa kepunahan masal di akhir Era Mesozoikum?',
                'option_a' => 'Seluruh spesies dinosaurus raksasa',
                'option_b' => 'Mamalia kecil dan burung',
                'option_c' => 'Plesiosaurus dan Pterodactyl',
                'option_d' => 'Reptil darat raksasa',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Peristiwa kepunahan masal memusnahkan seluruh dinosaurus raksasa, namun mamalia kecil dan burung berhasil selamat untuk melanjutkan evolusi.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // ERA 4
            // Pertanyaan 1 (Fase 1: Kebangkitan Mamalia)
            [
                'era_id' => $era4,
                'question' => 'Faktor utama yang memicu perkembangan pesat dan kebangkitan mamalia pada awal Masa Tersier adalah...',
                'option_a' => 'Punahnya kelompok dinosaurus raksasa',
                'option_b' => 'Pencairan seluruh es di wilayah kutub',
                'option_c' => 'Turunnya kadar oksigen di laut secara masal',
                'option_d' => 'Hilangnya seluruh vegetasi tumbuhan di daratan',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Punahnya dinosaurus membuka kesempatan bagi mamalia untuk melakukan radiasi adaptif dan mengisi relung ekosistem yang kosong.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 2 (Fase 2: Perubahan Vegetasi)
            [
                'era_id' => $era4,
                'question' => 'Perubahan ekosistem tumbuhan apa yang memicu perkembangan pesat mamalia pemakan rumput pada Fase 2?',
                'option_a' => 'Hutan hujan tropis menutupi seluruh daratan bumi',
                'option_b' => 'Hutan lebat berkurang dan digantikan oleh padang rumput (sabana) yang meluas',
                'option_c' => 'Seluruh daratan berubah menjadi gurun pasir tanpa vegetasi',
                'option_d' => 'Tumbuhan paku purba mendominasi kembali daratan',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Menyusutnya hutan lebat dan meluasnya padang rumput (sabana) mendukung ledakan populasi mamalia pemakan rumput.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 3 (Fase 3: Munculnya Megafauna Tersier)
            [
                'era_id' => $era4,
                'question' => 'Mamalia darat terbesar yang lahir pada Masa Tersier dengan tinggi bahu mencapai 5 meter adalah...',
                'option_a' => 'Brachiosaurus',
                'option_b' => 'Paraceratherium',
                'option_c' => 'Smilodon',
                'option_d' => 'Megatherium',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Paraceratherium merupakan mamalia darat terbesar sepanjang sejarah dengan tinggi mencapai 5 meter di bagian bahunya.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 4 (Minigame / Fase 4: Batuan Cadas Tersier)
            [
                'era_id' => $era4,
                'question' => 'Sedimen tanah apa yang dikikis pada misi ekskavasi untuk menemukan fosil senjata predator pedang?',
                'option_a' => 'Batuan cadas Tersier',
                'option_b' => 'Lahar beku Arkaikum',
                'option_c' => 'Batuan kapur laut purba',
                'option_d' => 'Gletser es Pleistosen',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Fosil taring predator pedang tersimpan rapat di dalam lapisan sedimen tanah cadas Tersier.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 5 (Fase 5: Temuan Taring Smilodon)
            [
                'era_id' => $era4,
                'question' => 'Ciri khas utama dari kucing purba Smilodon yang ditemukan pada Fase 5 adalah...',
                'option_a' => 'Memiliki sayap lebar untuk menerkam mangsa',
                'option_b' => 'Memiliki sepasang taring pedang sepanjang 28 cm',
                'option_c' => 'Tubuhnya dilindungi oleh cangkang baja keras',
                'option_d' => 'Mampu bernapas di dalam air laut',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Smilodon (Kucing Bertaring Pedang) terkenal dengan taring melengkung sepanjang 28 cm untuk berburu megafauna.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 6 (Fase 6: Penguasa Lautan Megalodon)
            [
                'era_id' => $era4,
                'question' => 'Predator raksasa lautan purba yang panjangnya mencapai 18 meter dan memburu paus kecil adalah...',
                'option_a' => 'Plesiosaurus',
                'option_b' => 'Megalodon',
                'option_c' => 'Dunkleosteus',
                'option_d' => 'Ichthyostega',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Megalodon adalah spesies hiu purba raksasa dengan estimasi panjang 18 meter yang mendominasi lautan Masa Tersier.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 7 (Fase 7: Evolusi Primata Awal)
            [
                'era_id' => $era4,
                'question' => 'Adaptasi penting yang dikembangkan primata awal di atas pohon pada Fase 7 adalah...',
                'option_a' => 'Tanduk keras dan ekor bersisik',
                'option_b' => 'Penglihatan stereoskopis dan tangan pencengkeram',
                'option_c' => 'Insang untuk bernapas saat banjir',
                'option_d' => 'Bulu tebal tahan suhu es',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Primata awal mengembangkan penglihatan stereoskopis (3D) serta struktur tangan pencengkeram untuk bergerak di pepohonan.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 8 (Fase 8: Pembentukan Pegunungan Modern)
            [
                'era_id' => $era4,
                'question' => 'Pegunungan dunia yang terbentuk akibat tumbukan lempeng benua pada Masa Tersier adalah...',
                'option_a' => 'Gunung Krakatau dan Toba',
                'option_b' => 'Pegunungan Himalaya dan Alpen',
                'option_c' => 'Pegunungan Ural dan Appalachia',
                'option_d' => 'Pegunungan Fuji dan Merapi',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Tumbukan lempeng benua pada Masa Tersier membentuk jajaran pegunungan raksasa seperti Himalaya dan Alpen.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 9 (Fase 9: Pendinginan Global Awal)
            [
                'era_id' => $era4,
                'question' => 'Perubahan fenomena iklim apa yang menandai akhir dari Masa Tersier pada Fase 9?',
                'option_a' => 'Suhu bumi meningkat mendadak hingga lautan menguap',
                'option_b' => 'Suhu bumi perlahan menurun dan kutub mulai membentuk es permanen',
                'option_c' => 'Badai api vulkanik menutup seluruh permukaan bumi',
                'option_d' => 'Atmosfer bumi kehilangan gas karbon dioksida secara total',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Akhir Masa Tersier ditandai dengan pendinginan suhu global yang memicu terbentuknya lapisan es permanen di kutub.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 10 (Fase 10: Transisi Menuju Zaman Es)
            [
                'era_id' => $era4,
                'question' => 'Kala Geologi apakah yang bersiap memasuki bumi setelah berakhirnya Masa Tersier?',
                'option_a' => 'Zaman Kambrium & Silur',
                'option_b' => 'Masa Kuarter (Pleistosen & Holosen)',
                'option_c' => 'Zaman Trias & Jura',
                'option_d' => 'Masa Arkaikum',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Berakhirnya Masa Tersier membawa bumi ke dalam Masa Kuarter yang terdiri dari Kala Pleistosen (Zaman Es) dan Holosen.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // ERA 5
            // Pertanyaan 1 (Fase 1: Puncak Zaman Es)
            [
                'era_id' => $era5,
                'question' => 'Apa dampak utama dari gelombang glasial yang membekukan bumi pada awal Kala Pleistosen?',
                'option_a' => 'Permukaan air laut merosot tajam karena air terperangkap menjadi es',
                'option_b' => 'Seluruh permukaan bumi tertutup oleh lautan magma cair',
                'option_c' => 'Tumbuh-tumbuhan paku raksasa mendominasi seluruh Kutub Utara',
                'option_d' => 'Terjadinya peningkatan suhu bumi secara drastis',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Membekunya air menjadi glasial es menyebabkan permukaan air laut dunia surut dan merosot sangat tajam.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 2 (Fase 2: Adaptasi Megafauna Es)
            [
                'era_id' => $era5,
                'question' => 'Bentuk adaptasi fisik utama yang dikembangkan megafauna es (seperti Mammoth) untuk bertahan di suhu sub-nol adalah...',
                'option_a' => 'Mengembangkan sisik tebal mirip reptil',
                'option_b' => 'Memiliki bulu ganda yang sangat tebal',
                'option_c' => 'Memiliki sirip dan insang untuk berenang',
                'option_d' => 'Mengurangi ukuran tubuh menjadi seukuran tikus',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Hewan tundra beku seperti Mammoth dan Badak Berbulu mengandalkan lapisan bulu ganda yang tebal untuk menahan suhu es.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 3 (Fase 3: Jembatan Darat Nusantara)
            [
                'era_id' => $era5,
                'question' => 'Turunnya permukaan air laut di Nusantara membentuk jembatan darat Paparan Sunda yang menyatukan...',
                'option_a' => 'Pulau Papua dan Benua Australia',
                'option_b' => 'Jawa, Sumatra, dan Kalimantan dengan Benua Asia',
                'option_c' => 'Pulau Sulawesi dan Kepulauan Maluku',
                'option_d' => 'Pulau Bali dan Benua Antartika',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Surutnya air laut membentuk Paparan Sunda, daratan kering yang menghubungkan Jawa, Sumatra, dan Kalimantan langsung ke Asia.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 4 (Minigame / Fase 4: Lapisan Permafrost)
            [
                'era_id' => $era5,
                'question' => 'Lapisan tanah beku abadi tempat ditemukannya fosil gading raksasa Pleistosen disebut...',
                'option_a' => 'Sedimen Magma',
                'option_b' => 'Permafrost',
                'option_c' => 'Batuan Kapur',
                'option_d' => 'Endapan Karbon',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Permafrost adalah lapisan tanah/es yang membeku secara abadi tempat terperangkapnya fosil-fosil megafauna Zaman Es.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 5 (Fase 5: Temuan Gading Mammoth)
            [
                'era_id' => $era5,
                'question' => 'Fungsi utama gading melengkung raksasa milik Mammoth pada Kala Pleistosen adalah...',
                'option_a' => 'Untuk menyapu lapisan es saat mencari rumput makanan',
                'option_b' => 'Untuk membantu memanjat pohon tinggi',
                'option_c' => 'Sebagai alat untuk berenang di lautan dingin',
                'option_d' => 'Untuk menangkap ikan di dalam sungai beku',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Mammoth memanfaatkan gading melengkungnya sebagai alat pembersih salju/es yang menutupi rumput tundra.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 6 (Fase 6: Kemunculan Homo Erectus)
            [
                'era_id' => $era5,
                'question' => 'Keunggulan utama manusia purba Homo erectus yang ditemukan di wilayah Sangiran dan Trinil adalah...',
                'option_a' => 'Hominid pertama yang mampu berjalan tegak secara sempurna',
                'option_b' => 'Manusia purba yang sudah mengenal tulisan modern',
                'option_c' => 'Spesies yang sudah mampu membuat pesawat udara',
                'option_d' => 'Hominid yang hanya bisa hidup di atas pohon',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Homo erectus dikenal sebagai manusia purba perintis yang telah mampu berjalan tegak secara penuh (erect).',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 7 (Fase 7: Penguasaan Api & Peralatan)
            [
                'era_id' => $era5,
                'question' => 'Manfaat penting penguasaan api dan alat batu (kapak perimbas) bagi Homo erectus adalah...',
                'option_a' => 'Membangun gedung-gedung batu raksasa',
                'option_b' => 'Meningkatkan nutrisi otak melalui makanan matang dan menjaga kelangsungan hidup',
                'option_c' => 'Melelehkan seluruh es di Kutub Utara',
                'option_d' => 'Mengusir seluruh populasi Mammoth dari daratan',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Pengolahan makanan berkat api memudahkan pencernaan dan meningkatkan nutrisi yang mendukung perkembangan volume otak.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 8 (Fase 8: Berburu Megafauna)
            [
                'era_id' => $era5,
                'question' => 'Kunci utama keberhasilan kelompok manusia purba dalam berburu megafauna berukuran besar adalah...',
                'option_a' => 'Menggunakan jebakan laser dan besi',
                'option_b' => 'Kerja sama strategi kelompok menggunakan tombak batu',
                'option_c' => 'Menjinakkan hewan tersebut sebagai peliharaan',
                'option_d' => 'Berburu sendirian tanpa bantuan anggota lain',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Kerja sama dan komunikasi kelompok menjadi strategi utama manusia purba untuk menumbangkan hewan berukuran raksasa.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 9 (Fase 9: Kepunahan Megafauna Es)
            [
                'era_id' => $era5,
                'question' => 'Faktor iklim utama yang memicu kepunahan masal megafauna es di akhir Pleistosen adalah...',
                'option_a' => 'Suhu bumi yang semakin memanas sehingga menghilangkan habitat tundra',
                'option_b' => 'Gelombang es baru yang jauh lebih dingin',
                'option_c' => 'Hantaman meteorit raksasa Chicxulub kedua',
                'option_d' => 'Tenggelamnya seluruh daratan di bumi',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Pemanasan iklim global di akhir Pleistosen mencairkan es permafrost dan merusak rantai makanan megafauna es.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 10 (Fase 10: Fajar Manusia Modern)
            [
                'era_id' => $era5,
                'question' => 'Spesies manusia yang mulai menggantikan manusia purba terdahulu menjelang Kala Holosen adalah...',
                'option_a' => 'Homo erectus',
                'option_b' => 'Homo sapiens',
                'option_c' => 'Australopithecus',
                'option_d' => 'Meganthropus',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Homo sapiens (Manusia Modern) muncul dan mendominasi bumi menggantikan purba terdahulu menuju fajar peradaban.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // ERA 6
            // Pertanyaan 1 (Fase 1: Berakhirnya Zaman Es)
            [
                'era_id' => $era6,
                'question' => 'Dampak utama dari mencairnya gletser es dan naiknya air laut pada awal Kala Holosen bagi wilayah Indonesia adalah...',
                'option_a' => 'Tenggelamnya Paparan Sunda dan terbentuknya Kepulauan Nusantara',
                'option_b' => 'Menyatunya seluruh pulau di Indonesia menjadi satu daratan benua',
                'option_c' => 'Mengeringnya seluruh lautan di sekitar Pulau Jawa',
                'option_d' => 'Tertutupnya Kepulauan Indonesia oleh lapisan es tebal',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Mencairnya es gletser menaikkan permukaan air laut yang menenggelamkan daratan rendah Paparan Sunda dan membentuk Kepulauan Nusantara.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 2 (Fase 2: Iklim Stabil Holosen)
            [
                'era_id' => $era6,
                'question' => 'Keuntungan utama dari kondisi iklim Kala Holosen yang sangat stabil bagi manusia purba adalah...',
                'option_a' => 'Manusia harus terus-menerus berpindah tempat menghindari bencana es',
                'option_b' => 'Memudahkan manusia memprediksi musim dan membangun pemukiman tetap',
                'option_c' => 'Membuat seluruh tumbuh-tumbuhan mati karena kekeringan',
                'option_d' => 'Menyebabkan manusia kehilangan sumber air bersih',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Iklim Holosen yang ramah dan stabil memungkinkan manusia memprediksi pola musim untuk mulai menetap.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 3 (Fase 3: Revolusi Neolitikum)
            [
                'era_id' => $era6,
                'question' => 'Perubahan pola hidup paling krusial pada peristiwa Revolusi Neolitikum adalah...',
                'option_a' => 'Peralihan dari pola hidup berburu dan meramu ke bercocok tanam (pertanian)',
                'option_b' => 'Kembali ke pola hidup nomaden di dalam gua-gua gelap',
                'option_c' => 'Peralihan dari penggunaan besi kembali menggunakan batu kasar',
                'option_d' => 'Meninggalkan pemukiman desa untuk hidup di lautan',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Revolusi Neolitikum ditandai dengan perubahan mendasar cara hidup manusia dari berburu (food gathering) menjadi bercocok tanam (food producing).',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 4 (Minigame / Fase 4: Tanah Endapan Purba)
            [
                'era_id' => $era6,
                'question' => 'Artefak bersejarah apa yang ditemukan saat membersihkan lapisan tanah endapan purba pada misi ekskavasi?',
                'option_a' => 'Taring Smilodon',
                'option_b' => 'Prasasti batu pertama',
                'option_c' => 'Tengkorak T-Rex',
                'option_d' => 'Gading Mammoth',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Ekskavasi tanah endapan Holosen menyingkap ditemukannya prasasti batu sebagai artefak peradaban.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 5 (Fase 5: Temuan Prasasti Batu)
            [
                'era_id' => $era6,
                'question' => 'Arti penting dari ditemukannya prasasti batu bagi perkembangan peradaban manusia adalah...',
                'option_a' => 'Penanda berakhirnya kehidupan manusia di bumi',
                'option_b' => 'Penanda dimulainya era sejarah dan budaya tulis',
                'option_c' => 'Sebagai alat utama untuk berburu megafauna',
                'option_d' => 'Sebagai bahan dasar pembuatan senjata api',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Kemunculan tulisan pada prasasti menjadi pembatas berakhirnya zaman prasejarah menuju zaman sejarah.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 6 (Fase 6: Pengolahan Logam Awal)
            [
                'era_id' => $era6,
                'question' => 'Inovasi teknologi yang mempercepat kemajuan peralatan manusia pada Fase 6 adalah...',
                'option_a' => 'Penemuan teknik peleburan perunggu dan besi',
                'option_b' => 'Pembuatan alat dari tulang belulang ikan purba',
                'option_c' => 'Penggunaan batu pecah kasar secara terus menerus',
                'option_d' => 'Penemuan bahan plastik sintetis',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Kemampuan melebur perunggu dan besi membawa manusia masuk ke Zaman Logam dengan perkakas yang jauh lebih kuat.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 7 (Fase 7: Lahirnya Kerajaan Purba)
            [
                'era_id' => $era6,
                'question' => 'Perkembangan sosial yang terjadi saat desa-desa berkembang menjadi perkotaan dan kerajaan besar adalah...',
                'option_a' => 'Hilangnya sistem bahasa dan komunikasi',
                'option_b' => 'Terbentuknya sistem sosial, hukum, dan struktur pemerintahan',
                'option_c' => 'Kembalinya manusia ke pola berburu sendirian',
                'option_d' => 'Pemusnahan seluruh artefak dan prasasti',
                'correct_answer' => 'b',
                'score_points' => 10,
                'explanation' => 'Tumbuhnya pusat perkotaan dan kerajaan melahirkan tatanan hukum, struktur pemerintahan, dan kelas sosial.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 8 (Fase 8: Peradaban Berkelanjutan)
            [
                'era_id' => $era6,
                'question' => 'Pencapaian besar manusia dalam bidang arsitektur dan maritim pada Fase 8 ditandai oleh...',
                'option_a' => 'Pembangunan candi megah dan pelayaran antar-benua',
                'option_b' => 'Pembuatan rumah di atas pohon tinggi',
                'option_c' => 'Penggalian lubang bawah tanah di dasar lautan',
                'option_d' => 'Penghentian seluruh perdagangan antar wilayah',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Peradaban maju ditandai dengan mahakarya arsitektur (seperti candi) dan teknologi pelayaran jalur rempah/perdagangan.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 9 (Fase 9: Era Teknologi Modern)
            [
                'era_id' => $era6,
                'question' => 'Ciri utama dari Fase 9 yang mengubah secara total cara hidup manusia modern adalah...',
                'option_a' => 'Penguasaan informasi digital dan penjelajahan angkasa luar berkat sains',
                'option_b' => 'Ketergantungan penuh pada kapak batu',
                'option_c' => 'Kembali terisolasinya tiap suku bangsa di dunia',
                'option_d' => 'Mencairnya kembali seluruh daratan bumi',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Revolusi industri, sains, informasi digital, serta penjelajahan antariksa menjadi tonggak teknologi modern.',
                'created_at' => now(), 'updated_at' => now()
            ],

            // Pertanyaan 10 (Fase 10: Penjelajah Waktu Selesai)
            [
                'era_id' => $era6,
                'question' => 'Maksud dari tuntasnya seluruh rangkaian ekspedisi sejarah geologi bumi adalah...',
                'option_a' => 'Pemain telah mempelajari seluruh perjalanan panjang bumi dari Arkaikum hingga Holosen',
                'option_b' => 'Bumi telah hancur dan tidak dapat dihuni lagi',
                'option_c' => 'Seluruh fosil di bumi telah punah tanpa sisa',
                'option_d' => 'Ekspedisi harus diulang dari awal karena kegagalan data',
                'correct_answer' => 'a',
                'score_points' => 10,
                'explanation' => 'Penjelajahan waktu berhasil menelusuri seluruh garis waktu evolusi bumi dan kehidupan dari awal pembentukan hingga era modern.',
                'created_at' => now(), 'updated_at' => now()
            ],
        ]);
    }

    public function saveFossil(Request $request)
    {
        $request->validate([
            'era_id' => 'required|exists:eras,id',
        ]);

        $userId = Auth::id();
        $eraId = $request->era_id;

        // Simpan atau perbarui status fosil di tabel user_progress
        DB::table('user_progress')->updateOrInsert(
            [
                'user_id' => $userId,
                'era_id'  => $eraId,
            ],
            [
                'fossil_unlocked' => true,
                'updated_at'      => now(),
                'created_at'      => now(),
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Fosil berhasil dikoleksi ke dalam galeri!'
        ]);
    }
}