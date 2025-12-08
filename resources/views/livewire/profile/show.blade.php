<?php

use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state, computed};

$user = computed(fn () => Auth::user());

?>

<x-layouts.app>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-lg overflow-hidden">
            <!-- Header dengan Avatar -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-8 text-center">
                @if($this->user->avatar)
                    <img src="{{ $this->user->avatar }}" alt="{{ $this->user->name }}" 
                         class="w-32 h-32 rounded-full mx-auto border-4 border-white shadow-lg">
                @else
                    <div class="w-32 h-32 rounded-full mx-auto border-4 border-white shadow-lg bg-gray-300 flex items-center justify-center">
                        <span class="text-4xl text-gray-600 font-bold">{{ strtoupper(substr($this->user->name, 0, 1)) }}</span>
                    </div>
                @endif
                <h1 class="text-3xl font-bold text-white mt-4">{{ $this->user->name }}</h1>
                <p class="text-blue-100 mt-2">{{ $this->user->email }}</p>
            </div>

            <!-- Informasi Detail -->
            <div class="p-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Informasi Profil</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div class="bg-gray-50 dark:bg-zinc-700 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">Nama Lengkap</span>
                        </div>
                        <p class="text-lg text-gray-900 dark:text-white">{{ $this->user->name }}</p>
                    </div>

                    <!-- Email -->
                    <div class="bg-gray-50 dark:bg-zinc-700 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">Email</span>
                        </div>
                        <p class="text-lg text-gray-900 dark:text-white break-all">{{ $this->user->email }}</p>
                    </div>

                    <!-- Google ID -->
                    @if($this->user->google_id)
                    <div class="bg-gray-50 dark:bg-zinc-700 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">Google ID</span>
                        </div>
                        <p class="text-lg text-gray-900 dark:text-white break-all">{{ $this->user->google_id }}</p>
                    </div>
                    @endif

                    <!-- Status Verifikasi Email -->
                    <div class="bg-gray-50 dark:bg-zinc-700 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">Status Email</span>
                        </div>
                        @if($this->user->email_verified_at)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                ✓ Terverifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                ⚠ Belum Terverifikasi
                            </span>
                        @endif
                    </div>

                    <!-- Tanggal Bergabung -->
                    <div class="bg-gray-50 dark:bg-zinc-700 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">Bergabung Sejak</span>
                        </div>
                        <p class="text-lg text-gray-900 dark:text-white">{{ $this->user->created_at->format('d M Y') }}</p>
                    </div>

                    <!-- User ID -->
                    <div class="bg-gray-50 dark:bg-zinc-700 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">User ID</span>
                        </div>
                        <p class="text-lg text-gray-900 dark:text-white">{{ $this->user->id }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex gap-4">
                    <flux:button wire:navigate href="{{ route('dashboard') }}" variant="primary">
                        Kembali ke Dashboard
                    </flux:button>
                    <flux:button wire:navigate href="{{ route('profile.edit') }}" variant="outline">
                        Edit Profil
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
