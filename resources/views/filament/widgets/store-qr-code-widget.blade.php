<x-filament-widgets::widget>
    <x-filament::section class="fi-section">
        <div class="flex flex-col md:flex-row items-center gap-8 p-2 qr-code-widget-wrapper">
            
            <!-- Left Side: QR Code Panel -->
            <div class="flex flex-col items-center gap-3 bg-gray-50/70 dark:bg-gray-900/40 p-5 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm animate-fade-in qr-code-panel">
                <div id="qr-code-container" class="relative bg-white p-3 rounded-xl shadow-inner border border-gray-100 w-44 h-44 flex items-center justify-center">
                    {!! $this->getQrCode() !!}
                </div>
                
                <!-- URL Badge -->
                <div class="inline-flex items-center gap-1.5 py-1 px-3.5 rounded-full text-xs font-semibold border max-w-full overflow-hidden"
                     style="background-color: #fef3c7; color: #b45309; border-color: #fde68a;">
                    <!-- SVG Globe Icon -->
                    <svg class="w-3.5 h-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-.778.099-1.533.284-2.253" />
                    </svg>
                    <span class="truncate">{{ str_replace(['http://', 'https://'], '', $this->getStoreUrl()) }}</span>
                </div>
            </div>

            <!-- Right Side: Text & Actions -->
            <div class="flex-1 space-y-5 w-full qr-code-details">
                <div class="space-y-2">
                    <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Menu Digital Toko Anda
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xl leading-relaxed">
                        Bagikan QR Code ini kepada pelanggan Anda atau cetak untuk ditaruh di meja makan agar pelanggan dapat memindai dan langsung memesan secara mandiri.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 qr-code-buttons" style="margin-top: 1.75rem;"
                     x-data="{ 
                        copied: false,
                        shareUrl: '{{ $this->getStoreUrl() }}',
                        storeUsername: '{{ auth()->user()->username }}',
                        copyToClipboard() {
                            navigator.clipboard.writeText(this.shareUrl);
                            this.copied = true;
                            setTimeout(() => this.copied = false, 2000);
                        },
                        downloadPng() {
                            const container = document.getElementById('qr-code-container');
                            const svgEl = container.querySelector('svg');
                            if (!svgEl) return;

                            const svgClone = svgEl.cloneNode(true);
                            svgClone.setAttribute('width', '1000');
                            svgClone.setAttribute('height', '1000');

                            const svgData = new XMLSerializer().serializeToString(svgClone);
                            const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
                            const url = URL.createObjectURL(svgBlob);

                            const img = new Image();
                            img.onload = () => {
                                const size = 1000;
                                const canvas = document.createElement('canvas');
                                canvas.width = size;
                                canvas.height = size;
                                const ctx = canvas.getContext('2d');

                                ctx.fillStyle = '#ffffff';
                                ctx.fillRect(0, 0, size, size);
                                ctx.drawImage(img, 0, 0, size, size);

                                URL.revokeObjectURL(url);

                                canvas.toBlob((blob) => {
                                    const link = document.createElement('a');
                                    link.download = 'qrcode-' + this.storeUsername.trim() + '.png';
                                    link.href = URL.createObjectURL(blob);
                                    link.click();
                                    URL.revokeObjectURL(link.href);
                                }, 'image/png');
                            };
                            img.src = url;
                        }
                     }">
                    
                    <!-- Download Button (PNG via Canvas) -->
                    <button @click="downloadPng" type="button"
                       class="inline-flex items-center gap-2 px-4 py-2.5 text-white rounded-lg font-semibold text-sm shadow-sm transition-all duration-150 focus:outline-none cursor-pointer qr-code-btn"
                       style="background-color: #d97706;">
                        <!-- SVG Download Icon -->
                        <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        <span>Unduh QR Code</span>
                    </button>

                    <!-- Copy Link Button -->
                    <button @click="copyToClipboard" type="button"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-gray-50 active:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:active:bg-gray-900 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-sm shadow-sm transition-all duration-150 focus:outline-none qr-code-btn">
                        <!-- SVG Copy Icon -->
                        <svg x-show="!copied" class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125v-9.75a1.125 1.125 0 0 1 1.125-1.125h3.375m1.5 1.5h9.75a1.125 1.125 0 0 1 1.125 1.125v-9.75a1.125 1.125 0 0 1-1.125-1.125h-9.75a1.125 1.125 0 0 1-1.125 1.125V5.25m1.5 1.5h9.75M9 10.5h.008v.008H9V10.5Zm0 2.25h.008v.008H9v-.008Zm0 2.25h.008v.008H9v-.008Zm2.25-4.5h.008v.008H11.25V10.5Zm0 2.25h.008v.008H11.25v-.008Zm0 2.25h.008v.008H11.25v-.008Zm2.25-4.5h.008v.008H13.5V10.5Zm0 2.25h.008v.008H13.5v-.008Zm0 2.25h.008v.008H13.5v-.008Z" />
                        </svg>
                        <!-- SVG Check Icon -->
                        <svg x-show="copied" x-cloak class="w-4 h-4 text-green-600 dark:text-green-400 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        <span x-text="copied ? 'Tersalin!' : 'Salin Tautan'"></span>
                    </button>

                    <!-- View Live Menu Button -->
                    <a href="{{ $this->getStoreUrl() }}" target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-transparent rounded-lg font-semibold text-sm border transition-colors duration-150 focus:outline-none qr-code-btn"
                       style="color: #d97706; border-color: #d97706;">
                        <!-- SVG External Link Icon -->
                        <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        <span>Lihat Live Menu</span>
                    </a>
                </div>
            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
