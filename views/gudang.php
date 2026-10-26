
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Manajemen Gudang</title>
    <link rel="stylesheet" href="../public/gudang.css">
    <script src="../public/gudang.js" defer></script>
</head>
<body>
<header class="header">
    <div>
        <h1>📦 Sistem Manajemen Gudang</h1>
        <p>Kelola persediaan barang dengan mudah</p>
    </div>
</header>

<main class="container">
    <section class="stats">
        <article class="stat-card">
            <span>Total Jenis Barang</span>
            <strong id="totalProduk">0</strong>
        </article>
        <article class="stat-card">
            <span>Total Stok</span>
            <strong id="totalStok">0</strong>
        </article>
        <article class="stat-card">
            <span>Stok Menipis</span>
            <strong id="stokMenipis">0</strong>
        </article>
        <article class="stat-card">
            <span>Total Lokasi Rak</span>
            <strong id="totalRak">0</strong>
        </article>
    </section>

    <section class="card">
        <h2>Tambah Barang</h2>
        <form id="formBarang">
            <div class="form-grid">
                <label>Barcode
                    <input id="barcode" required maxlength="50"
                           placeholder="BRG001">
                </label>
                <label>Nama Barang
                    <input id="namaBarang" required maxlength="100"
                           placeholder="Buku Tulis">
                </label>
                <label>Stok Awal
                    <input id="stokAwal" type="number" min="0"
                           step="1" required value="0">
                </label>
                <label>Stok Minimum
                    <input id="stokMinimum" type="number" min="0"
                           step="1" required value="0">
                </label>
                <label>Lokasi Rak
                    <input id="rakBarang" required maxlength="30"
                           placeholder="A1">
                </label>
            </div>
            <button class="btn-primary" type="submit">+ Tambah Barang</button>
            <button class="btn-secondary" type="reset">Reset</button>
            <p id="pesan" role="status" aria-live="polite"></p>
        </form>
    </section>

    <section class="card">
        <h2>Daftar Barang</h2>
        <label class="search-label">Cari barang
            <input id="cariBarang" type="search"
                   placeholder="Cari barcode atau nama barang...">
        </label>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Barcode</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Minimum</th>
                        <th>Rak</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="daftarBarang"></tbody>
            </table>
        </div>
    </section>

    <section class="card">
        <h2>Barang Masuk</h2>
        <form id="formMasuk" class="form-grid">
            <label>Barcode Barang
                <input id="barcodeMasuk" required>
            </label>
            <label>Jumlah Masuk
                <input id="jumlahMasuk" type="number" min="1"
                       step="1" required>
            </label>
            <label>Supplier / Sumber Barang
                <input id="supplier" required>
            </label>
            <div class="form-action">
                <button class="btn-primary" type="submit">Simpan Barang Masuk</button>
            </div>
        </form>
    </section>

    <section class="card">
        <h2>Barang Keluar</h2>
        <form id="formKeluar" class="form-grid">
            <label>Barcode Barang
                <input id="barcodeKeluar" required>
            </label>
            <label>Jumlah Keluar
                <input id="jumlahKeluar" type="number" min="1"
                       step="1" required>
            </label>
            <label>Tujuan
                <input id="tujuan" required>
            </label>
            <div class="form-action">
                <button class="btn-primary" type="submit">Simpan Barang Keluar</button>
            </div>
        </form>
    </section>

    <section class="card">
        <h2>Mutasi Antar Rak</h2>
        <form id="formMutasi" class="form-grid">
            <label>Barcode Barang
                <input id="barcodeMutasi" required>
            </label>
            <label>Rak Tujuan
                <input id="rakTujuan" required>
            </label>
            <button class="btn-primary" type="submit">Pindahkan Rak</button>
        </form>
        <p class="hint">Mutasi ini memindahkan lokasi seluruh stok barang dengan barcode tersebut.</p>
    </section>

    <section class="card">
        <h2>Stock Opname</h2>
        <form id="formOpname" class="form-grid">
            <label>Barcode Barang
                <input id="barcodeOpname" required>
            </label>
            <label>Jumlah Stok Fisik
                <input id="stokFisik" type="number" min="0"
                       step="1" required>
            </label>
            <button class="btn-primary" type="submit">Simpan Stock Opname</button>
        </form>
        <p id="hasilOpname" role="status" aria-live="polite"></p>
    </section>

    <section class="card">
        <h2>Riwayat Transaksi</h2>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Jenis Transaksi</th>
                        <th>Barcode</th>
                        <th>Keterangan</th>
                        <th>Jumlah / Selisih</th>
                    </tr>
                </thead>
                <tbody id="daftarRiwayat"></tbody>
            </table>
        </div>
    </section>
</main>

<footer>Sistem Manajemen Gudang</footer>
</body>
</html>
