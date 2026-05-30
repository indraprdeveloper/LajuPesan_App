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
        .soft-shadow {
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        }

        /* OTP input styling */
        .otp-input {
            width: 42px;
            height: 56px;
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            font-family: 'Courier New', monospace;
            color: #855300;
            background-color: #f2f4f6;
            border: 2px solid transparent;
            border-radius: 12px;
            outline: none;
            transition: all 0.2s ease;
            caret-color: #f59e0b;
        }
        @media (min-width: 380px) {
            .otp-input {
                width: 46px;
                height: 58px;
                font-size: 22px;
            }
        }
        @media (min-width: 640px) {
            .otp-input {
                width: 52px;
                height: 64px;
                font-size: 24px;
            }
        }
        .otp-input:focus {
            border-color: #f59e0b;
            background-color: #fffbeb;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
        }
        .otp-input.filled {
            background-color: #fffbeb;
            border-color: #d8c3ad;
        }

        /* Shake animation for error */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
        .shake { animation: shake 0.4s ease-in-out; }

        /* Pulse animation for resend timer */
        @keyframes pulse-soft {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        .pulse-soft { animation: pulse-soft 2s ease-in-out infinite; }
    </style>

    <main class="flex flex-col md:flex-row w-full h-full">
        {{-- Left Section: Visual/Hero (Desktop only) --}}
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
                    <h2 class="font-display-lg text-display-lg mb-md leading-tight">Satu Langkah Lagi Menuju Digitalisasi.</h2>
                    <p class="font-body-lg text-body-lg opacity-90">Verifikasi email Anda untuk mulai menggunakan platform menu digital premium kami.</p>
                </div>
            </div>
        </section>

        {{-- Right Section: OTP Verification Form --}}
        <section class="flex flex-col flex-1 p-container-margin-mobile md:p-xl bg-background relative overflow-hidden">
            {{-- Mobile Logo --}}
            <div class="md:hidden w-full max-w-sm mx-auto mb-lg flex items-center gap-2 mt-4">
                <img src="{{ asset('assets/images/logolajupesan.png') }}" class="h-8 w-auto" alt="Logo">
                <span class="font-headline-md text-headline-md font-bold text-primary">LajuPesan</span>
            </div>

            <div class="w-full max-w-sm m-auto py-4" x-data="otpHandler()" x-init="init()" @otp-error.window="triggerShake()">
                {{-- Header --}}
                <header class="mb-lg text-center">
                    <div class="w-16 h-16 bg-primary-container/20 rounded-2xl flex items-center justify-center mx-auto mb-md">
                        <span class="material-symbols-outlined text-[32px] text-primary" data-icon="mark_email_read">mark_email_read</span>
                    </div>
                    <h2 class="font-display-lg text-display-lg text-on-surface mb-xs" style="font-size: 26px; line-height: 34px;">Verifikasi Email</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Masukkan kode 6 digit yang telah dikirim ke
                    </p>
                    <p class="font-label-lg text-label-lg text-primary mt-1">
                        {{ filament()->auth()->user()->email }}
                    </p>
                </header>

                {{-- OTP Input Boxes --}}
                <form wire:submit="verifyOtp" class="space-y-lg">
                    <div class="flex justify-center gap-1.5 sm:gap-3" id="otp-container" :class="{ 'shake': shakeError }">
                        <template x-for="(digit, index) in digits" :key="index">
                            <input
                                type="text"
                                inputmode="numeric"
                                maxlength="1"
                                class="otp-input"
                                :class="{ 'filled': digit !== '' }"
                                :value="digit"
                                @input="handleInput($event, index)"
                                @keydown="handleKeydown($event, index)"
                                @paste="handlePaste($event)"
                                @focus="$event.target.select()"
                                x-ref="otpInput"
                                :data-index="index"
                                autocomplete="one-time-code"
                            />
                        </template>
                    </div>

                    {{-- Hidden wire:model sync --}}
                    <input type="hidden" wire:model="otp" x-ref="otpHidden" />

                    {{-- Verify Button --}}
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="w-full h-14 bg-primary-container text-on-primary-container font-headline-sm text-headline-sm rounded-full soft-shadow hover:brightness-105 active:scale-[0.98] transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="!isComplete"
                        :class="{ 'opacity-50 cursor-not-allowed': !isComplete }"
                    >
                        <span wire:loading.remove wire:target="verifyOtp" class="flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined" data-icon="verified">verified</span>
                            Verifikasi
                        </span>
                        <svg wire:loading wire:target="verifyOtp" class="animate-spin h-6 w-6 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>

                {{-- Resend Section --}}
                <div class="mt-lg text-center">
                    <p class="font-body-md text-body-md text-on-surface-variant mb-2">
                        Tidak menerima kode?
                    </p>

                    <div x-data="resendTimer()" x-init="startTimer()">
                        <button
                            x-show="canResend"
                            wire:click="resendOtp"
                            @click="onResend()"
                            class="text-primary font-label-lg text-label-lg hover:underline transition-all inline-flex items-center gap-1"
                            type="button"
                        >
                            <span class="material-symbols-outlined text-[18px]" data-icon="refresh">refresh</span>
                            Kirim Ulang Kode
                        </button>

                        <p x-show="!canResend" class="text-on-surface-variant font-label-lg text-label-lg pulse-soft inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-[18px]" data-icon="timer">timer</span>
                            Kirim ulang dalam <span class="text-primary font-bold" x-text="countdown + 's'"></span>
                        </p>
                    </div>
                </div>

                {{-- Security Note --}}
                <div class="mt-lg bg-surface-container-low rounded-xl p-md flex gap-3 items-start">
                    <span class="material-symbols-outlined text-[20px] text-outline mt-0.5" data-icon="shield">shield</span>
                    <p class="font-label-sm text-label-sm text-on-surface-variant leading-relaxed">
                        Jangan pernah membagikan kode verifikasi kepada siapa pun. Tim LajuPesan tidak akan pernah meminta kode Anda.
                    </p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-auto text-center pb-8">
                <p class="font-label-sm text-label-sm text-outline">© {{ date('Y') }} LajuPesan</p>
            </div>

            {{-- Decorative bg --}}
            <div class="absolute top-20 right-10 opacity-[0.03] pointer-events-none select-none hidden lg:block">
                <span class="material-symbols-outlined text-[120px]" data-icon="mail">mail</span>
            </div>
            <div class="absolute bottom-20 left-1/2 opacity-[0.03] pointer-events-none select-none hidden lg:block">
                <span class="material-symbols-outlined text-[150px]" data-icon="verified_user">verified_user</span>
            </div>
        </section>
    </main>

    <script>
        function otpHandler() {
            return {
                digits: ['', '', '', '', '', ''],
                shakeError: false,
                isComplete: false,

                init() {
                    this.$watch('digits', (value) => {
                        const code = value.join('');
                        this.isComplete = code.length === 6 && /^\d{6}$/.test(code);
                        this.$refs.otpHidden.value = code;
                        this.$refs.otpHidden.dispatchEvent(new Event('input'));
                    });
                },

                clearDigits() {
                    this.digits = ['', '', '', '', '', ''];
                    const inputs = document.querySelectorAll('.otp-input');
                    inputs.forEach(input => input.value = '');
                    if (inputs[0]) inputs[0].focus();
                },

                handleInput(event, index) {
                    const val = event.target.value.replace(/\D/g, '');
                    if (val) {
                        this.digits[index] = val.charAt(0);
                        event.target.value = val.charAt(0);
                        // Move to next input
                        if (index < 5) {
                            const next = event.target.parentNode.querySelector(`[data-index="${index + 1}"]`);
                            if (next) next.focus();
                        }
                    } else {
                        this.digits[index] = '';
                        event.target.value = '';
                    }
                },

                handleKeydown(event, index) {
                    if (event.key === 'Backspace') {
                        if (this.digits[index] === '' && index > 0) {
                            const prev = event.target.parentNode.querySelector(`[data-index="${index - 1}"]`);
                            if (prev) {
                                this.digits[index - 1] = '';
                                prev.value = '';
                                prev.focus();
                            }
                        } else {
                            this.digits[index] = '';
                            event.target.value = '';
                        }
                    }
                },

                handlePaste(event) {
                    event.preventDefault();
                    const paste = (event.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').substring(0, 6);
                    for (let i = 0; i < paste.length && i < 6; i++) {
                        this.digits[i] = paste[i];
                        const input = event.target.parentNode.querySelector(`[data-index="${i}"]`);
                        if (input) input.value = paste[i];
                    }
                    // Focus on the next empty or last
                    const focusIndex = Math.min(paste.length, 5);
                    const focusEl = event.target.parentNode.querySelector(`[data-index="${focusIndex}"]`);
                    if (focusEl) focusEl.focus();
                },

                triggerShake() {
                    this.shakeError = true;
                    setTimeout(() => {
                        this.shakeError = false;
                        this.clearDigits();
                    }, 500);
                }
            }
        }

        function resendTimer() {
            return {
                countdown: 60,
                canResend: false,
                timer: null,

                startTimer() {
                    this.canResend = false;
                    this.countdown = 60;
                    this.timer = setInterval(() => {
                        this.countdown--;
                        if (this.countdown <= 0) {
                            clearInterval(this.timer);
                            this.canResend = true;
                        }
                    }, 1000);
                },

                onResend() {
                    this.startTimer();
                }
            }
        }
    </script>
</div>
