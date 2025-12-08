<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Name')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <!-- Divider -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white dark:bg-zinc-900 text-gray-500">Atau daftar dengan</span>
            </div>
        </div>

        <!-- Google Sign In Button -->
        <button id="googleSignUpBtn" 
                type="button"
                data-callback-url="{{ route('auth.google.callback') }}"
                data-csrf-token="{{ csrf_token() }}"
                class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors duration-200">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <span>Daftar dengan Google</span>
        </button>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>

    @push('scripts')
    <script type="module">
        // Import Firebase modules
        import { initializeApp } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-app.js";
        import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-auth.js";

        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyCt4ytU_ebmj2ia-Pb6i8FFChk_0YQHl2o",
            authDomain: "portapps-2bd5c.firebaseapp.com",
            projectId: "portapps-2bd5c",
            storageBucket: "portapps-2bd5c.firebasestorage.app",
            messagingSenderId: "301903764008",
            appId: "1:301903764008:web:6e5f8c268290ec3439731d",
            measurementId: "G-ZMKGK92FJF"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();

        // Handle Google Sign Up
        const googleSignUpBtn = document.getElementById('googleSignUpBtn');
        
        if (googleSignUpBtn) {
            googleSignUpBtn.addEventListener('click', async function() {
                try {
                    // Show loading state
                    googleSignUpBtn.disabled = true;
                    googleSignUpBtn.innerHTML = '<span>Memproses...</span>';
                    
                    const result = await signInWithPopup(auth, provider);
                    const user = result.user;

                    // Validate user data
                    if (!user.email || !user.uid) {
                        throw new Error('Data user tidak lengkap');
                    }

                    // Get callback URL and CSRF token from button data attributes
                    const callbackUrl = googleSignUpBtn.getAttribute('data-callback-url');
                    const csrfToken = googleSignUpBtn.getAttribute('data-csrf-token') || 
                                    document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    
                    if (!callbackUrl || !csrfToken) {
                        throw new Error('Konfigurasi tidak lengkap');
                    }

                    // Send user data to Laravel backend
                    const response = await fetch(callbackUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            email: user.email,
                            name: user.displayName || user.email,
                            google_id: user.uid,
                            avatar: user.photoURL || null
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Gagal menghubungi server. Status: ' + response.status);
                    }

                    const data = await response.json();

                    if (data.success && data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        throw new Error(data.message || 'Pendaftaran gagal');
                    }
                } catch (error) {
                    console.error('Error during sign up:', error);
                    
                    // Reset button state
                    googleSignUpBtn.disabled = false;
                    googleSignUpBtn.innerHTML = '<svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg><span>Daftar dengan Google</span>';
                    
                    // Show error message
                    let errorMsg = 'Gagal mendaftar dengan Google. ';
                    if (error.code === 'auth/popup-closed-by-user') {
                        errorMsg += 'Popup ditutup sebelum pendaftaran selesai.';
                    } else if (error.code === 'auth/cancelled-popup-request') {
                        errorMsg += 'Request dibatalkan.';
                    } else {
                        errorMsg += 'Silakan coba lagi.';
                    }
                    alert(errorMsg);
                }
            });
        }
    </script>
    @endpush
</x-layouts.auth>
