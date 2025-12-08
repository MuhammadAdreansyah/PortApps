@extends('layouts.auth')

@section('title', 'Home - PortApps')

@section('content')

@if(session('google_login_success'))
    @php
        notify()->success('Login dengan Google berhasil! Selamat datang ' . session('user_name'), 'Berhasil');
    @endphp
@endif

<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <!-- Card Identitas User -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header dengan Gradient -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-8 text-center">
                @if(Auth::user()->avatar)
                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" 
                         class="w-24 h-24 rounded-full mx-auto border-4 border-white shadow-lg mb-4">
                @else
                    <div class="w-24 h-24 rounded-full mx-auto border-4 border-white shadow-lg bg-white flex items-center justify-center mb-4">
                        <span class="text-3xl font-bold text-blue-600">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                @endif
                <h1 class="text-3xl font-bold text-white">{{ Auth::user()->name }}</h1>
                <p class="text-blue-100 mt-2">{{ Auth::user()->email }}</p>
            </div>

            <!-- Body dengan Informasi -->
            <div class="p-8">
                <div class="space-y-4">
                    <!-- User ID -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600 font-medium">User ID</span>
                        <span class="text-gray-900 font-semibold">{{ Auth::user()->id }}</span>
                    </div>

                    <!-- Email Status -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600 font-medium">Status Email</span>
                        @if(Auth::user()->email_verified_at)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                ✓ Terverifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                ⚠ Belum Terverifikasi
                            </span>
                        @endif
                    </div>

                    <!-- Login Method -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600 font-medium">Metode Login</span>
                        @if(Auth::user()->google_id)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                <span class="text-gray-900 font-semibold">Google</span>
                            </div>
                        @else
                            <span class="text-gray-900 font-semibold">Email & Password</span>
                        @endif
                    </div>

                    <!-- Member Since -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-600 font-medium">Bergabung Sejak</span>
                        <span class="text-gray-900 font-semibold">{{ Auth::user()->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex gap-3">
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="text-center mt-6 text-gray-600">
            <p class="text-sm">PortApps - Government Application System</p>
        </div>
    </div>
</div>
@endsection
