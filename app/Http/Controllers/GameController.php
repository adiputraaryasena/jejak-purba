<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GameController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('game.home');
        }
        return view('frame1_auth');
    }

    public function home()
    {
        $user = Auth::user();
        
        $completedCount = DB::table('user_progress')
            ->where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();

        // Hitung total skor tertinggi dari kuis tiap era
        $totalScore = DB::table('user_progress')
            ->where('user_id', $user->id)
            ->sum('quiz_score');

        // Hitung fosil yang berhasil di-unlock
        $fossilsUnlocked = DB::table('user_progress')
            ->where('user_id', $user->id)
            ->where('fossil_unlocked', true)
            ->count();

        // Hitung total era secara dinamis (bernilai 6 / 7 era)
        $totalEras = DB::table('eras')->count();

        return view('frame2_home', [
            'userName' => $user->name,
            'totalScore' => $totalScore,
            'completedCount' => $completedCount,
            'fossilsUnlocked' => $fossilsUnlocked,
            'totalEras' => $totalEras
        ]);
    }

    public function timeline()
    {
        $user = Auth::user();
        $eras = DB::table('eras')->orderBy('order_level', 'asc')->get();

        // Cek status unlock per era berdasarkan skor kuis era sebelumnya
        $timelineData = $eras->map(function ($era) use ($user) {
            if ($era->order_level == 1) {
                $unlocked = true;
            } else {
                $prevEra = DB::table('eras')->where('order_level', $era->order_level - 1)->first();
                $prevProgress = DB::table('user_progress')
                    ->where('user_id', $user->id)
                    ->where('era_id', $prevEra->id ?? null)
                    ->first();

                $unlocked = $prevProgress && ($prevProgress->quiz_score >= $era->min_score_unlock);
            }

            return [
                'era' => $era,
                'is_unlocked' => $unlocked
            ];
        });

        return view('frame3_timeline', compact('timelineData'));
    }

    public function eraDetail($slug)
    {
        $era = DB::table('eras')->where('slug', $slug)->first();
        return view('frame4_era_detail', compact('era'));
    }

    public function saveFossil(Request $request)
    {
        $request->validate([
            'era_id' => 'required|exists:eras,id',
        ]);

        $userId = Auth::id();
        $eraId = $request->era_id;

        DB::table('user_progress')->updateOrInsert(
            [
                'user_id' => $userId,
                'era_id'  => $eraId,
            ],
            [
                'fossil_unlocked' => true,
                'updated_at'      => now(),
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Fosil berhasil dikoleksi!'
        ]);
    }

    public function quizList()
    {
        $user = Auth::user();
        $eras = DB::table('eras')->orderBy('order_level', 'asc')->get();

        $quizEras = $eras->map(function ($era) use ($user) {
            if ($era->order_level == 1) {
                $unlocked = true;
            } else {
                $prevEra = DB::table('eras')->where('order_level', $era->order_level - 1)->first();
                $prevProgress = DB::table('user_progress')
                    ->where('user_id', $user->id)
                    ->where('era_id', $prevEra->id ?? null)
                    ->first();

                $unlocked = $prevProgress && ($prevProgress->quiz_score >= $era->min_score_unlock);
            }

            return [
                'era' => $era,
                'is_unlocked' => $unlocked
            ];
        });

        return view('frame5_quiz_list', compact('quizEras'));
    }

    public function quiz($slug)
    {
        $era = DB::table('eras')->where('slug', $slug)->first();
        
        // Mengambil seluruh data soal kuis tanpa pembatasan limit
        $quizzes = DB::table('quizzes')->where('era_id', $era->id)->get();

        // Diubah ke 'frame5_quiz' agar sesuai dengan nama file blade kamu
        return view('frame5_quiz', compact('era', 'quizzes'));
    }

    public function pencapaian()
    {
        $user = Auth::user();

        // Menggunakan leftJoin agar seluruh era (termasuk yang belum di-unlock) terambil
        $progressList = DB::table('eras')
            ->leftJoin('user_progress', function ($join) use ($user) {
                $join->on('eras.id', '=', 'user_progress.era_id')
                     ->where('user_progress.user_id', '=', $user->id);
            })
            ->select(
                'eras.id as era_id',
                'eras.slug as era_slug',
                'eras.name as era_name',
                'eras.fossil_name',
                'user_progress.fossil_unlocked',
                'user_progress.quiz_score',
                'user_progress.badge_unlocked'
            )
            ->orderBy('eras.order_level', 'asc')
            ->get();

        // Hitung total badge yang terkumpul
        $totalBadgesUnlocked = $progressList->whereNotNull('badge_unlocked')->count();

        return view('frame6_pencapaian', compact('progressList', 'user', 'totalBadgesUnlocked'));
    }

    public function submitQuiz(Request $request, $slug)
    {
        $user = Auth::user();
        $era = DB::table('eras')->where('slug', $slug)->first();
        $quizzes = DB::table('quizzes')->where('era_id', $era->id)->get();

        $userAnswers = $request->input('answers', []);
        $correctAnswersCount = 0;
        $totalQuestions = $quizzes->count();

        // Hitung berapa jawaban user yang benar
        foreach ($quizzes as $quiz) {
            if (isset($userAnswers[$quiz->id]) && $userAnswers[$quiz->id] === $quiz->correct_answer) {
                $correctAnswersCount++;
            }
        }

        // Kalkulasi skor berbasis persentase (Maksimal 100 PTS)
        $totalScore = $totalQuestions > 0 ? round(($correctAnswersCount / $totalQuestions) * 100) : 0;

        // Ambil data progres era ini jika sudah ada sebelumnya
        $existingProgress = DB::table('user_progress')
            ->where('user_id', $user->id)
            ->where('era_id', $era->id)
            ->first();

        $oldScore = $existingProgress->quiz_score ?? 0;
        $highestScore = max($oldScore, $totalScore);

        // DAFTAR NAMA BADGE SPESIFIK & TEMATIK BERDASARKAN SLUG ERA
        $badgeNames = [
            'arkaikum'          => 'Pionir Api Purba 🌋',
            'paleozoikum'       => 'Penjelajah Samudra Purba 🌊',
            'mesozoikum'        => 'Raja Dinosaurus REX 🦖',
            'neozoikum-tersier' => 'Pemburu Mamut Raksasa 🦣',
            'pleistosen'        => 'Penyelamat Zaman Es ❄️',
            'holosen'           => 'Master Peradaban Purba 🏛️',
        ];

        // Tentukan badge yang didapatkan jika skor minimal 70
        $badgeTitle = $badgeNames[$era->slug] ?? ('Pakar ' . $era->name . ' 🏆');
        $badgeUnlocked = $highestScore >= 70 ? $badgeTitle : ($existingProgress->badge_unlocked ?? null);

        DB::table('user_progress')->updateOrInsert(
            ['user_id' => $user->id, 'era_id' => $era->id],
            [
                'is_unlocked'    => true,
                'is_completed'   => true,
                'quiz_score'     => $highestScore,
                'badge_unlocked' => $badgeUnlocked,
                'updated_at'     => now(),
            ]
        );

        // Update total_score di tabel users berdasarkan selisih peningkatan skor
        if ($highestScore > $oldScore) {
            $scoreDifference = $highestScore - $oldScore;
            DB::table('users')->where('id', $user->id)->increment('total_score', $scoreDifference);
        }

        return response()->json([
            'status'        => 'success',
            'score'         => $totalScore,
            'highest_score' => $highestScore,
            'is_passed'     => $highestScore >= 70,
            'badge'         => $badgeUnlocked
        ]);
    }

    public function syncAccount(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required|min:6',
        ]);

        DB::table('users')->where('id', $user->id)->update([
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'is_guest'   => false,
            'updated_at' => now(),
        ]);

        return redirect()->route('game.home')->with('success', 'Akun berhasil ditautkan! Progres kamu aman selamanya.');
    }
}