<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class GoogleAuthController extends Controller
{
    /**
     * Handle Google authentication callback from Firebase
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function handleGoogleCallback(Request $request): JsonResponse
    {
        try {
            // Validasi input dengan rules yang ketat
            $validated = $request->validate([
                'email' => 'required|email|max:255',
                'name' => 'required|string|max:255',
                'google_id' => 'required|string|max:255',
                'avatar' => 'nullable|url|max:500',
            ]);

            // Gunakan database transaction untuk keamanan data
            DB::beginTransaction();

            try {
                // Cari user berdasarkan Google ID terlebih dahulu (lebih spesifik)
                $user = User::where('google_id', $validated['google_id'])->first();

                // Jika tidak ditemukan, cari berdasarkan email
                if (!$user) {
                    $user = User::where('email', $validated['email'])->first();
                }

                if ($user) {
                    // Update informasi user yang sudah ada
                    $user->update([
                        'google_id' => $validated['google_id'],
                        'avatar' => $validated['avatar'] ?? $user->avatar,
                        'name' => $validated['name'],
                        'email_verified_at' => $user->email_verified_at ?? now(),
                    ]);

                    Log::info('User updated via Google login', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                    ]);
                } else {
                    // Buat user baru dengan keamanan maksimal
                    $user = User::create([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'google_id' => $validated['google_id'],
                        'avatar' => $validated['avatar'] ?? null,
                        'password' => bcrypt(Str::random(32)), // Password random 32 karakter
                        'email_verified_at' => now(), // Auto verify untuk user Google
                    ]);

                    Log::info('New user created via Google login', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                    ]);
                }

                DB::commit();

                // Login user dengan remember token
                Auth::login($user, true);
                
                // Set session untuk notification di halaman home
                session()->flash('google_login_success', true);
                session()->flash('user_name', $user->name);

                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'redirect' => route('user.home'),
                ], 200);

            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (ValidationException $e) {
            Log::warning('Google login validation failed', [
                'errors' => $e->errors(),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors(),
            ], 422);

        } catch (Exception $e) {
            Log::error('Google login failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses login. Silakan coba lagi.',
            ], 500);
        }
    }
}
