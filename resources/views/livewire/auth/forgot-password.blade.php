<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <!-- Icon & Header -->
        <div class="flex flex-col items-center text-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            <x-auth-header :title="__('Lupa Kata Sandi?')" :description="__('Tidak masalah. Masukkan email Anda dan kami akan mengirimkan link reset password.')" />
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="rounded-lg bg-green-50 dark:bg-green-900/20 p-4 border border-green-200 dark:border-green-800">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-green-700 dark:text-green-300">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <div>
                <flux:input
                    name="email"
                    :label="__('Email Address')"
                    type="email"
                    required
                    autofocus
                    placeholder="email@example.com"
                />
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Link reset password akan dikirim ke email ini
                </p>
            </div>

            <flux:button variant="primary" type="submit" class="w-full" data-test="email-password-reset-link-button">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                {{ __('Kirim Link Reset Password') }}
            </flux:button>
        </form>

        <!-- Info Box -->
        <div class="rounded-lg bg-blue-50 dark:bg-blue-900/20 p-4 border border-blue-200 dark:border-blue-800">
            <div class="flex gap-3">
                <svg class="h-5 w-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-blue-700 dark:text-blue-300">
                    <p class="font-semibold mb-1">Tips Keamanan:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs">
                        <li>Periksa folder spam jika email tidak masuk</li>
                        <li>Link reset berlaku selama 60 menit</li>
                        <li>Jangan bagikan link reset ke siapapun</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Sudah ingat password Anda?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Kembali ke login') }}</flux:link>
        </div>
    </div>
</x-layouts.auth>
