@extends('layouts.auth')

@section('title', 'PortApps - Masuk')

@section('hero-description')
    Masuk untuk mengakses dashboard admin dan mengelola kegiatan bongkar muat kapal.
@endsection

@section('content')
<!-- Form Content -->
<div class="flex-1 flex flex-col justify-center max-w-md mx-auto w-full animate-fade-in">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-1.5 mb-1">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight inline-block">
                Selamat Datang
            </h1>
            <img src="{{ asset('assets/image/maskod.png') }}" alt="Maskot" class="w-20 h-20 object-contain flex-shrink-0">
        </div>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
            Masukkan email dan kata sandi Anda untuk mengakses akun.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
            {{ session('status') }}
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                Email
            </label>
            <input 
                type="email" 
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email"
                required
                autofocus
                autocomplete="username"
                class="w-full px-4 py-3.5 text-gray-900 bg-white border border-gray-300 rounded-xl transition-all duration-200 placeholder:text-gray-400 hover:border-gray-400 @error('email') border-red-500 @enderror"
            />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                Kata Sandi
            </label>
            <div class="relative">
                <input 
                    type="password" 
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                    class="w-full px-4 py-3.5 text-gray-900 bg-white border border-gray-300 rounded-xl transition-all duration-200 pr-12 placeholder:text-gray-400 hover:border-gray-400 @error('password') border-red-500 @enderror"
                />
                <button 
                    type="button" 
                    onclick="togglePassword()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none"
                    aria-label="Toggle password visibility"
                >
                    <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-1">
            <label class="flex items-center cursor-pointer group">
                <div class="relative">
                    <input 
                        type="checkbox" 
                        id="remember"
                        name="remember"
                        {{ old('remember') ? 'checked' : '' }}
                        class="peer w-5 h-5 border-2 border-gray-300 rounded cursor-pointer transition-all duration-200 appearance-none hover:border-gray-400 bg-white"
                    >
                    <div class="absolute top-0.5 left-0.5 w-4 h-4 flex items-center justify-center pointer-events-none hidden peer-checked:flex rounded-sm" style="background-color: #23237E;">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                <span class="ml-3 text-sm text-gray-700 select-none group-hover:text-gray-900 transition-colors">
                    Remember Me
                </span>
            </label>
            @if (Route::has('password.request'))
                <a 
                    href="{{ route('password.request') }}" 
                    data-navigate
                    class="text-sm font-semibold transition-colors"
                    style="color: #23237E;"
                    onmouseover="this.style.opacity='0.8'"
                    onmouseout="this.style.opacity='1'"
                >
                    Lupa Kata Sandi?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <button 
            type="submit"
            class="w-full text-white py-4 rounded-xl font-semibold text-base transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 mt-6"
            style="background-color: #23237E; box-shadow: 0 10px 15px -3px rgba(35, 35, 126, 0.2);"
            onmouseover="this.style.opacity='0.9'; this.style.boxShadow='0 20px 25px -5px rgba(35, 35, 126, 0.3)'"
            onmouseout="this.style.opacity='1'; this.style.boxShadow='0 10px 15px -3px rgba(35, 35, 126, 0.2)'"
        >
            Masuk
        </button>
    </form>

    <!-- Divider -->
    <div class="my-8">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500 font-medium">Or Log In With</span>
            </div>
        </div>
    </div>

    <!-- Social Login Buttons -->
    <div class="grid grid-cols-2 gap-3 sm:gap-4">
        <button 
            type="button"
            id="googleSignInBtn"
            data-callback-url="{{ route('auth.google.callback') }}"
            data-csrf-token="{{ csrf_token() }}"
            class="flex items-center justify-center gap-3 px-4 py-3.5 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 active:bg-gray-100 transition-all duration-200 group"
        >
            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <span class="text-sm font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">
                Google
            </span>
        </button>
        <button 
            type="button"
            class="flex items-center justify-center gap-3 px-4 py-3.5 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 active:bg-gray-100 transition-all duration-200 group opacity-50 cursor-not-allowed"
            disabled
            title="SSO akan segera tersedia"
        >
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
            <span class="text-sm font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">
                SSO
            </span>
        </button>
    </div>

    <!-- Sign Up Link -->
    @if (Route::has('register'))
        <div class="text-center mt-8">
            <p class="text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" data-navigate class="font-semibold transition-colors ml-1" style="color: #23237E;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<!-- Firebase SDK -->
