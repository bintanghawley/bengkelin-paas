@if(session('success') || session('error') || $errors->any())
    @php
        $isSuccess = session()->has('success');
        
        if ($isSuccess) {
            $message = session('success');
        } elseif (session()->has('error')) {
            $message = session('error');
        } else {
            $message = $errors->first();
        }

        $borderColor = $isSuccess ? 'border-emerald-500/30 shadow-emerald-950/10' : 'border-red-500/30 shadow-red-950/10';
        $iconColor = $isSuccess ? 'text-emerald-400' : 'text-red-500';
        $progressBg = $isSuccess ? 'bg-emerald-500' : 'bg-red-600';
    @endphp

    <div id="system-toast" 
         class="fixed top-6 right-6 z-[9999] max-w-sm w-full bg-zinc-900 border {{ $borderColor }} rounded-2xl shadow-2xl overflow-hidden pointer-events-auto transition-all duration-300"
         style="transform: translateX(120%);">
        
        {{-- Inner content --}}
        <div class="p-4 flex items-center gap-3.5 relative">
            {{-- Icon --}}
            <div class="shrink-0">
                @if($isSuccess)
                    <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @else
                    <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif
            </div>

            {{-- Message text --}}
            <div class="flex-1 min-w-0 pr-4 text-left">
                <p class="text-[9px] font-bold text-zinc-500 uppercase tracking-widest leading-none">
                    {{ $isSuccess ? 'Notifikasi Sukses' : 'Pemberitahuan Error' }}
                </p>
                <p class="text-xs font-bold text-white leading-relaxed mt-1 tracking-wide uppercase italic">
                    {{ $message }}
                </p>
            </div>

            {{-- Close button --}}
            <button onclick="closeSystemToast()" class="shrink-0 text-zinc-500 hover:text-zinc-300 transition p-1 hover:bg-zinc-800 rounded-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Progress Bar --}}
        <div class="w-full h-1 bg-zinc-850">
            <div id="system-toast-progress" class="h-full {{ $progressBg }} transition-all linear duration-[4000ms]" style="width: 100%;"></div>
        </div>
    </div>

    <script>
        function closeSystemToast() {
            const toast = document.getElementById('system-toast');
            if (toast) {
                toast.style.transform = 'translateX(120%)';
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('system-toast');
            const progress = document.getElementById('system-toast-progress');
            
            if (toast && progress) {
                // Show toast (slide in)
                setTimeout(() => {
                    toast.style.transform = 'translateX(0)';
                }, 100);

                // Animate progress bar to 0%
                setTimeout(() => {
                    progress.style.width = '0%';
                }, 150);

                // Auto hide after progress bar duration (4000ms + buffer)
                setTimeout(() => {
                    closeSystemToast();
                }, 4300);
            }
        });
    </script>
@endif
