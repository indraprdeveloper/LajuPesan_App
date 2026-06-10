<!DOCTYPE html>

<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport"/>
<title>LajuPesan</title>
<link rel="icon" type="image/png" href="{{ asset('assets/images/logolajupesan.png') }}"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&amp;family=Work+Sans:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "secondary-fixed-dim": "#ffb95f",
                    "surface-tint": "#855300",
                    "on-secondary-fixed": "#2a1700",
                    "surface-dim": "#e4d8ce",
                    "surface": "#fffcf9",
                    "inverse-primary": "#fdb965",
                    "tertiary-fixed": "#cae6ff",
                    "on-secondary": "#ffffff",
                    "primary-container": "#855300",
                    "on-primary-container": "#ffd09a",
                    "error": "#ba1a1a",
                    "surface-container-highest": "#ece0d7",
                    "outline-variant": "#d5c4b2",
                    "on-tertiary-container": "#b5ddff",
                    "primary-fixed": "#ffddb8",
                    "tertiary": "#004b6f",
                    "secondary": "#855300",
                    "amber-accent": "#F59E0B",
                    "surface-bright": "#fffcf9",
                    "on-secondary-fixed-variant": "#653e00",
                    "surface-container-low": "#fef1e7",
                    "surface-container-lowest": "#ffffff",
                    "primary": "#855300",
                    "outline": "#837566",
                    "on-error": "#ffffff",
                    "on-surface-variant": "#514538",
                    "tertiary-container": "#116490",
                    "on-tertiary-fixed": "#001e2f",
                    "on-primary": "#ffffff",
                    "on-background": "#201b15",
                    "inverse-on-surface": "#fbefe5",
                    "secondary-fixed": "#ffddb8",
                    "error-container": "#ffdad6",
                    "secondary-container": "#F59E0B",
                    "on-tertiary": "#ffffff",
                    "primary-fixed-dim": "#fdb965",
                    "background": "#fffcf9",
                    "tertiary-fixed-dim": "#8ccdff",
                    "on-tertiary-fixed-variant": "#004b70",
                    "on-primary-fixed": "#2a1700",
                    "on-surface": "#201b15",
                    "surface-container": "#f8ece2",
                    "on-secondary-container": "#ffffff",
                    "on-primary-fixed-variant": "#653e00",
                    "inverse-surface": "#362f29",
                    "surface-variant": "#ece0d7",
                    "on-error-container": "#93000a",
                    "surface-container-high": "#f2e6dc"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "2xl": "1rem",
                    "3xl": "1.5rem",
                    "4xl": "2.5rem",
                    "full": "9999px"
            },
            "spacing": {
                    "element-gap": "12px",
                    "sm": "8px",
                    "container-padding": "24px",
                    "xs": "4px",
                    "unit": "4px",
                    "lg": "24px",
                    "xl": "32px",
                    "md": "16px"
            },
            "fontFamily": {
                    "headline-sm": ["Inter"],
                    "headline-md": ["Inter"],
                    "button-text": ["Inter"],
                    "body-md": ["Work Sans"],
                    "display-lg": ["Inter"],
                    "label-md": ["Work Sans"],
                    "body-lg": ["Work Sans"]
            },
            "fontSize": {
                    "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                    "headline-md": ["26px", {"lineHeight": "34px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "button-text": ["16px", {"lineHeight": "24px", "fontWeight": "700"}],
                    "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                    "display-lg": ["32px", {"lineHeight": "38px", "letterSpacing": "-0.04em", "fontWeight": "800"}],
                    "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                    "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
            }
          },
        },
      }
    </script>
<style>
      .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      }
      .glass-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(12px) saturate(180%);
        -webkit-backdrop-filter: blur(12px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 8px 32px 0 rgba(133, 83, 0, 0.1);
      }
      .bg-radial-depth {
        background: radial-gradient(circle at 50% 40%, rgba(245, 158, 11, 0.05) 0%, transparent 70%);
      }
      .device-frame {
        box-shadow: 
          0 0 0 3px #2c2c2e,
          0 0 0 8px #1c1c1e,
          0 0 0 10px #3a3a3c,
          0 25px 60px rgba(0,0,0,0.2),
          0 10px 20px rgba(0,0,0,0.1);
      }
      
      /* Force single-page layout & disable scrolling */
      html, body {
        height: 100%;
        height: 100dvh;
        overflow: hidden;
        margin: 0;
        padding: 0;
        -ms-overflow-style: none;
        scrollbar-width: none;
      }
      ::-webkit-scrollbar {
        display: none;
      }
      
      .pb-safe {
        padding-bottom: max(env(safe-area-inset-bottom), 16px);
      }
      .tracking-tightest {
        letter-spacing: -0.05em;
      }

      /* Height-responsive styling */
      .welcome-header {
        height: 4rem; /* h-16 */
      }
      .welcome-hero {
        margin-top: 0.5rem; /* mt-2 */
        gap: 0.375rem; /* gap-1.5 */
      }
      .welcome-title {
        font-size: 1.35rem; /* text-2xl */
      }
      .welcome-desc {
        font-size: 0.875rem; /* text-body-md */
      }
      .welcome-mockup-container {
        height: 52vh;
        min-height: 300px;
        max-height: 520px;
      }
      .welcome-footer {
        padding-top: 1rem;
        padding-bottom: 1rem;
        gap: 0.75rem;
      }
      .welcome-btn {
        height: 52px;
      }
      .welcome-subtext {
        font-size: 12px;
      }

      @media (max-height: 740px) {
        .welcome-header {
          height: 3rem; /* h-12 */
        }
        .welcome-hero {
          margin-top: 0.25rem;
          gap: 0.25rem;
        }
        .welcome-title {
          font-size: 1.15rem; /* text-xl */
        }
        .welcome-desc {
          font-size: 0.75rem; /* text-xs */
          max-width: 280px;
        }
        .welcome-mockup-container {
          height: 42vh;
          min-height: 240px;
        }
        .welcome-footer {
          padding-top: 0.5rem;
          padding-bottom: 0.5rem;
          gap: 0.5rem;
        }
        .welcome-btn {
          height: 44px;
          font-size: 14px;
        }
        .welcome-btn span {
          font-size: 18px !important;
        }
        .welcome-subtext {
          font-size: 11px;
        }
      }

      @media (max-height: 640px) {
        .welcome-header {
          height: 2.5rem; /* h-10 */
        }
        .welcome-hero {
          margin-top: 0px;
          gap: 0.125rem;
        }
        .welcome-title {
          font-size: 1rem; /* text-lg */
        }
        .welcome-desc {
          font-size: 0.7rem;
          max-width: 260px;
        }
        .welcome-mockup-container {
          height: 38vh;
          min-height: 200px;
        }
        .welcome-footer {
          padding-top: 0.25rem;
          padding-bottom: 0.25rem;
          gap: 0.25rem;
        }
        .welcome-btn {
          height: 38px;
          font-size: 13px;
        }
        .welcome-btn span {
          font-size: 16px !important;
        }
        .welcome-subtext {
          font-size: 10px;
        }
      }
    </style>
