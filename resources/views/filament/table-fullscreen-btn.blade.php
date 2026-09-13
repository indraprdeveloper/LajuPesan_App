<div x-data="{
        isFullscreen: false,
        toggle() {
            let elem = this.$el.closest('.fi-ta') || document.documentElement;
            if (!document.fullscreenElement) {
                if (elem.requestFullscreen) {
                    elem.requestFullscreen().catch((err) => console.error(err));
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }
    }" 
    @fullscreenchange.window="isFullscreen = !!document.fullscreenElement"
    class="flex items-center"
>
    <style>
        .fi-ta:fullscreen {
            width: 100vw !important;
            height: 100vh !important;
            max-width: none !important;
            background-color: white !important;
            border-radius: 0 !important;
        }
        :root[class~="dark"] .fi-ta:fullscreen {
            background-color: #18181b !important; /* Tailwind zinc-900 usually used in Filament dark mode */
        }
        /* Memaksa teks untuk turun ke bawah (wrap) HANYA saat fullscreen agar tidak ada scroll horizontal */
        .fi-ta:fullscreen table,
        .fi-ta:fullscreen tbody,
        .fi-ta:fullscreen tr,
        .fi-ta:fullscreen td,
        .fi-ta:fullscreen th,
        .fi-ta:fullscreen .fi-ta-text-item,
        .fi-ta:fullscreen .fi-ta-text-item-label {
            white-space: normal !important;
        }
        /* Menyembunyikan scrollbar horizontal jika masih ada sedikit sisa overflow */
        .fi-ta:fullscreen .fi-ta-content {
            overflow-x: hidden !important;
        }
    </style>
    <button @click.prevent.stop="toggle()" type="button" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-gray fi-btn-color-gray fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-white text-gray-950 hover:bg-gray-50 dark:bg-white/5 dark:text-white dark:hover:bg-white/10 ring-1 ring-gray-950/10 dark:ring-white/20">
        <span class="fi-btn-label flex gap-2 items-center">
            <template x-if="!isFullscreen">
                @svg('heroicon-o-arrows-pointing-out', 'fi-btn-icon h-5 w-5 text-gray-400 dark:text-gray-500')
            </template>
            <template x-if="isFullscreen">
                @svg('heroicon-o-arrows-pointing-in', 'fi-btn-icon h-5 w-5 text-gray-400 dark:text-gray-500')
            </template>
            <span x-text="isFullscreen ? 'Keluar Fokus' : 'Fokus Tabel'"></span>
        </span>
    </button>
</div>
