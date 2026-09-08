@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white transition-colors duration-300">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Back Button --}}
        <div class="mb-8">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-xs font-semibold text-zinc-400 hover:text-red-500 uppercase tracking-widest transition group">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali
            </a>
        </div>

        <h1 class="text-3xl font-bengkel text-zinc-900 dark:text-white tracking-wider uppercase mb-8">
            Halaman <span class="text-red-600">Checkout</span>
        </h1>

        @if ($errors->any())
        <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 p-4 rounded-2xl text-xs uppercase tracking-wider font-bold">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('toko.buy', $product->id) }}" method="POST" id="checkout-form">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- Form Checkout (Left Column) --}}
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
                        <h2 class="text-lg font-bengkel tracking-wider uppercase border-b border-zinc-100 dark:border-zinc-850 pb-4 text-zinc-800 dark:text-zinc-200">
                            Informasi Pengiriman
                        </h2>

                        {{-- Nama Pelanggan --}}
                        <div class="space-y-2">
                            <label class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-widest font-bold block">
                                Nama Lengkap
                            </label>
                            <input type="text" value="{{ $user->name }}" readonly disabled
                                class="w-full px-4 py-3 bg-zinc-50 dark:bg-zinc-800 text-zinc-500 rounded-xl text-sm border border-zinc-200 dark:border-zinc-750 cursor-not-allowed uppercase font-medium">
                        </div>

                        {{-- Nomor Telepon --}}
                        <div class="space-y-2">
                            <label for="telepon" class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-widest font-bold block">
                                Nomor Telepon / WhatsApp <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="telepon" id="telepon" 
                                value="{{ old('telepon', $user->nomor_telepon) }}" required
                                data-phone-input data-phone-original-name="telepon"
                                class="w-full px-4 py-3 bg-zinc-50 dark:bg-zinc-800/50 text-zinc-800 dark:text-white rounded-xl text-sm border border-zinc-200 dark:border-zinc-750 focus:border-red-600 focus:outline-none focus:ring-1 focus:ring-red-600 transition"
                                placeholder="0812-3456-7890">
                        </div>

                        {{-- Alamat Pengiriman --}}
                        <div class="space-y-2">
                            <label for="alamat" class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-widest font-bold block">
                                Alamat Pengiriman Lengkap <span class="text-red-600">*</span>
                            </label>
                            <textarea name="alamat" id="alamat" rows="3" required
                                class="w-full px-4 py-3 bg-zinc-50 dark:bg-zinc-800/50 text-zinc-800 dark:text-white rounded-xl text-sm border border-zinc-200 dark:border-zinc-750 focus:border-red-600 focus:outline-none focus:ring-1 focus:ring-red-600 transition"
                                placeholder="Tuliskan alamat pengiriman secara detail (jalan, nomor rumah, RT/RW, kecamatan, kota)">{{ old('alamat') }}</textarea>
                        </div>

                        {{-- Catatan --}}
                        <div class="space-y-2">
                            <label for="catatan" class="text-[10px] text-zinc-400 dark:text-zinc-500 uppercase tracking-widest font-bold block">
                                Catatan untuk Penjual (Opsional)
                            </label>
                            <textarea name="catatan" id="catatan" rows="2"
                                class="w-full px-4 py-3 bg-zinc-50 dark:bg-zinc-800/50 text-zinc-800 dark:text-white rounded-xl text-sm border border-zinc-200 dark:border-zinc-750 focus:border-red-600 focus:outline-none focus:ring-1 focus:ring-red-600 transition"
                                placeholder="Contoh: Titipkan di satpam, warna cadangan, dll.">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-4">
                        <h2 class="text-lg font-bengkel tracking-wider uppercase border-b border-zinc-100 dark:border-zinc-850 pb-4 text-zinc-800 dark:text-zinc-200">
                            Metode Pembayaran
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            {{-- COD Option --}}
                            <label class="relative border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 flex items-center gap-4 cursor-pointer hover:border-red-600 transition group">
                                <input type="radio" name="metode_pembayaran" value="COD" checked
                                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-zinc-300 dark:border-zinc-750">
                                <div>
                                    <span class="block font-bold text-sm uppercase tracking-wide">Cash on Delivery (COD)</span>
                                    <span class="block text-zinc-400 dark:text-zinc-500 text-[10px] mt-0.5">Bayar tunai saat barang sampai di lokasi</span>
                                </div>
                            </label>

                            {{-- Transfer Bank --}}
                            <label class="relative border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4 flex items-center gap-4 cursor-pointer hover:border-red-600 transition group">
                                <input type="radio" name="metode_pembayaran" value="Transfer Bank"
                                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-zinc-300 dark:border-zinc-750">
                                <div>
                                    <span class="block font-bold text-sm uppercase tracking-wide">Transfer Bank</span>
                                    <span class="block text-zinc-400 dark:text-zinc-500 text-[10px] mt-0.5">Transfer bank manual ke rekening Bengkelin</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Order Summary (Right Column) --}}
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-6 sticky top-6">
                        <h2 class="text-lg font-bengkel tracking-wider uppercase border-b border-zinc-100 dark:border-zinc-850 pb-4 text-zinc-800 dark:text-zinc-200">
                            Ringkasan Pesanan
                        </h2>

                        {{-- Detail Item --}}
                        <div class="flex gap-4 items-start pb-6 border-b border-zinc-100 dark:border-zinc-800">
                            <div class="w-20 h-20 bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-750 rounded-2xl overflow-hidden shrink-0 flex items-center justify-center">
                                @if($product->gambar)
                                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-10 h-10 text-zinc-300 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 space-y-1">
                                <span class="inline-block px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider
                                    {{ $product->kategori === 'ban' ? 'bg-blue-500/10 text-blue-600 dark:text-blue-400' : '' }}
                                    {{ $product->kategori === 'oli' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : '' }}
                                    {{ $product->kategori === 'sparepart' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : '' }}
                                ">
                                    {{ $product->kategori }}
                                </span>
                                <h3 class="font-bengkel uppercase text-sm tracking-wide text-zinc-900 dark:text-white line-clamp-2">
                                    {{ $product->nama }}
                                </h3>
                                <p class="text-xs text-zinc-400 dark:text-zinc-500">
                                    Stok: {{ $product->stok }} unit
                                </p>
                            </div>
                        </div>

                        {{-- Quantity Selector --}}
                        <div class="flex justify-between items-center py-4 border-b border-zinc-100 dark:border-zinc-800">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 font-bold uppercase tracking-widest">
                                Jumlah Pembelian
                            </span>
                            <div class="flex items-center gap-1.5 bg-zinc-50 dark:bg-zinc-800/80 border border-zinc-200 dark:border-zinc-750 p-1.5 rounded-2xl">
                                <button type="button" onclick="adjustQty(-1)" class="w-8 h-8 flex items-center justify-center bg-white dark:bg-zinc-700 hover:bg-red-500 hover:text-white border border-zinc-200 dark:border-zinc-650 rounded-xl transition text-sm font-bold shadow-sm">
                                    -
                                </button>
                                <input type="number" name="jumlah" id="jumlah" min="1" max="{{ $product->stok }}" value="1" readonly
                                    class="w-12 text-center bg-transparent border-0 font-bold text-sm focus:ring-0 focus:outline-none dark:text-white">
                                <button type="button" onclick="adjustQty(1)" class="w-8 h-8 flex items-center justify-center bg-white dark:bg-zinc-700 hover:bg-red-500 hover:text-white border border-zinc-200 dark:border-zinc-650 rounded-xl transition text-sm font-bold shadow-sm">
                                    +
                                </button>
                            </div>
                        </div>

                        {{-- Rincian Harga --}}
                        <div class="space-y-3 pt-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-zinc-500 dark:text-zinc-400">Harga Satuan</span>
                                <span class="font-medium">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-zinc-500 dark:text-zinc-400">Subtotal Barang</span>
                                <span class="font-medium" id="subtotal-val">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-zinc-500 dark:text-zinc-400">Biaya Pengiriman / COD</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-500">GRATIS</span>
                            </div>
                            
                            <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800 flex justify-between items-baseline">
                                <span class="text-sm font-bold uppercase tracking-wider text-zinc-800 dark:text-zinc-200">Total Tagihan</span>
                                <span class="text-2xl font-bengkel text-red-600" id="total-val">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="space-y-3 pt-4">
                            <button type="submit" class="w-full px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl text-sm font-bold uppercase tracking-widest transition shadow-lg shadow-red-600/20">
                                Konfirmasi & Bayar
                            </button>
                            <a href="{{ route('toko.show', $product->id) }}" class="block w-full text-center px-6 py-3 bg-zinc-100 dark:bg-zinc-800/80 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-2xl text-xs font-bold uppercase tracking-widest border border-zinc-200 dark:border-zinc-750 transition">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    @include('partials.footer')
