@extends('layouts.auth')

@section('title', 'PortApps - Lupa Kata Sandi')

@section('hero-description')
    Pemulihan kata sandi yang aman untuk kembali mengelola operasional pelabuhan Anda.
@endsection

@section('content')
<!-- Form Content -->
<div class="flex-1 flex flex-col justify-center max-w-md mx-auto w-full animate-fade-in">
    <!-- Header -->
    <div class="mb-8">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5" style="background-color: rgba(35, 35, 126, 0.1);">
            <svg class="w-7 h-7" style="color: #23237E;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
        </div>
        <div class="flex items-center gap-1.5 mb-1 flex-nowrap">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight inline-block whitespace-nowrap">
                Lupa Kata Sandi?
            </h1>
            <img src="{{ asset('assets/image/maskod2.png') }}" alt="Maskot" class="w-20 h-20 object-contain flex-shrink-0">
        </div>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
            Tidak masalah. Beri tahu kami alamat email Anda dan kami akan mengirimkan tautan reset kata sandi.
        </p>
    </div>    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
            {{ session('status') }}
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                Alamat Email
            </label>
            <input 
                type="email" 
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email Anda"
                required
                autofocus
                class="w-full px-4 py-3.5 text-gray-900 bg-white border border-gray-300 rounded-xl transition-all duration-200 placeholder:text-gray-400 hover:border-gray-400 @error('email') border-red-500 @enderror"
            />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Reset Password Button -->
        <button 
            type="submit"
            class="w-full text-white py-4 rounded-xl font-semibold text-base transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 mt-6"
            style="background-color: #23237E; box-shadow: 0 10px 15px -3px rgba(35, 35, 126, 0.2);"
            onmouseover="this.style.opacity='0.9'; this.style.boxShadow='0 20px 25px -5px rgba(35, 35, 126, 0.3)'"
            onmouseout="this.style.opacity='1'; this.style.boxShadow='0 10px 15px -3px rgba(35, 35, 126, 0.2)'"
        >
            Kirim Tautan Reset Kata Sandi
        </button>
    </form>

    <!-- Back to Login Link -->
    <div class="text-center mt-8">
        <a href="{{ route('login') }}" data-navigate class="inline-flex items-center gap-2 text-sm font-semibold transition-colors group" style="color: #23237E;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Halaman Masuk
        </a>
    </div>

    <!-- Additional Help -->
    <div class="mt-12 p-5 bg-gray-50 rounded-2xl border border-gray-200">
        <div class="flex gap-3">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 mt-0.5" style="color: #23237E;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-1">
                    Butuh bantuan?
                </h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Jika Anda tidak menerima email dalam beberapa menit, periksa folder spam atau 
                    <a href="#" class="font-semibold" style="color: #23237E;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">hubungi dukungan</a>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