</head>
<body class="bg-surface text-on-background font-body-md selection:bg-amber-accent/30 flex flex-col items-center">
<main class="relative w-full max-w-[480px] h-screen h-[100dvh] overflow-hidden bg-radial-depth flex flex-col px-container-padding justify-between">
<!-- Header Section -->
<header class="w-full welcome-header flex items-center justify-center shrink-0">
<h1 class="font-headline-md text-[24px] text-primary tracking-tightest">LajuPesan</h1>
</header>
<!-- Hero Content Section -->
<section class="welcome-hero text-center flex flex-col z-10 shrink-0">
<h2 class="font-display-lg welcome-title text-on-surface leading-tight px-2">
    Penyedia Layanan Menu Digital
    Modernisasi Bisnis F&B dalam Hitungan Menit
</h2>
<p class="font-body-md welcome-desc text-on-surface-variant max-w-[300px] mx-auto leading-relaxed">
    Menu QR, order otomatis, dan pembayaran digital dalam satu platform.
</p>
</section>
<!-- Visual Hero Section -->
<section class="relative my-auto flex flex-col items-center justify-center min-h-0 flex-1 w-full">
<!-- Wrapper with exact dimensions of the mockup so children are positioned relative to it -->
<div class="relative welcome-mockup-container @container" style="aspect-ratio: 984/1599;">
<!-- 3D Modern Smartphone Mockup -->
<div class="w-full h-full device-frame rounded-[2.5rem] bg-[#1c1c1e] p-[6px] overflow-hidden transition-transform duration-700 hover:scale-[1.02]">
                <div class="w-full h-full rounded-[2.2rem] bg-[#fcf5ee] overflow-hidden relative">
                    <!-- Screen Content -->
                    <img alt="Menu Digital Sutherland" class="w-full h-full object-cover" src="{{ asset('assets/images/menu-sutherland.png') }}?v=4"/>
                </div>
<!-- Dynamic Island Mockup -->
<div class="absolute top-[3.5cqw] left-1/2 -translate-x-1/2 w-[28cqw] h-[5cqw] bg-black rounded-full"></div>
</div>
<!-- Floating Enhanced Glassmorphism Badge -->
<div class="absolute -right-[25cqw] top-[20%] glass-card p-[4.5cqw] rounded-[5cqw] flex items-center gap-[3.5cqw] w-[65cqw] z-30 transition-all duration-500 hover:translate-x-[-4px]">
<div class="w-[18cqw] h-[18cqw] rounded-[4cqw] bg-amber-accent flex items-center justify-center text-white shadow-lg shadow-amber-accent/30 shrink-0">
<span class="material-symbols-outlined text-[10cqw]" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
</div>
<div class="flex flex-col min-w-0">
<span class="font-bold text-on-surface text-[5.5cqw] leading-none">Setup Cepat</span>
<span class="text-[4.5cqw] font-bold text-primary uppercase tracking-wider mt-[0.5cqw] leading-none">5 Menit</span>
</div>
</div>
</div>
<!-- Decorative Glow -->
<div class="absolute -left-12 bottom-[10%] w-32 h-32 bg-amber-accent/10 rounded-full blur-[60px] -z-10"></div>
</section>
<!-- Footer / CTA Section -->
<footer class="w-full welcome-footer flex flex-col pb-safe z-20 shrink-0">
<div class="flex flex-col gap-2">
<a href="{{ filament()->getLoginUrl() }}" class="w-full welcome-btn bg-amber-accent hover:bg-[#E59200] text-white font-button-text text-base rounded-xl shadow-[0px_8px_16px_-6px_rgba(245,158,11,0.5)] flex items-center justify-center gap-2.5 active:scale-[0.98] transition-all">
                    Mulai Sekarang
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
</a>
<p class="text-center font-label-md welcome-subtext text-on-surface-variant/80 px-4">
                    Gratis selamanya untuk 5 produk pertama. Upgrade kapan saja.
                </p>
</div>

</footer>
</main>
</body></html>