<x-guest-layout>
    <!-- Tailwind CDN injection for flawless compilation -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [x-cloak] { display: none !important; }
        .bg-body { background-color: #f4f6f9; }
        .curve-fill { fill: #f4f6f9; }
        /* Add specific custom colors for exact replication */
        .text-welcome { color: #584ba1; }
        .bg-login-btn { background-color: #1e3a5f; }
        .bg-login-btn:hover { background-color: #132b4b; }
    </style>

    <div class="min-h-screen bg-body relative font-sans">
        
        <!-- Header Banner with Curve -->
        <div class="relative w-full h-[380px] overflow-hidden bg-transparent">
            <!-- Gambar Pemandangan Latar Peternakan Custom (Local Asset) -->
            <img src="{{ asset('assets/dist/img/image.png') }}" alt="Pemandangan Peternakan" class="absolute inset-0 w-full h-full object-cover object-center opacity-100">
            


            <!-- Content in Header -->
            <div class="relative z-10 flex flex-col items-center justify-center h-full pb-16 pt-8">
                <!-- Switched out E-MAS Logo with NTB Logo -->
                <img src="{{ asset('assets/dist/img/logo_ntb.png') }}" alt="Logo NTB" class="h-[120px] w-auto drop-shadow-[0_2px_10px_rgba(0,0,0,0.5)]">
                <h1 class="text-[#ffeb3b] mt-4 text-[26px] font-black tracking-widest text-center leading-tight uppercase font-serif">
                    SISPOP TERNAK
                </h1>
                <p class="text-white text-[11px] font-bold tracking-[0.2em] mt-1">
                    SISTEM INFORMASI POPULASI TERNAK NTB
                </p>
            </div>

            <!-- Curved Downwards SVG - Precise Match -->
            <div class="absolute bottom-0 w-full overflow-hidden leading-none z-10">
                <svg class="relative block w-full h-[50px] md:h-[80px]" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M0,0 C300,120 900,120 1200,0 L1200,120 L0,120 Z" class="curve-fill"></path>
                </svg>
            </div>
        </div>

        <!-- Floating Login Card Overlapping the Curve -->
        <div class="relative z-20 flex justify-center px-4 -mt-[70px] pb-16">
            <div class="w-full max-w-[460px] bg-white rounded shadow-[0_8px_30px_rgb(0,0,0,0.12)] px-8 py-10 border border-slate-100">
                
                <div class="text-center mb-8">
                    <!-- EXACT Purple color and text from screenshot -->
                    <h2 class="text-[22px] font-bold text-welcome mb-1.5">Selamat Datang !</h2>
                    <p class="text-[13px] text-slate-500 font-medium">Login untuk melanjutkan ke dashboard aplikasi.</p>
                </div>

                <x-validation-errors class="mb-5" />

                @session('status')
                    <div class="mb-5 p-3 rounded text-sm text-green-700 bg-green-50">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-5">
                        <label for="email" class="block text-[13px] font-bold text-slate-700 mb-2">Username</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter username" 
                            class="appearance-none block w-full px-3.5 py-2.5 border border-slate-300 rounded text-[13px] placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>

                    <div class="mb-6" x-data="{ show: false }">
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-[13px] font-bold text-slate-700">Password</label>
                            <a href="#" class="text-[12px] text-slate-400 hover:text-slate-600 font-medium transition-colors">Lupa password?</a>
                        </div>
                        <div class="relative">
                            <input id="password" x-bind:type="show ? 'text' : 'password'" type="password" name="password" required autocomplete="current-password" placeholder="Enter password" 
                                class="appearance-none block w-full pl-3.5 pr-10 py-2.5 border border-slate-300 rounded text-[13px] placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            
                            <!-- Toggle Button (Eye Icon) perfectly aligned right -->
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none bg-transparent">
                                <svg x-cloak x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-[15px] w-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg x-cloak x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-[15px] w-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center mb-6">
                        <input id="remember_me" type="checkbox" name="remember" class="w-[14px] h-[14px] text-blue-500 border-slate-300 rounded focus:ring-blue-500 focus:ring-offset-0 transition-colors">
                        <label for="remember_me" class="ml-2 block text-[13px] font-bold text-slate-700 mt-0.5">Ingat Saya</label>
                    </div>

                    <div>
                        <!-- Exact Orange button coloring and structure -->
                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 rounded bg-login-btn text-[13px] font-bold text-white tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a5f] transition-colors uppercase">
                            LOGIN
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-guest-layout>
