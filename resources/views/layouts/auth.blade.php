<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PortApps - Authentication')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        html {
            scroll-behavior: smooth;
            overflow-y: scroll;
        }
        
        body {
            overflow-x: hidden;
        }
        
        /* Page Transition Animations */
        .page-container {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }
        
        .page-content {
            min-height: 100vh;
            display: flex;
        }
        
        /* Transisi hanya untuk form column */
        #formColumn {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.5s ease;
            position: relative;
            flex-shrink: 0;
            min-height: 100vh;
        }
        
        /* Layout with form on left, hero floating inside on right */
        .page-content {
            position: relative;
        }
        
        /* Form column takes specific width on left */
        #formColumn {
            position: relative;
            z-index: 1;
        }
        
        /* Hero section positioned absolutely on the right side */
        .page-content > div:last-child {
            position: absolute;
            right: 40px;
            top: 40px;
            bottom: 40px;
            left: auto;
            width: calc(58.333333% - 60px);
            height: calc(100vh - 80px);
            border-radius: 24px;
            overflow: hidden;
            z-index: 2;
        }
        
        @media (min-width: 1280px) {
            .page-content > div:last-child {
                width: calc(60% - 60px);
            }
        }
        
        @media (max-width: 1023px) {
            .page-content > div:last-child {
                display: none;
            }
        }
        
        .page-slide-left {
            animation: slideOutLeft 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        
        .page-slide-right {
            animation: slideOutRight 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        
        .page-slide-in-right {
            animation: slideInRight 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        
        .page-slide-in-left {
            animation: slideInLeft 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        
        @keyframes slideOutLeft {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(-100%); opacity: 0; }
        }
        
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideInLeft {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        input:focus {
            outline: none;
            border-color: #23237E;
            box-shadow: 0 0 0 3px rgba(35, 35, 126, 0.1);
        }
        
        input[type="checkbox"]:checked {
            background-color: #23237E;
            border-color: #23237E;
        }

        /* Modern dashboard mockup styles */
        .dashboard-card {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .metric-value {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
        }
        
        .metric-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }
        
        .chart-line {
            stroke: #23237E;
            stroke-width: 2;
            fill: none;
        }
        
        .progress-circle {
            transform: rotate(-90deg);
        }
        
        /* Simplified hero background */
        .hero-background {
            background: #23237E;
            box-shadow: 0 20px 60px rgba(35, 35, 126, 0.3);
        }
        
        /* Curved corners for hero section */
        .hero-background::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 24px;
            background: inherit;
            z-index: -1;
        }
    </style>
    
    @notifyCss
    @stack('styles')
</head>
<body class="bg-gray-50 antialiased">
    <x-notify::notify />
    <div class="page-container">
        <div id="pageContent" class="page-content flex flex-col lg:flex-row">
            <!-- Left Column - Form Content -->
            <div id="formColumn" class="w-full lg:w-5/12 xl:w-2/5 bg-white flex flex-col min-h-screen">
                <div class="flex-1 flex flex-col px-6 py-8 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                    <!-- Logo -->
                    <div class="mb-8 lg:mb-12 animate-fade-in">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-3 group">
                            <img src="{{ asset('assets/image/logo.png') }}" alt="PortApps Logo" class="w-10 h-10 object-contain transition-transform group-hover:scale-110">
                            <span class="text-2xl font-bold text-gray-900">PortApps</span>
                        </a>
                    </div>

                    <!-- Main Content -->
                    @yield('content')

                    <!-- Footer -->
                    <div class="mt-8 lg:mt-12 pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                            <p class="text-center sm:text-left">
                                Hak Cipta © {{ date('Y') }} PortApps. Seluruh hak dilindungi.
                            </p>
                            <a href="#" class="hover:text-gray-700 transition-colors font-medium">
                                Kebijakan Privasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Hero Section with Dashboard Mockup -->
            <div class="hidden lg:flex relative overflow-hidden hero-background">
                <div class="relative z-10 flex items-center justify-center w-full p-6 xl:p-8">
                    <div class="max-w-2xl w-full">
                        <!-- Hero Content -->
                        <div class="mb-6 text-center">
                            <h2 class="text-2xl xl:text-3xl font-bold text-white mb-3 leading-tight">
                                Kelola Operasional Pelabuhan<br/>Dengan Mudah dan Efisien
                            </h2>
                            <p class="text-white text-opacity-80 text-sm xl:text-base">
                                @yield('hero-description', 'Masuk untuk mengakses dashboard admin dan mengelola kegiatan bongkar muat kapal.')
                            </p>
                        </div>
                        
                        <!-- Dashboard Mockup -->
                        <div class="bg-white rounded-xl shadow-2xl p-4 transform scale-90 hover:scale-95 transition-transform duration-300">
                            <!-- macOS Window Controls -->
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            
                            <!-- Top Metrics Row -->
                            <div class="grid grid-cols-3 gap-3 mb-4">
                                <div class="dashboard-card text-white p-3" style="background-color: #23237E;">
                                    <div class="text-xs opacity-90 mb-1">Total Kapal Bulan Ini</div>
                                    <div class="text-lg font-bold">127 Unit</div>
                                </div>
                                <div class="dashboard-card p-3">
                                    <div class="text-xs text-gray-500">Muatan Terbongkar</div>
                                    <div class="text-lg font-bold text-gray-900">8,542 Ton</div>
                                </div>
                                <div class="dashboard-card p-3">
                                    <div class="text-xs text-gray-500">Kapal Aktif</div>
                                    <div class="text-lg font-bold text-gray-900">18 Unit</div>
                                </div>
                            </div>
                            
                            <!-- Chart and Progress Row -->
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div class="dashboard-card p-3">
                                    <div class="text-xs text-gray-500 mb-2">Grafik Aktivitas Harian</div>
                                    <svg class="w-full h-16" viewBox="0 0 100 40">
                                        <polyline class="chart-line" points="0,35 20,30 40,20 60,25 80,10 100,15"/>
                                    </svg>
                                </div>
                                <div class="dashboard-card flex items-center justify-center p-3">
                                    <svg class="w-20 h-20">
                                        <circle cx="40" cy="40" r="32" fill="none" stroke="#E5E7EB" stroke-width="6"/>
                                        <circle class="progress-circle" cx="40" cy="40" r="32" fill="none" stroke="#23237E" stroke-width="6" stroke-dasharray="201" stroke-dashoffset="50.25" stroke-linecap="round"/>
                                        <text x="40" y="44" text-anchor="middle" class="text-lg font-bold fill-gray-900">75%</text>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Data Table -->
                            <div class="dashboard-card p-3">
                                <div class="text-xs font-semibold text-gray-700 mb-2">Aktivitas Terkini</div>
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between text-xs py-1.5 border-b border-gray-100">
                                        <span class="text-gray-600">KM. Sinar Harapan</span>
                                        <span class="text-green-600 font-semibold">Bongkar</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs py-1.5 border-b border-gray-100">
                                        <span class="text-gray-600">KM. Mutiara Timur</span>
                                        <span class="text-blue-600 font-semibold">Muat</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs py-1.5">
                                        <span class="text-gray-600">KM. Nusantara Jaya</span>
                                        <span class="text-green-600 font-semibold">Bongkar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Script -->
    <script src="{{ asset('assets/navigation.js') }}"></script>
    
    @notifyJs
    @stack('scripts')
</body>
</html>
