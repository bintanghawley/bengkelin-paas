@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white flex flex-col transition-colors duration-300">
    <div class="flex-1 flex items-center justify-center p-6 pt-4" style="min-height: 100vh;">
        <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-2 bg-white dark:bg-zinc-900 rounded-3xl overflow-hidden shadow-2xl border border-zinc-200 dark:border-zinc-800 transition-colors duration-300" style="height: 540px; max-height: 540px; min-height: 540px;">
        
        <div class="p-10 flex flex-col justify-center bg-zinc-50/50 dark:bg-zinc-800/50 border-r border-zinc-100 dark:border-zinc-800 overflow-hidden">
            <!-- Kembali ke Home Button -->
            <div class="mb-8">
                <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 text-[10px] uppercase tracking-[0.2em] font-semibold text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-all duration-300 border border-zinc-200 dark:border-zinc-800 hover:border-red-600 rounded-full px-4 py-2 bg-white/50 dark:bg-zinc-900/50 backdrop-blur-sm shadow-sm hover:shadow-red-600/10">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4 transform transition-transform duration-300 group-hover:-translate-x-1">
                        <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Kembali ke Home</span>
                </a>
            </div>

            <div class="h-16 w-16 bg-red-600 rounded-2xl flex items-center justify-center mb-6 shadow-[0_0_20px_rgba(220,38,38,0.4)] -rotate-12">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-10 h-10 text-white">
                    <path d="M14.5 11V5a2 2 0 0 0-2-2h-1a2 2 0 0 0-2 2v6M7 11h10M7 15h10M8 11v8a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-8" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="18" r="1"/>
                </svg>
            </div>
            <h1 class="text-5xl font-bengkel tracking-wider mb-2 text-zinc-900 dark:text-white">Welcome to <br><span class="text-red-600">Bengkelin</span></h1>
            <p class="text-zinc-600 dark:text-zinc-400 text-sm leading-relaxed mb-8">Solusi setiap masalah MotorMu. Sign In untuk mendapatkan pengalaman paling seru dalam booking.</p>
            
            <div class="space-y-4">
                <div class="flex items-center gap-3 text-sm text-zinc-700 dark:text-zinc-300">
                    <span class="w-2 h-2 bg-red-600 rounded-full shadow-[0_0_8px_rgba(220,38,38,0.8)]"></span> Solusi setiap masalah motormu
                </div>
                <div class="flex items-center gap-3 text-sm text-zinc-700 dark:text-zinc-300">
                    <span class="w-2 h-2 bg-red-600 rounded-full shadow-[0_0_8px_rgba(220,38,38,0.8)]"></span> Jaminan Sparepart Asli
                </div>
            </div>
        </div>

        <div class="p-10 flex flex-col justify-center border-t md:border-t-0 md:border-l border-zinc-200 dark:border-zinc-800 overflow-hidden">
            
            <form id="login-form" action="{{ route('login.process') }}" method="POST" class="space-y-5" novalidate>
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-[0.2em] mb-2 ml-1">Nomor Telepon</label>
                    <input type="tel" name="nomor_telepon" id="login-phone" value="{{ old('nomor_telepon') }}" required placeholder="08xxxxxxxxxx"
                           inputmode="numeric" autocomplete="tel" maxlength="16" data-phone-input
                           class="w-full bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-3 text-base text-zinc-900 dark:text-white focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition-all duration-200 placeholder:text-zinc-400 dark:placeholder:text-zinc-500">
                    <p id="error-nomor_telepon" class="text-red-500 text-[10px] font-bold mt-1.5 ml-1 hidden uppercase tracking-wider"></p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-[0.2em] mb-2 ml-1">Password</label>
                    <input type="password" name="password" id="login-password" required placeholder="••••••••" 
                           class="w-full bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-3 text-base text-zinc-900 dark:text-white focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition-all duration-200 placeholder:text-zinc-400 dark:placeholder:text-zinc-500">
                    <p id="error-password" class="text-red-500 text-[10px] font-bold mt-1.5 ml-1 hidden uppercase tracking-wider"></p>
                </div>

                <!-- General error message -->
                <p id="error-general" class="text-red-500 text-xs font-bold text-center hidden"></p>

                <button type="submit" id="login-submit-btn" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-red-900/40 transition active:scale-95 uppercase tracking-widest text-sm">
                    Masuk     
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-zinc-200 dark:border-zinc-800 space-y-4 text-center">
                <p class="text-zinc-500 dark:text-zinc-400 text-xs">Belum punya akun Bengkelin?</p>
                <a href="{{ route('register') }}" class="block w-full border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-bold py-3 rounded-xl transition uppercase tracking-widest text-xs">
                    Daftar Dulu
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login-form');
    const submitBtn = document.getElementById('login-submit-btn');
    const errorGeneral = document.getElementById('error-general');
    const errorFields = ['nomor_telepon', 'password'];

    function clearErrors() {
        errorGeneral.classList.add('hidden');
        errorGeneral.textContent = '';
        errorFields.forEach(field => {
            const el = document.getElementById('error-' + field);
            if (el) {
                el.classList.add('hidden');
                el.textContent = '';
            }
            // Remove red border from input
            const input = form.querySelector('[name="' + field + '"]');
            if (input) {
                input.classList.remove('border-red-500', 'dark:border-red-500');
                input.classList.add('border-zinc-200', 'dark:border-zinc-700');
            }
        });
    }

    function showFieldError(field, message) {
        const el = document.getElementById('error-' + field);
        if (el) {
            el.textContent = message;
            el.classList.remove('hidden');
        }
        const input = form.querySelector('[name="' + field + '"]');
        if (input) {
            input.classList.remove('border-zinc-200', 'dark:border-zinc-700');
            input.classList.add('border-red-500', 'dark:border-red-500');
        }
    }

    function showGeneralError(message) {
        errorGeneral.textContent = message;
        errorGeneral.classList.remove('hidden');
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        clearErrors();

        // Get raw phone digits
        const phoneInput = form.querySelector('[name="nomor_telepon"]');
        const rawPhone = phoneInput.value.replace(/\D/g, '');

        // Build form data
        const formData = new FormData();
        formData.append('_token', form.querySelector('[name="_token"]').value);
        formData.append('nomor_telepon', rawPhone);
        formData.append('password', form.querySelector('[name="password"]').value);

        // Disable button
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Memproses...';
        submitBtn.classList.add('opacity-70', 'cursor-not-allowed');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Success - redirect without page reload flash
                submitBtn.textContent = 'Berhasil! Mengalihkan...';
                submitBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
                submitBtn.classList.add('bg-emerald-600');
                window.location.href = data.redirect;
                return;
            }

            // Handle validation errors (422)
            if (response.status === 422 && data.errors) {
                Object.keys(data.errors).forEach(field => {
                    showFieldError(field, data.errors[field][0]);
                });
            } 
            // Handle auth error (401)
            else if (response.status === 401 && data.message) {
                showGeneralError(data.message);
            } 
            // Handle other errors
            else {
                showGeneralError(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
            }
        } catch (error) {
            showGeneralError('Koneksi bermasalah. Silakan coba lagi.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
            submitBtn.classList.remove('opacity-70', 'cursor-not-allowed', 'bg-emerald-600');
            submitBtn.classList.add('bg-red-600', 'hover:bg-red-700');
        }
    });
});
</script>
@endsection