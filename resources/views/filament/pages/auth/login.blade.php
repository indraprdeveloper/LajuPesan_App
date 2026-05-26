<div class="fixed inset-0 z-[9999] bg-[#f7f9fb] text-[#191c1e] flex flex-col md:flex-row w-full h-full overflow-hidden font-body-md">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Work+Sans:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-tertiary-container": "#72300a",
                    "secondary": "#545f73",
                    "outline-variant": "#d8c3ad",
                    "surface-variant": "#e0e3e5",
                    "surface-container-lowest": "#ffffff",
                    "on-secondary-fixed": "#111c2d",
                    "tertiary-fixed-dim": "#ffb693",
                    "on-secondary-fixed-variant": "#3c475a",
                    "on-primary-fixed-variant": "#653e00",
                    "surface-container": "#eceef0",
                    "secondary-fixed-dim": "#bcc7de",
                    "on-tertiary-fixed-variant": "#76330d",
                    "inverse-on-surface": "#eff1f3",
                    "surface-container-low": "#f2f4f6",
                    "on-error-container": "#93000a",
                    "inverse-surface": "#2d3133",
                    "tertiary-fixed": "#ffdbcc",
                    "on-tertiary": "#ffffff",
                    "secondary-container": "#d5e0f8",
                    "on-surface": "#191c1e",
                    "primary-fixed-dim": "#ffb95f",
                    "primary-fixed": "#ffddb8",
                    "error": "#ba1a1a",
                    "primary": "#855300",
                    "on-primary": "#ffffff",
                    "surface-container-high": "#e6e8ea",
                    "inverse-primary": "#ffb95f",
                    "surface-tint": "#855300",
                    "outline": "#867461",
                    "on-surface-variant": "#534434",
                    "tertiary-container": "#f79a6c",
                    "tertiary": "#944a23",
                    "surface-container-highest": "#e0e3e5",
                    "background": "#f7f9fb",
                    "on-background": "#191c1e",
                    "on-tertiary-fixed": "#351000",
                    "on-error": "#ffffff",
                    "primary-container": "#f59e0b",
                    "error-container": "#ffdad6",
                    "on-secondary-container": "#586377",
                    "on-primary-fixed": "#2a1700",
                    "surface": "#f7f9fb",
                    "secondary-fixed": "#d8e3fb",
                    "on-primary-container": "#613b00",
                    "surface-dim": "#d8dadc",
                    "surface-bright": "#f7f9fb",
                    "on-secondary": "#ffffff"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "sm": "8px",
                    "xs": "4px",
                    "container-margin-mobile": "16px",
                    "md": "16px",
                    "base": "4px",
                    "lg": "24px",
                    "xl": "40px",
                    "gutter": "16px",
                    "container-margin-desktop": "10%"
            },
            "fontFamily": {
                    "headline-sm": ["Inter"],
                    "label-sm": ["Work Sans"],
                    "price-display": ["Inter"],
                    "body-md": ["Inter"],
                    "display-lg": ["Inter"],
                    "label-lg": ["Work Sans"],
                    "body-lg": ["Inter"],
                    "headline-md": ["Inter"]
            },
            "fontSize": {
                    "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                    "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "500"}],
                    "price-display": ["18px", {"lineHeight": "24px", "fontWeight": "700"}],
                    "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                    "display-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "label-lg": ["14px", {"lineHeight": "20px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                    "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}]
            }
          },
        },
      }
    </script>
    <style>
        /* Hide scrollbar for native app feel */
        ::-webkit-scrollbar { display: none; }
        * { -ms-overflow-style: none; scrollbar-width: none; }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
        }
        .soft-shadow {
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        }
    </style>

    <main class="flex flex-col md:flex-row w-full h-full">
        <!-- Left Section: Visual/Hero -->
        <section class="hidden md:flex md:w-1/2 lg:w-3/5 relative bg-surface-container-highest overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img alt="Premium Dining Experience" class="w-full h-full object-cover" src="{{ asset('assets/images/bglogin.png') }}"/>
                <div class="absolute inset-0 bg-primary/10 mix-blend-multiply"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
            </div>
            <div class="relative z-10 p-xl flex flex-col justify-between w-full text-white h-full">
                <div>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/logolajupesan.png') }}" class="h-8 w-auto" alt="Logo">
                        <h1 class="font-headline-md text-headline-md font-bold tracking-tight">LajuPesan</h1>
                    </div>
                </div>
                <div class="max-w-md pb-10">
                    <h2 class="font-display-lg text-display-lg mb-md leading-tight">Ubah Pengalaman Kuliner Anda Menjadi Digital.</h2>
                    <p class="font-body-lg text-body-lg opacity-90">Sistem menu digital premium yang dirancang untuk efisiensi dan estetika restoran modern.</p>
                </div>
            </div>
        </section>

        <!-- Right Section: Login Form -->
        <section class="flex flex-col flex-1 p-container-margin-mobile md:p-xl bg-background relative overflow-hidden">
            <div class="md:hidden w-full max-w-sm mx-auto mb-lg flex items-center gap-2 mt-4">
                <img src="{{ asset('assets/images/logolajupesan.png') }}" class="h-8 w-auto" alt="Logo">
                <span class="font-headline-md text-headline-md font-bold text-primary">LajuPesan</span>
            </div>
            
            <div class="w-full max-w-sm m-auto py-4">
                <header class="mb-lg text-left">
                    <h2 class="font-display-lg text-display-lg text-on-surface mb-xs">Selamat Datang Kembali</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Masuk untuk mengelola restoran Anda.</p>
                </header>

                <form wire:submit="authenticate" class="space-y-md"novalidate>
                    <!-- Email Input -->
                    <div class="space-y-xs">
                        <label class="font-label-lg text-label-lg text-on-surface-variant ml-1">Alamat Email</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline" data-icon="mail">mail</span>
                            <input wire:model="data.email" class="w-full h-14 pl-12 pr-4 bg-surface-container-low border-transparent rounded-xl focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all outline-none font-body-md text-on-surface placeholder:text-outline" placeholder="Alamat Email" required type="email"/>
                        </div>
                        @error('data.email') <span class="text-error text-sm ml-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-xs">
                        <label class="font-label-lg text-label-lg text-on-surface-variant ml-1">Kata Sandi</label>
                        <div class="relative group" x-data="{ show: false }">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline" data-icon="lock">lock</span>
                            <input wire:model="data.password" class="w-full h-14 pl-12 pr-12 bg-surface-container-low border-transparent rounded-xl focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all outline-none font-body-md text-on-surface placeholder:text-outline" placeholder="Kata Sandi" required x-bind:type="show ? 'text' : 'password'"/>
                            <button @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition-colors" type="button">
                                <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                        @error('data.password') <span class="text-error text-sm ml-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Remember Me & Forgot Password -->
                    <div class="flex justify-between items-center mt-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input wire:model="data.remember" type="checkbox" class="rounded border-outline text-primary focus:ring-primary/20 bg-surface-container-low">
                            <span class="font-body-md text-on-surface-variant">Ingat saya</span>
                        </label>
                        <a class="font-label-lg text-label-lg text-primary hover:underline transition-all" href="{{ route('filament.admin.auth.password-reset.request') }}">Lupa kata sandi?</a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="w-full h-14 bg-primary-container text-on-primary-container font-headline-sm text-headline-sm rounded-full soft-shadow hover:brightness-105 active:scale-[0.98] transition-all flex items-center justify-center gap-2 mt-6">
                        Masuk
                        <span class="material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span>
                    </button>
                </form>

                @if (filament()->hasRegistration())
                <footer class="mt-lg text-center">
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Belum punya akun? 
                        <a class="text-primary font-bold hover:underline" href="{{ filament()->getRegistrationUrl() }}">Daftar di sini</a>
                    </p>
                </footer>
                @endif
            </div>

            <div class="mt-auto text-center pb-8">
                <p class="font-label-sm text-label-sm text-outline">© {{ date('Y') }} LajuPesan</p>
            </div>
            
            <!-- Decorative bg -->
            <div class="absolute top-20 right-10 opacity-[0.03] pointer-events-none select-none hidden lg:block">
                <span class="material-symbols-outlined text-[120px]" data-icon="skillet">skillet</span>
            </div>
            <div class="absolute bottom-20 left-1/2 opacity-[0.03] pointer-events-none select-none hidden lg:block">
                <span class="material-symbols-outlined text-[150px]" data-icon="wine_bar">wine_bar</span>
            </div>
        </section>
    </main>
</div>
