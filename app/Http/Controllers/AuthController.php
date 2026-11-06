<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    // Tampilkan Halaman Login Berdedikasi
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->isGuru() 
                ? redirect()->route('guru.dashboard') 
                : redirect()->route('home');
        }

        return view('auth.login');
    }

    // Tampilkan Halaman Register Berdedikasi
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return Auth::user()->isGuru() 
                ? redirect()->route('guru.dashboard') 
                : redirect()->route('home');
        }

        return view('auth.register');
    }
    // Cek status user aktif
    public function status()
    {
        if (Auth::check()) {
            return response()->json([
                'logged_in' => true,
                'user' => [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'role' => Auth::user()->role,
                    'avatar' => Auth::user()->avatar,
                    'score' => Auth::user()->score,
                    'completed_lessons' => Auth::user()->completed_lessons ?? [],
                    'is_guru' => Auth::user()->isGuru(),
                ]
            ]);
        }

        return response()->json([
            'logged_in' => false,
            'user' => null
        ]);
    }

    // Login Form / Ajax
    public function login(Request $request)
    {
        $loginInput = trim((string) $request->input('email'));
        $password = (string) $request->input('password');
        $remember = $request->boolean('remember', true);

        if (empty($loginInput) || empty($password)) {
            $msg = 'Email dan kata sandi wajib diisi.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->withInput()->withErrors(['email' => $msg]);
        }

        $email = strtolower($loginInput);
        
        // Coba login standar via email
        $attempt = Auth::attempt(['email' => $email, 'password' => $password], $remember);

        // Jika gagal, coba verifikasi apakah input merupakan NISN / No. Registrasi
        if (!$attempt) {
            $userByReg = User::where('reg_no', $loginInput)->first();
            if ($userByReg && Hash::check($password, $userByReg->password)) {
                Auth::login($userByReg, $remember);
                $attempt = true;
            }
        }

        if ($attempt) {
            if ($request->hasSession()) {
                $request->session()->regenerate();
            }
            $user = Auth::user();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Selamat datang kembali, ' . $user->name . '!',
                    'user' => $user,
                    'redirect' => $user->isGuru() ? route('guru.dashboard') : route('home')
                ]);
            }

            return $user->isGuru() 
                ? redirect()->route('guru.dashboard') 
                : redirect()->route('home')->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        $errMsg = 'Email/NISN atau kata sandi tidak sesuai. Silakan periksa kembali.';
        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $errMsg
            ], 422);
        }

        return back()->withInput()->withErrors([
            'email' => $errMsg,
        ]);
    }

    // Quick Demo Switch Account (Siswa <-> Guru)
    public function quickSwitch(Request $request)
    {
        $role = $request->input('role', 'guru');
        $targetEmail = $role === 'guru' ? 'guru@sijapanese.sch.id' : 'kenji@sijapanese.sch.id';
        
        $user = User::where('email', $targetEmail)->first();
        if (!$user) {
            $user = User::create([
                'name' => $role === 'guru' ? 'Sensei Tanaka' : 'Kenji Pratama (Siswa)',
                'email' => $targetEmail,
                'password' => Hash::make('password'),
                'role' => $role,
                'avatar' => $role === 'guru' ? 'img/avatar_tanaka.svg' : 'img/avatar_anggata.svg',
                'reg_no' => $role === 'guru' ? 'SIJ-2026-GURU01' : 'JFT-2026-51720',
                'class_room' => $role === 'guru' ? 'Master Pengajar' : 'Kelas X-A',
                'score' => $role === 'guru' ? 999 : 150,
                'completed_lessons' => $role === 'guru' ? [] : [1],
            ]);
        }

        Auth::login($user, true);
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }
        
        $redirectUrl = $user->isGuru() ? route('guru.dashboard') : route('home');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Masuk sebagai ' . $user->name . ' (' . ($user->isGuru() ? 'Guru' : 'Siswa') . ')',
                'user' => $user,
                'redirect' => $redirectUrl
            ]);
        }

        return redirect($redirectUrl)->with('success', 'Masuk sebagai akun demo: ' . $user->name);
    }

    // Helper untuk menangani upload foto profil atau avatar preset
    protected function handleAvatarUpload(Request $request, ?string $fallback = 'img/avatar_default.svg'): string
    {
        // 1. Cek unggahan file foto langsung (dari input type="file" avatar_file atau avatar)
        $file = $request->file('avatar_file') ?? ($request->hasFile('avatar') ? $request->file('avatar') : null);
        if ($file && $file->isValid()) {
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'svg'])) {
                $extension = 'jpg';
            }
            $filename = 'avatar_' . time() . '_' . Str::random(8) . '.' . $extension;
            $destinationPath = public_path('uploads/avatars');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            return 'uploads/avatars/' . $filename;
        }

        // 2. Cek jika avatar berupa Base64 Data URL (misal dari crop / preview FileReader JS)
        $avatarInput = $request->input('avatar');
        if (is_string($avatarInput) && preg_match('/^data:image\/(\w+);base64,/', $avatarInput, $matches)) {
            $imageType = strtolower($matches[1]);
            if (!in_array($imageType, ['jpeg', 'jpg', 'png', 'webp', 'svg+xml'])) {
                $imageType = 'png';
            }
            if ($imageType === 'jpeg') $imageType = 'jpg';
            if ($imageType === 'svg+xml') $imageType = 'svg';

            $data = substr($avatarInput, strpos($avatarInput, ',') + 1);
            $decoded = base64_decode($data);
            if ($decoded !== false) {
                $filename = 'avatar_' . time() . '_' . Str::random(8) . '.' . $imageType;
                $destinationPath = public_path('uploads/avatars');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                file_put_contents($destinationPath . '/' . $filename, $decoded);
                return 'uploads/avatars/' . $filename;
            }
        }

        // 3. Jika berupa string path yang valid (misal: img/avatar_default.svg atau uploads/...)
        if (!empty($avatarInput) && is_string($avatarInput) && !str_starts_with($avatarInput, 'data:')) {
            return trim($avatarInput);
        }

        return $fallback ?: 'img/avatar_default.svg';
    }

    // Register Akun Baru (Khusus Siswa Belajar)
    public function register(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'gender' => ['nullable', 'string', 'max:30'],
            'avatar' => ['nullable', 'string'],
            'avatar_file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'reg_no' => ['nullable', 'string', 'max:50'],
            'class_room' => ['nullable', 'string', 'max:50'],
        ];

        if ($request->filled('password_confirmation')) {
            $rules['password'][] = 'confirmed';
        }

        $validated = $request->validate($rules, [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email sudah terdaftar. Silakan gunakan email lain atau langsung masuk.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok. Silakan ulangi pengetikan kata sandi.',
            'avatar_file.max' => 'Ukuran file foto profil maksimal 3MB.',
        ]);

        // Pendaftaran mandiri dikhususkan 100% untuk Siswa Belajar
        User::ensureSchemaReady();
        $role = 'siswa';
        $avatarPath = $this->handleAvatarUpload($request, 'img/avatar_default.svg');

        $regNo = !empty($validated['reg_no']) 
            ? trim($validated['reg_no']) 
            : ('JFT-2026-' . rand(10000, 99999));

        $user = User::create([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role' => $role,
            'avatar' => $avatarPath,
            'reg_no' => $regNo,
            'class_room' => $validated['class_room'] ?? 'Siswa Umum',
            'gender' => !empty($validated['gender']) ? trim($validated['gender']) : 'Laki-laki (MALE)',
            'score' => 0,
            'completed_lessons' => [],
        ]);

        Auth::login($user, true);
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        $redirectUrl = route('home');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran akun Siswa berhasil!',
                'user' => $user,
                'redirect' => $redirectUrl
            ]);
        }

        return redirect($redirectUrl)->with('success', 'Akun Siswa ' . $user->name . ' berhasil dibuat. Selamat belajar!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'redirect' => route('home')]);
        }

        return redirect()->route('home')->with('info', 'Kamu telah keluar dari akun.');
    }

    // Update Profil
    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'string', 'max:255'],
            'avatar_file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'gender' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $user->name = $validated['name'];
        if (!empty($validated['email'])) {
            $user->email = strtolower(trim($validated['email']));
        }
        if (!empty($validated['gender'])) {
            $user->gender = trim($validated['gender']);
        }
        if ($request->hasFile('avatar_file') || $request->hasFile('avatar') || !empty($validated['avatar'])) {
            $user->avatar = $this->handleAvatarUpload($request, $user->avatar ?: 'img/avatar_default.svg');
        }
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui!',
                'user' => $user
            ]);
        }

        return back()->with('success', 'Profil Guru berhasil diperbarui!')->with('profile_updated', true);
    }

    // Tambah Poin Siswa (dari Kuis Quest / Mini Games)
    public function addScore(Request $request)
    {
        $points = (int) $request->input('points', 0);
        $lessonId = $request->input('lesson_id');

        if (Auth::check() && $points > 0) {
            $user = Auth::user();
            $user->score += $points;

            if ($lessonId) {
                $completed = $user->completed_lessons ?? [];
                if (!in_array($lessonId, $completed)) {
                    $completed[] = (int) $lessonId;
                    $user->completed_lessons = $completed;
                }
            }

            $user->save();

            return response()->json([
                'success' => true,
                'new_score' => $user->score,
                'added' => $points,
                'completed_lessons' => $user->completed_lessons,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User belum login'
        ]);
    }

    // Rekam Penilaian & Hasil Pengerjaan Latihan Siswa (Benar, Salah, Skor & Grade)
    public function submitAssessment(Request $request)
    {
        StudentAssessment::ensureTableExists();

        $user = Auth::user();
        if (!$user) {
            $userId = $request->input('user_id');
            if ($userId) {
                $user = User::find($userId);
            }
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa harus login untuk menyimpan hasil penilaian latihan.'
            ], 401);
        }

        $lessonId = $request->input('lesson_id');
        $exerciseTitle = $request->input('exercise_title', 'Latihan Modul');
        $exerciseType = $request->input('exercise_type', 'quest');
        $totalQuestions = (int) $request->input('total_questions', 1);
        $correctCount = (int) $request->input('correct_count', 0);
        $wrongCount = (int) $request->input('wrong_count', 0);
        
        if ($request->has('score')) {
            $score = (int) $request->input('score');
        } else {
            $score = $totalQuestions > 0 ? (int) round(($correctCount / $totalQuestions) * 100) : 0;
        }

        $gradeInfo = StudentAssessment::calculateGradeAndStatus($score);
        $details = $request->input('details');

        $assessment = StudentAssessment::create([
            'user_id' => $user->id,
            'lesson_id' => $lessonId ? (int)$lessonId : null,
            'exercise_title' => $exerciseTitle,
            'exercise_type' => $exerciseType,
            'total_questions' => $totalQuestions,
            'correct_count' => $correctCount,
            'wrong_count' => $wrongCount,
            'score' => $score,
            'grade' => $gradeInfo['grade'],
            'status' => $gradeInfo['status'],
            'details' => $details,
        ]);

        // Tambah XP gamifikasi jika ada
        $points = (int) $request->input('points', 50);
        if ($points > 0) {
            $user->score += $points;
        }

        if ($lessonId) {
            $completed = $user->completed_lessons ?? [];
            if (!in_array((int)$lessonId, $completed)) {
                $completed[] = (int)$lessonId;
                $user->completed_lessons = $completed;
            }
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Hasil penilaian latihan berhasil dicatat ke Master Guru!',
            'assessment' => $assessment,
            'new_score' => $user->score,
            'completed_lessons' => $user->completed_lessons,
        ]);
    }
}