<script type="module">
    import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js';
    import { getAuth, signInWithPopup, GoogleAuthProvider } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js';

    console.log('🔥 Firebase SDK loaded successfully');

    // Firebase Configuration
    const firebaseConfig = {
        apiKey: "{{ config('services.firebase.api_key') }}",
        authDomain: "{{ config('services.firebase.auth_domain') }}",
        projectId: "{{ config('services.firebase.project_id') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') }}",
        messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
        appId: "{{ config('services.firebase.app_id') }}",
        measurementId: "{{ config('services.firebase.measurement_id') }}"
    };

    console.log('🔥 Firebase Config:', firebaseConfig);

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const provider = new GoogleAuthProvider();
    
    console.log('✅ Firebase initialized, auth domain:', firebaseConfig.authDomain);

    // Attach event listener immediately
    const googleBtn = document.getElementById('googleSignInBtn');
    if (googleBtn) {
        googleBtn.addEventListener('click', async function() {
            const button = this;
            const buttonText = button.querySelector('span');
            const originalText = buttonText.textContent;

            try {
                console.log('Google Sign In clicked...');
                
                // Show loading state
                button.disabled = true;
                buttonText.textContent = 'Memproses...';

                // Sign in with Google popup
                console.log('Opening Firebase popup...');
                const result = await signInWithPopup(auth, provider);
                const user = result.user;
                
                console.log('Firebase auth successful:', user.email);

                // Get ID token
                const idToken = await user.getIdToken();

                // Send to backend
                console.log('Sending to backend...');
                const response = await fetch(button.dataset.callbackUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': button.dataset.csrfToken
                    },
                    body: JSON.stringify({
                        token: idToken,
                        email: user.email,
                        name: user.displayName,
                        google_id: user.uid,
                        avatar: user.photoURL
                    })
                });

                const data = await response.json();
                console.log('Backend response:', data);

                if (data.success) {
                    buttonText.textContent = 'Berhasil! Mengalihkan...';
                    window.location.href = data.redirect;
                } else {
                    throw new Error(data.message || 'Login gagal');
                }
            } catch (error) {
                console.error('❌ Google Sign In Error:', error);
                console.error('Error code:', error.code);
                console.error('Error message:', error.message);
                
                let errorMessage = 'Login dengan Google gagal: ';
                
                if (error.code === 'auth/unauthorized-domain') {
                    errorMessage += 'Domain tidak ter-autorisasi. Coba:\n' +
                                  '1. Hard refresh browser (Ctrl+Shift+R)\n' +
                                  '2. Clear browser cache\n' +
                                  '3. Tunggu 2-3 menit dan coba lagi\n' +
                                  '4. Pastikan localhost sudah ditambahkan di Firebase Console';
                } else if (error.code === 'auth/popup-blocked') {
                    errorMessage += 'Popup diblokir oleh browser. Klik icon di address bar untuk allow popups.';
                } else if (error.code === 'auth/popup-closed-by-user') {
                    errorMessage += 'Popup ditutup sebelum selesai. Silakan coba lagi.';
                } else {
                    errorMessage += error.message || 'Terjadi kesalahan';
                }
                
                alert(errorMessage);
                button.disabled = false;
                buttonText.textContent = originalText;
            }
        });
        console.log('Google Sign In button listener attached');
    } else {
        console.error('Google Sign In button not found!');
    }
</script>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }
    }
</script>
@endpush
