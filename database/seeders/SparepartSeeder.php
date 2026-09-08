<?php

namespace Database\Seeders;

use App\Models\Sparepart;
use Illuminate\Database\Seeder;

class SparepartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spareparts = [
            [
                'nama' => 'Aki Kering GTZ-5S X-Grade 12V 5Ah',
                'harga' => 185000,
                'stok' => 15,
                'gambar' => 'img/sparepart/aki.jpg',
                'jenis_sparepart' => 'aki motor',
                'merek' => 'X-Grade',
                'fitur' => 'Tegangan stabil 12V, Bebas perawatan (Maintenance Free), Elektroda kalsium kualitas tinggi',
                'deskripsi' => 'Aki kering GTZ-5S dari X-Grade dirancang untuk motor bebek dan matic dengan sistem kelistrikan injeksi, menyuguhkan starter mesin instan dan daya tahan lama.',
            ],
            [
                'nama' => 'Filter Udara Vario 125/150 X-Ten Premium',
                'harga' => 45000,
                'stok' => 25,
                'gambar' => 'img/sparepart/filter-vario.jpg',
                'jenis_sparepart' => 'filter udara motor',
                'merek' => 'X-Ten',
                'fitur' => 'Serat kertas khusus filtrasi mikro, Frame plastik tahan panas, Aliran udara tetap lancar',
                'deskripsi' => 'Filter udara X-Ten menjaga asupan udara bersih ke ruang bakar secara optimal, melindungi piston dan blok silinder dari keausan akibat debu mikro.',
            ],
            [
                'nama' => 'Kampas Rem Depan MK Honda Beat Sporty',
                'harga' => 35000,
                'stok' => 40,
                'gambar' => 'img/sparepart/kampas.jpg',
                'jenis_sparepart' => 'kampas rem',
                'merek' => 'MK',
                'fitur' => 'Bahan non-asbes ramah lingkungan, Daya cengkeram pakem di segala cuaca, Tidak merusak piringan cakram',
                'deskripsi' => 'Brake pad depan MK dirancang dengan material khusus tahan gesekan tinggi, memastikan pengereman responsif dan suara senyap saat tuas rem ditekan.',
            ],
            [
                'nama' => 'Aki MF Denso Maintenance Free GTZ6V',
                'harga' => 260000,
                'stok' => 10,
                'gambar' => 'img/sparepart/aki.jpg',
                'jenis_sparepart' => 'aki motor',
                'merek' => 'Denso',
                'fitur' => 'Daya starter tinggi (High CCA), Self-discharge sangat rendah, Konstruksi anti bocor',
                'deskripsi' => 'Aki motor Denso Jepang dengan kapasitas 5.5Ah yang tangguh untuk harian, mengadopsi struktur kisi-kisi grid tangguh untuk masa pakai lebih panjang.',
            ],
            [
                'nama' => 'Cairan Anti Bocor Ban Tubeless Jossz 500ml',
                'harga' => 28000,
                'stok' => 50,
                'gambar' => 'img/sparepart/cairan.jpg',
                'jenis_sparepart' => 'cairan anti bocor',
                'merek' => 'Jossz',
                'fitur' => 'Menutup lubang paku instan hingga 6mm, Tidak membuat korosi velg, Formulasi awet di dalam ban',
                'deskripsi' => 'Cairan ban tubeless Jossz melindungi perjalanan Anda dari kebocoran paku di jalan. Cukup tuangkan ke dalam ban tubeless dan ban siap melibas paku.',
            ],
            [
                'nama' => 'Cairan Sealant Anti Bocor Ban Tubeless X-Guard 350ml',
                'harga' => 32000,
                'stok' => 35,
                'gambar' => 'img/sparepart/cairan.jpg',
                'jenis_sparepart' => 'cairan anti bocor',
                'merek' => 'X-Guard',
                'fitur' => 'Formula serat polimer canggih, Ramah lingkungan, Tahan suhu ekstrim ban',
                'deskripsi' => 'Sealant ban tubeless X-Guard memberikan perlindungan ekstra terhadap kebocoran ban motor matic dan sport Anda dengan penyebaran cairan merata.',
            ],
            [
                'nama' => 'Aki Lithium X-Smart LifePo4 GTZ-5S Smart Battery',
                'harga' => 380000,
                'stok' => 8,
                'gambar' => 'img/sparepart/aki.jpg',
                'jenis_sparepart' => 'aki motor',
                'merek' => 'X-Smart',
                'fitur' => 'Bobot sangat ringan (hanya 400g), Umur pakai hingga 5 tahun, Indikator kapasitas LED terintegrasi',
                'deskripsi' => 'Aki lithium pintar X-Smart dengan perlindungan sirkuit (BMS) yang mencegah overcharge dan korsleting listrik, ideal untuk motor sport dan hobi.',
            ],
            [
                'nama' => 'Filter Udara Yamaha NMAX X-Ten Racing Flow',
                'harga' => 50000,
                'stok' => 20,
                'gambar' => 'img/sparepart/filter-nmax.jpg',
                'jenis_sparepart' => 'filter udara motor',
                'merek' => 'X-Ten',
                'fitur' => 'Aliran udara naik hingga 15%, Tarikan akselerasi lebih enteng, Mudah dipasang PnP',
                'deskripsi' => 'Didistribusikan khusus untuk memaksimalkan debit udara masuk ke mesin Yamaha NMAX, menaikkan performa putaran atas tanpa mengorbankan kebersihan mesin.',
            ],
            [
                'nama' => 'Kampas Rem Belakang MK Disc Pad Suzuki GSX',
                'harga' => 42000,
                'stok' => 30,
                'gambar' => 'img/sparepart/kampas.jpg',
                'jenis_sparepart' => 'kampas rem',
                'merek' => 'MK',
                'fitur' => 'Daya pengereman stabil pada suhu panas, Tahan lama, Komposisi semi-metallic',
                'deskripsi' => 'Kampas rem belakang piringan khusus untuk Suzuki GSX series guna menjamin keselamatan berkendara pada kecepatan tinggi maupun saat menikung.',
            ],
            [
                'nama' => 'Filter Udara Honda Beat FI Denso CleanFlow',
                'harga' => 38000,
                'stok' => 30,
                'gambar' => 'img/sparepart/filter-beat.jpg',
                'jenis_sparepart' => 'filter udara motor',
                'merek' => 'Denso',
                'fitur' => 'Kertas filtrasi berlapis, Dimensi presisi OEM Honda, Kualitas standar pabrikan',
                'deskripsi' => 'Filter udara produksi Denso memastikan ketahanan filter dalam menyaring udara kotor di daerah berdebu pekat, memperpanjang durasi servis rutin.',
            ],
            [
                'nama' => 'Cairan Anti Bocor Jossz Pro 800ml',
                'harga' => 45000,
                'stok' => 25,
                'gambar' => 'img/sparepart/cairan.jpg',
                'jenis_sparepart' => 'cairan anti bocor',
                'merek' => 'Jossz',
                'fitur' => 'Kemasan botol besar untuk ban sport lebar, Perlindungan anti ranjau paku, pH netral tidak merusak karet ban',
                'deskripsi' => 'Solusi perlindungan ban tubeless untuk motor sport touring dengan ban belakang lebar yang membutuhkan kuantitas cairan lebih banyak.',
            ],
            [
                'nama' => 'Kampas Rem Depan Ceramic X-Grade Sporty',
                'harga' => 75000,
                'stok' => 20,
                'gambar' => 'img/sparepart/kampas.jpg',
                'jenis_sparepart' => 'kampas rem',
                'merek' => 'X-Grade',
                'fitur' => 'Teknologi Keramik (Ceramic Compound), Minim debu rem (Low dust), Suhu kerja pengereman sangat tinggi',
                'deskripsi' => 'Kampas rem cakram depan premium dengan compound keramik untuk sensasi pengereman super pakem dan lembut tanpa merusak piringan.',
            ],
            [
                'nama' => 'Kampas Rem Belakang Tromol X-Ten Double Protection',
                'harga' => 32000,
                'stok' => 45,
                'gambar' => 'img/sparepart/kampas.jpg',
                'jenis_sparepart' => 'kampas rem',
                'merek' => 'X-Ten',
                'fitur' => 'Kampas tromol non-asbes tebal, Pegas baja anti karat included, Tahan gesekan berat',
                'deskripsi' => 'Rem tromol belakang berkualitas tinggi dari X-Ten yang menawarkan performa henti yang aman dan masa pakai kampas yang sangat panjang.',
            ],
            [
                'nama' => 'Aki Kering X-Guard Super Heavy Duty YTZ7V',
                'harga' => 295000,
                'stok' => 12,
                'gambar' => 'img/sparepart/aki.jpg',
                'jenis_sparepart' => 'aki motor',
                'merek' => 'X-Guard',
                'fitur' => 'Kapasitas 6Ah ekstra daya kelistrikan, Sangat cocok untuk motor matic besar (NMAX/AEROX), Anti getaran ekstrem',
                'deskripsi' => 'Aki kering katup tertutup tipe YTZ7V dari X-Guard yang memberikan performa kelistrikan handal untuk lampu LED dan aksesoris kelistrikan motor Anda.',
            ],
        ];

        foreach ($spareparts as $sp) {
            Sparepart::updateOrCreate(['nama' => $sp['nama']], $sp);
        }
    }
}
