<div class="fixed inset-0 z-[9999] bg-[#f7f9fb] text-[#191c1e] flex flex-col md:flex-row w-full h-full overflow-hidden font-body-md">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "primary": "#855300",
                    "primary-container": "#f59e0b",
                    "on-primary-container": "#613b00",
                    "surface-container-low": "#f2f4f6",
                    "outline": "#867461",
                    "error": "#ba1a1a",
                    "on-surface": "#191c1e",
                    "on-surface-variant": "#534434"
            },
            "fontFamily": {
                    "body-md": ["Inter"],
                    "headline-md": ["Inter"],
                    "label-sm": ["Work Sans"],
                    "label-lg": ["Work Sans"]
            }
          }
        }
      }
    </script>
    <style>
        ::-webkit-scrollbar { display: none; }
        * { -ms-overflow-style: none; scrollbar-width: none; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .soft-shadow {
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        }
        .modal-shadow {
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
    </style>

    <!-- Background Layer (Simulating the Login Page behind it) -->
    <div class="absolute inset-0 z-0 flex flex-col md:flex-row">
        <!-- Left Side (Empty/Gray) -->
        <div class="hidden md:flex flex-1 bg-surface-container-low items-center justify-center p-10">
           <div class="max-w-md w-full opacity-30 blur-sm pointer-events-none">
                <h1 class="text-4xl font-bold mb-4">Masuk Merchant</h1>
                <div class="h-14 bg-gray-300 rounded-xl mb-4"></div>
                <div class="h-14 bg-gray-300 rounded-xl mb-6"></div>
                <div class="h-14 bg-gray-400 rounded-full"></div>
           </div>
        </div>
        <!-- Right Side (Image) -->
        <div class="hidden md:block md:w-1/2 relative bg-gray-200">
            <img alt="Background" class="w-full h-full object-cover blur-sm opacity-80" src="{{ asset('assets/images/bglogin.png') }}"/>
            <div class="absolute inset-0 bg-black/20 mix-blend-multiply"></div>
        </div>
    </div>
    
    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/40 z-10 backdrop-blur-sm flex items-center justify-center p-4">
        
        <!-- Main Card -->
        <div class="bg-white rounded-3xl w-full max-w-[600px] p-6 md:p-8 relative z-20 modal-shadow">
            
            <!-- Header -->
            <div class="flex items-start gap-4 mb-8">
                <a href="{{ route('filament.admin.auth.login') }}" class="mt-1 text-on-surface-variant hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">arrow_back_ios</span>
                </a>
                <div>
                    <p class="text-xs font-label-sm text-on-surface-variant font-semibold tracking-wider uppercase mb-1">
                        Halaman / Kata Sandi / Konfigurasi
                    </p>
                    <h2 class="text-2xl font-headline-md font-bold text-on-surface">Konfigurasi Kata Sandi</h2>
                </div>
            </div>

            <!-- Form Content -->
            <form wire:submit.prevent="resetPassword" class="space-y-6">
                
                <!-- Email & Request OTP row -->
                <div class="space-y-1">
                    <label class="font-label-lg text-sm text-on-surface font-semibold ml-1">Alamat Email</label>
                    <div class="flex gap-3">
                        <div class="relative flex-1 group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline" data-icon="mail">mail</span>
                            <input wire:model.defer="email" class="w-full h-14 pl-12 pr-4 bg-surface-container-low border-transparent rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none font-body-md text-on-surface placeholder:text-outline" placeholder="Alamat Email" required type="email"/>
                        </div>
                        <button type="button" wire:click="sendOtp" class="h-14 px-6 bg-primary-container hover:brightness-105 active:scale-[0.98] text-on-primary-container font-bold rounded-xl whitespace-nowrap transition-all">
                            Kirim<br>OTP
                        </button>
                    </div>
                    @error('email') <span class="text-error text-sm ml-1">{{ $message }}</span> @enderror
                </div>
                
                <hr class="border-gray-200">

                <!-- OTP Input -->
                <div class="space-y-1">
                    <label class="font-label-lg text-sm text-on-surface font-semibold ml-1">Kode Token</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline" data-icon="barcode_scanner">barcode_scanner</span>
                        <input wire:model.defer="otp" class="w-full h-14 pl-12 pr-4 bg-surface-container-low border-transparent rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none font-body-md text-on-surface placeholder:text-outline" placeholder="Kode Token" required type="text"/>
                    </div>
                    @error('otp') <span class="text-error text-sm ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- New Password Input -->
                <div class="space-y-1">
                    <label class="font-label-lg text-sm text-on-surface font-semibold ml-1">Kata Sandi Baru</label>
                    <div class="relative group" x-data="{ show: false }">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline" data-icon="lock">lock</span>
                        <input wire:model.defer="password" class="w-full h-14 pl-12 pr-12 bg-surface-container-low border-transparent rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none font-body-md text-on-surface placeholder:text-outline" placeholder="Kata Sandi Baru" required x-bind:type="show ? 'text' : 'password'"/>
                        <button @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition-colors" type="button">
                            <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                        </button>
                    </div>
                    @error('password') <span class="text-error text-sm ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm Password Input -->
                <div class="space-y-1">
                    <label class="font-label-lg text-sm text-on-surface font-semibold ml-1">Konfirmasi Kata Sandi</label>
                    <div class="relative group" x-data="{ show: false }">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline" data-icon="lock">lock</span>
                        <input wire:model.defer="passwordConfirmation" class="w-full h-14 pl-12 pr-12 bg-surface-container-low border-transparent rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none font-body-md text-on-surface placeholder:text-outline" placeholder="Konfirmasi Kata Sandi" required x-bind:type="show ? 'text' : 'password'"/>
                        <button @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition-colors" type="button">
                            <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                        </button>
                    </div>
                    @error('passwordConfirmation') <span class="text-error text-sm ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full h-14 bg-primary-container hover:brightness-105 active:scale-[0.98] text-on-primary-container font-headline-sm text-base font-bold rounded-full transition-all mt-8">
                    Ubah Kata Sandi
                </button>
            </form>
            
        </div>
    </div>
    
    <!-- Render Filament Notifications -->
    @livewire('notifications')
</div>
