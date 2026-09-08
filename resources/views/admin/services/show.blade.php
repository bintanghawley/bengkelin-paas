<div id="modal-detail-service" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="toggleModalDetailService(false)"></div>
    <div class="relative bg-zinc-900 w-full max-w-2xl rounded-3xl border border-zinc-800 shadow-2xl overflow-hidden transform transition-all max-h-[90vh] overflow-y-auto custom-scrollbar">
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bengkel text-xl text-blue-500 uppercase tracking-widest">Detail Layanan Servis</h3>
                <button type="button" onclick="toggleModalDetailService(false)" class="text-zinc-500 hover:text-white transition text-2xl">&times;</button>
            </div>
            
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left column: Info details -->
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-[10px] uppercase text-zinc-500 font-bold">Nama Layanan</h4>
                            <p id="d_serv_nama" class="text-lg font-bold text-white uppercase"></p>
                        </div>
                        <div>
                            <h4 class="text-[10px] uppercase text-zinc-500 font-bold">Harga Mulai</h4>
                            <p id="d_serv_harga" class="text-emerald-500 font-bold"></p>
                        </div>
                        <div>
                            <h4 class="text-[10px] uppercase text-zinc-500 font-bold">Estimasi Waktu</h4>
                            <p id="d_serv_waktu" class="text-zinc-300 font-semibold"></p>
                        </div>
                    </div>
                    
                    <!-- Right column: Image -->
                    <div>
                        <h4 class="text-[10px] uppercase text-zinc-500 font-bold mb-2">Gambar Layanan</h4>
                        <div class="relative w-full aspect-video bg-zinc-950 rounded-xl border border-zinc-800 overflow-hidden flex items-center justify-center">
                            <img id="d_serv_img" src="" alt="Layanan" class="w-full h-full object-cover hidden">
                            <div id="d_serv_no_img" class="text-zinc-600 text-xs italic">Tidak ada gambar</div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-[10px] uppercase text-zinc-500 font-bold mb-1">Deskripsi Singkat</h4>
                    <p id="d_serv_desc" class="text-zinc-300 text-sm leading-relaxed whitespace-pre-line bg-zinc-950 p-4 rounded-xl border border-zinc-800/60"></p>
                </div>
                
                <div>
                    <h4 class="text-sm font-bold text-white uppercase mb-3">Daftar Pekerjaan (Checklist)</h4>
                    <div id="d-service-items-container" class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <!-- JS WILL INJECT HERE -->
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-zinc-800 mt-6">
                <button type="button" onclick="toggleModalDetailService(false)" class="w-full bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl uppercase text-[10px] transition">Tutup</button>
            </div>
        </div>
    </div>
</div>