</div>

<script>
    const itemPrice = {{ $product->harga }};
    const maxQty = {{ $product->stok }};
    const qtyInput = document.getElementById('jumlah');
    const subtotalVal = document.getElementById('subtotal-val');
    const totalVal = document.getElementById('total-val');

    function formatRupiah(num) {
        return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function adjustQty(amount) {
        let currentQty = parseInt(qtyInput.value);
        let newQty = currentQty + amount;
        
        if (newQty >= 1 && newQty <= maxQty) {
            qtyInput.value = newQty;
            updatePrices(newQty);
        }
    }

    function updatePrices(qty) {
        const total = itemPrice * qty;
        subtotalVal.innerText = formatRupiah(total);
        totalVal.innerText = formatRupiah(total);
    }

    // Toggle Shipping Info based on Payment Method
    const codRadio = document.querySelector('input[name="metode_pembayaran"][value="COD"]');
    const transferRadio = document.querySelector('input[name="metode_pembayaran"][value="Transfer Bank"]');
    const teleponInput = document.getElementById('telepon');
    const alamatInput = document.getElementById('alamat');
    const catatanInput = document.getElementById('catatan');
    const teleponReq = document.querySelector('label[for="telepon"] .text-red-600');
    const alamatReq = document.querySelector('label[for="alamat"] .text-red-600');

    if (teleponInput) teleponInput.dataset.initialVal = teleponInput.value;
    if (alamatInput) alamatInput.dataset.initialVal = alamatInput.value;
    if (catatanInput) catatanInput.dataset.initialVal = catatanInput.value;

    function toggleShippingInfo() {
        const isTransfer = transferRadio && transferRadio.checked;
        
        [teleponInput, alamatInput, catatanInput].forEach(input => {
            if (input) {
                input.disabled = isTransfer;
                if (isTransfer) {
                    input.required = false;
                    input.value = '';
                    input.classList.add('opacity-50', 'cursor-not-allowed', 'bg-zinc-100', 'dark:bg-zinc-800/20');
                } else {
                    if (input !== catatanInput) input.required = true;
                    input.value = input.dataset.initialVal || '';
                    input.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-zinc-100', 'dark:bg-zinc-800/20');
                }
            }
        });

        if (teleponReq) teleponReq.style.display = isTransfer ? 'none' : 'inline';
        if (alamatReq) alamatReq.style.display = isTransfer ? 'none' : 'inline';
    }

    if (codRadio && transferRadio) {
        document.querySelectorAll('input[name="metode_pembayaran"]').forEach(radio => {
            radio.addEventListener('change', toggleShippingInfo);
        });
        toggleShippingInfo();
    }
</script>
@endsection
