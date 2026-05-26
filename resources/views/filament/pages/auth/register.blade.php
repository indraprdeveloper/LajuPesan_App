<div class="fixed inset-0 z-[9999] bg-[#f7f9fb] text-[#191c1e] min-h-screen flex flex-col font-body-md overflow-x-hidden">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Work+Sans:wght@500;600&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
        .glass-nav {
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
        }
        .soft-shadow {
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        }
        
        /* Filament Form Overrides to match Stitch style & Fit in 1 Page */
        .fi-input-wrp {
            background-color: #ffffff !important;
            border: 1px solid #e0e3e5 !important;
            border-radius: 0.75rem !important;
            box-shadow: none !important;
            transition: all 0.2s ease-in-out;
        }
        .fi-input-wrp:focus-within {
            border-color: #f59e0b !important;
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.1) !important;
        }
        
        /* Style file upload area */
        .fi-fo-file-upload-dropzone {
            background-color: transparent !important;
            border: 2px dashed #d8c3ad !important;
            border-radius: 0.75rem !important;
            box-shadow: none !important;
            transition: all 0.2s ease-in-out;
        }
        .fi-fo-file-upload-dropzone:hover, .fi-fo-file-upload-dropzone:focus-within {
            border-color: #f59e0b !important;
            background-color: #f59e0b0d !important;
        }
        .fi-fo-field-wrp-label span {
            font-weight: 600 !important;
            font-size: 14px !important;
            color: #534434 !important;
        }
        
        /* Hide required asterisk (bintang-bintang) */
        .fi-fo-field-wrp-label sup {
            display: none !important;
        }

        /* Style the submit button */
        .fi-btn, button[type="submit"] {
            background-color: #f59e0b !important;
            color: #613b00 !important;
            border-radius: 9999px !important; /* Fully rounded pill */
            height: 3rem !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05) !important;
            border: none !important;
        }
        .fi-btn-label {
            font-size: 16px !important;
            color: #613b00 !important;
        }

        /* Compress form spacing */
        .fi-fo-component-container { gap: 0.5rem !important; }
        .fi-fo-field-wrp { margin-bottom: 0 !important; }
        .fi-fo-file-upload-dropzone { padding: 0.5rem !important; min-height: 80px !important; }
    </style>

    <header class="w-full h-16 glass-nav absolute top-0 z-50 flex items-center border-b border-outline-variant/30">
        <div class="w-full md:w-1/2 flex px-sm">
            <div class="w-full max-w-md m-auto flex justify-start">
                <div class="font-headline-md text-headline-md font-bold text-primary flex items-center gap-2">
                    <img src="{{ asset('assets/images/logolajupesan.png') }}" class="h-8 w-auto" alt="Logo">
                    LajuPesan
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow flex flex-col md:flex-row pt-16 w-full h-full">
        <!-- Left: Register Form Container -->
        <section class="w-full md:w-1/2 flex flex-col p-sm overflow-y-auto bg-background relative z-10 h-full">
            <div class="w-full max-w-md m-auto space-y-sm py-xs">
                <!-- Branding & Title -->
                <div class="space-y-xs">
                    <h1 class="font-headline-md text-headline-md text-on-surface">Mulai Bisnis Anda</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant">Buat akun untuk bergabung dengan platform E-Menu kami.</p>
                </div>
                
                <!-- Registration Form (Filament Native but Styled) -->
                <x-filament-panels::form wire:submit="register" class="space-y-2" novalidate>
                    {{ $this->form }}

                    <x-filament-panels::form.actions
                        :actions="$this->getCachedFormActions()"
                        :full-width="$this->hasFullWidthFormActions()"
                    />
                </x-filament-panels::form>
                
                <!-- Footer Link -->
                @if (filament()->hasLogin())
                <div class="text-center pt-sm">
                    <p class="font-body-sm text-on-surface-variant">
                        Sudah punya akun? <a class="text-primary font-bold hover:underline" href="{{ filament()->getLoginUrl() }}">Masuk di sini</a>
                    </p>
                </div>
                @endif
            </div>
        </section>

        <!-- Right: Decorative Hero Image (Desktop Only) -->
        <section class="hidden md:block md:w-1/2 relative overflow-hidden bg-surface-container-highest h-full">
            <img alt="Premium Culinary Experience" class="w-full h-full object-cover" src="{{ asset('assets/images/bgregister.png') }}"/>
            
            <div class="absolute inset-0 bg-primary/10 mix-blend-multiply"></div>
            <div class="absolute bottom-xl left-xl right-xl p-lg bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl max-w-sm">
                <div class="flex items-center gap-md">
                    <div class="bg-primary-container p-sm rounded-lg text-on-primary-container">
                        <span class="material-symbols-outlined text-[24px]" data-icon="restaurant">restaurant</span>
                    </div>
                    <div>
                        <h3 class="font-headline-sm text-on-surface">Digitalize Your Menu</h3>
                        <p class="font-body-md text-on-surface-variant">Tingkatkan efisiensi layanan restoran Anda hari ini.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Simple Footer -->
    <footer class="w-full py-md border-t border-outline-variant/20 flex bg-background mt-auto z-50">
        <div class="w-full md:w-1/2 flex px-sm">
            <div class="w-full max-w-md m-auto flex justify-center text-center">
                <p class="font-label-sm text-label-sm text-on-surface-variant">© {{ date('Y') }} LajuPesan</p>
            </div>
        </div>
    </footer>
</div>
