
<h2>Transaksi Barang Keluar</h2>

<!-- Area Kamera Scanner -->
<div id="reader"></div>

<form method="POST" action="/Sistem-Manajemen-Gudang-/public/transaksi/store">

    <div class="form-group">
        <label>Barcode Barang</label>
        <input
            type="text"
            id="barcode"
            name="barcode"
            required
            placeholder="Scan barcode atau ketik manual..."
        >
    </div>

    <div class="form-group">
        <label>Jenis Transaksi</label>
        <input type="text" value="Barang Keluar" readonly>
    </div>

    <div class="form-group">
        <label>Jumlah Keluar</label>
        <input
            type="number"
            name="jumlah"
            value="1"
            min="1"
            step="1"
            required
        >
    </div>

    <div class="form-group">
        <label>Tujuan</label>
        <input
            type="text"
            name="tujuan"
            required
            placeholder="Contoh: Distribusi ke bagian produksi"
        >
    </div>

    <button type="submit">Simpan Barang Keluar</button>

</form>
<p>
    <a href="/Sistem-Manajemen-Gudang-/public/transaksi/barang-keluar">
        Lihat Daftar Barang Keluar
    </a>
</p>
