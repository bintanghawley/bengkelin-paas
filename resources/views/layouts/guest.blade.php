<!DOCTYPE html>
<html lang="en" class="h-full dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bengkelin - Auth</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    {{-- Force dark mode permanently --}}
    <script>document.documentElement.classList.add('dark', 'js');</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Hide all scrollbars globally */
        *::-webkit-scrollbar {
            display: none !important;
        }
        * {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }

        .font-bengkel { font-family: 'Bebas Neue', sans-serif; tracking-wide; }
        body { font-family: 'Inter', sans-serif; }

        /* Prevent browser autofill from changing font styles, sizes, and colors */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #27272a inset !important; /* zinc-800 */
            -webkit-text-fill-color: #ffffff !important;
            font-size: 0.875rem !important; /* text-sm */
            font-family: 'Inter', sans-serif !important;
        }

        /* Toast animation */
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .animate-toast {
            animation: slideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="h-full bg-zinc-950 text-white antialiased">

    @yield('content')

    <script>
        // --- LOGIC PHONE INPUT ---
        const getPhoneDigits = (value) => value.replace(/\D/g, '').slice(0, 13);

        const formatPhoneValue = (value) => {
            const parts = getPhoneDigits(value).match(/.{1,4}/g);
            return parts ? parts.join('-') : '';
        };

        const bindPhoneInputs = () => {
            document.querySelectorAll('[data-phone-input]').forEach((input) => {
                const applyFormat = () => {
                    input.value = formatPhoneValue(input.value);
                };

                applyFormat();

                if (!input.dataset.phoneBound) {
                    input.dataset.phoneBound = 'true';
                    input.addEventListener('input', applyFormat);

                    const form = input.closest('form');
                    if (form && !form.dataset.phoneFormatBound) {
                        form.dataset.phoneFormatBound = 'true';
                        form.addEventListener('submit', () => {
                            form.querySelectorAll('[data-phone-input]').forEach((field) => {
                                const originalName = field.dataset.phoneOriginalName || field.name;
                                if (!originalName) {
                                    return;
                                }
                                const digits = getPhoneDigits(field.value);
                                let hidden = form.querySelector(`input[type="hidden"][data-phone-hidden="${originalName}"]`);
                                if (!hidden) {
                                    hidden = document.createElement('input');
                                    hidden.type = 'hidden';
                                    hidden.name = originalName;
                                    hidden.setAttribute('data-phone-hidden', originalName);
                                    form.appendChild(hidden);
                                }
                                hidden.value = digits;
                                field.dataset.phoneOriginalName = originalName;
                                field.name = `${originalName}_formatted`;
                            });
                        });
                    }
                }
            });
        };

        bindPhoneInputs();
        window.addEventListener('pageshow', bindPhoneInputs);
        window.addEventListener('load', () => setTimeout(bindPhoneInputs, 50));

        // Custom Confirm and Alert Dialog Functions
        window.showAlert = function(title, message) {
            const modal = document.getElementById('custom-alert-modal');
            const titleEl = document.getElementById('custom-alert-title');
            const msgEl = document.getElementById('custom-alert-message');
            const okBtn = document.getElementById('custom-alert-ok-btn');

            titleEl.textContent = title || 'PERINGATAN';
            msgEl.textContent = message || '';

            modal.classList.remove('hidden');

            return new Promise((resolve) => {
                const handleOk = () => {
                    modal.classList.add('hidden');
                    okBtn.removeEventListener('click', handleOk);
                    resolve();
                };
                okBtn.addEventListener('click', handleOk);
            });
        };

        window.showConfirm = function(title, message) {
            const modal = document.getElementById('custom-confirm-modal');
            const titleEl = document.getElementById('custom-confirm-title');
            const msgEl = document.getElementById('custom-confirm-message');
            const cancelBtn = document.getElementById('custom-confirm-cancel-btn');
            const okBtn = document.getElementById('custom-confirm-ok-btn');

            titleEl.textContent = title || 'KONFIRMASI';
            msgEl.textContent = message || 'Apakah Anda yakin?';

            modal.classList.remove('hidden');

            return new Promise((resolve) => {
                const handleCancel = () => {
                    modal.classList.add('hidden');
                    cleanup();
                    resolve(false);
                };
                const handleOk = () => {
                    modal.classList.add('hidden');
                    cleanup();
                    resolve(true);
                };
                const cleanup = () => {
                    cancelBtn.removeEventListener('click', handleCancel);
                    okBtn.removeEventListener('click', handleOk);
                };

                cancelBtn.addEventListener('click', handleCancel);
                okBtn.addEventListener('click', handleOk);
            });
        };

        // Intercept form submissions that have an onsubmit confirmation
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form.dataset.confirmed === 'true') {
                return;
            }

            const onsubmitAttr = form.getAttribute('onsubmit');
            if (onsubmitAttr && onsubmitAttr.includes('confirm(')) {
                e.preventDefault();
                e.stopImmediatePropagation();

                let message = 'Apakah Anda yakin?';
                const match = onsubmitAttr.match(/confirm\(['"](.*?)['"]\)/);
                if (match && match[1]) {
                    message = match[1];
                }

                window.showConfirm('KONFIRMASI', message).then(confirmed => {
                    if (confirmed) {
                        form.dataset.confirmed = 'true';
                        form.submit();
                    }
                });
            }
        }, true);

        // Intercept button/link clicks that have an onclick confirmation
        document.addEventListener('click', function(e) {
            const target = e.target.closest('[onclick]');
            if (!target) return;

            if (target.dataset.confirmed === 'true') {
                return;
            }

            const onclickAttr = target.getAttribute('onclick');
            if (onclickAttr && onclickAttr.includes('confirm(')) {
                e.preventDefault();
                e.stopImmediatePropagation();

                let message = 'Apakah Anda yakin?';
                const match = onclickAttr.match(/confirm\(['"](.*?)['"]\)/);
                if (match && match[1]) {
                    message = match[1];
                }

                window.showConfirm('KONFIRMASI', message).then(confirmed => {
                    if (confirmed) {
                        const originalConfirm = window.confirm;
                        window.confirm = () => true;
                        
                        target.dataset.confirmed = 'true';
                        target.click();
                        
                        window.confirm = originalConfirm;
                        target.dataset.confirmed = 'false';
                    }
                });
            }
        }, true);
    </script>
    
    {{-- Custom Confirm & Alert Modals HTML --}}
    <div id="custom-alert-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 max-w-sm w-full text-center space-y-6 shadow-2xl animate-toast">
            <div class="flex justify-center">
                <div class="w-12 h-12 rounded-full bg-amber-500/10 text-amber-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
            <div class="space-y-2">
                <h3 id="custom-alert-title" class="font-bengkel text-xl text-white uppercase tracking-wider">Peringatan</h3>
                <p id="custom-alert-message" class="text-xs text-zinc-400 normal-case leading-relaxed">Pesan peringatan</p>
            </div>
            <div class="flex">
                <button id="custom-alert-ok-btn" type="button" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition">OK</button>
            </div>
        </div>
    </div>

    <div id="custom-confirm-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 max-w-sm w-full text-center space-y-6 shadow-2xl animate-toast">
            <div class="flex justify-center">
                <div class="w-12 h-12 rounded-full bg-red-600/10 text-red-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
            <div class="space-y-2">
                <h3 id="custom-confirm-title" class="font-bengkel text-xl text-white uppercase tracking-wider">Konfirmasi</h3>
                <p id="custom-confirm-message" class="text-xs text-zinc-400 normal-case leading-relaxed">Apakah Anda yakin?</p>
            </div>
            <div class="flex gap-4">
                <button id="custom-confirm-cancel-btn" type="button" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition">Batal</button>
                <button id="custom-confirm-ok-btn" type="button" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg shadow-red-900/20">Yakin</button>
            </div>
        </div>
    </div>

    @include('partials.toast')
</body>
</html>