<!DOCTYPE html>

<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport"/>
<title>LajuPesan</title>
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
          0 0 0 4px #1c1c1e,
          0 0 0 10px #3a3a3c,
          0 20px 50px rgba(0,0,0,0.15);
      }
      body {
        min-height: 100vh;
      }
    </style>
</head>
<body class="bg-surface text-on-background font-body-md selection:bg-amber-accent/30 flex flex-col items-center">
<main class="relative w-full max-w-[480px] min-h-screen bg-radial-depth flex flex-col px-container-padding">
<!-- Header Section -->
<header class="w-full h-16 flex items-center justify-center shrink-0">
<h1 class="font-headline-md text-[24px] text-primary tracking-tightest">LajuPesan</h1>
</header>
<!-- Hero Content Section -->
<section class="mt-4 text-center flex flex-col gap-3 z-10 shrink-0">
<h2 class="font-display-lg text-display-lg text-on-surface leading-tight px-2">
                Modernisasi Bisnis F&amp;B Anda dalam Hitungan Menit
            </h2>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-[300px] mx-auto leading-relaxed">
                Solusi digital terpadu untuk efisiensi operasional dan kepuasan pelanggan.
            </p>
</section>
<!-- Visual Hero Section -->
<section class="relative mt-8 flex flex-col items-center flex-grow justify-center">
<!-- 3D Modern Smartphone Mockup -->
<div class="relative w-[260px] h-[480px] device-frame rounded-[3.5rem] bg-[#1c1c1e] p-1.5 overflow-hidden transition-transform duration-700 hover:scale-[1.02]">
<div class="w-full h-full rounded-[3.2rem] bg-white overflow-hidden relative">
<!-- Screen Content -->
<img alt="Premium Salmon Dish" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAxqVBLqcLxP5XtGDM_yCEcR1PG3ar_BglqPSshPxA1xLiNI7rDZOC8jootTuLuFsTUZJs2N08n9l0rVxDwHKqCge5mE2mgCrV7G8zm15NxV7WvFFNbvZalzq5Z7Ka0-BjYTRybcKe4OL-11noefYLRcQncPyV3Zn6ZAyXJIJi43P2Z1YxzN7uLOT1DKfesp7TjyUt6LgpAf0lxzEV9pVBkSRLh1_pSFjGMR0GUcijBCOCSGp6lcEmK36Ipsx_9J4TksIDuCCmuBQ"/>
<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
<div class="absolute bottom-10 left-8 right-8 text-white">
<p class="font-headline-sm text-headline-sm tracking-tight">Salmon Soufflé</p>
<div class="flex items-center gap-1.5 mt-1">
<span class="w-2 h-2 rounded-full bg-green-400"></span>
<p class="font-label-md text-label-md text-white/90">Tersedia Sekarang</p>
</div>
</div>
</div>
<!-- Dynamic Island Mockup -->
<div class="absolute top-4 left-1/2 -translate-x-1/2 w-24 h-6 bg-black rounded-full"></div>
</div>
<!-- Floating Enhanced Glassmorphism Badge -->
<div class="absolute -right-2 top-[15%] glass-card p-4 rounded-3xl flex items-center gap-3 max-w-[210px] z-30 transition-all duration-500 hover:translate-x-[-8px]">
<div class="w-11 h-11 rounded-2xl bg-amber-accent flex items-center justify-center text-white shadow-lg shadow-amber-accent/30">
<span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
</div>
<div class="flex flex-col">
<span class="font-button-text text-on-surface text-[14px]">Setup Cepat</span>
<span class="text-[10px] font-bold text-primary uppercase tracking-[0.1em]">Siap dalam 5 Menit</span>
</div>
</div>
<!-- Decorative Glow -->
<div class="absolute -left-12 bottom-[10%] w-32 h-32 bg-amber-accent/10 rounded-full blur-[60px] -z-10"></div>
</section>
<!-- Footer / CTA Section -->
<footer class="w-full flex flex-col gap-6 py-8 z-20 shrink-0">
<div class="flex flex-col gap-3.5">
<a href="{{ filament()->getLoginUrl() }}" class="w-full h-[60px] bg-amber-accent hover:bg-[#E59200] text-white font-button-text text-lg rounded-2xl shadow-[0px_12px_24px_-8px_rgba(245,158,11,0.5)] flex items-center justify-center gap-3 active:scale-[0.98] transition-all">
                    Mulai Sekarang
                    <span class="material-symbols-outlined text-[22px]">arrow_forward</span>
</a>
<p class="text-center font-label-md text-label-md text-on-surface-variant/80 px-4">
                    Gratis selamanya untuk 5 produk pertama. Upgrade kapan saja.
                </p>
</div>

</footer>
</main>
<style>
        ::-webkit-scrollbar {
            display: none;
        }
        body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .pb-safe {
            padding-bottom: max(env(safe-area-inset-bottom), 16px);
        }
        .tracking-tightest {
            letter-spacing: -0.05em;
        }
    </style>
</body></html>