<h2>Scan Barcode & Transaksi Gudang</h2>

<!-- Area Kamera Scanner -->
<div id="reader"></div>

<form method="POST" action="/transaksi/store">
    <div class="form-group">
        <label>Barcode Barang</label>
        <input type="text" id="barcode" name="barcode" required placeholder="Arahkan kamera ke barcode atau ketik manual...">
    </div>

    <div class="form-group">
        <label>Jenis Transaksi</label>
        <select name="action" id="action" onchange="toggleMutasi()">
            <option value="masuk">Barang Masuk (Pembelian Supplier)</option>
            <option value="keluar">Barang Keluar (Distribusi)</option>
            <option value="mutasi">Mutasi Antar Rak</option>
        </select>
    </div>

    <div class="form-group" id="rakTujuanGroup" style="display:none;">
        <label>Rak Tujuan Baru</label>
        <input type="text" name="rak_tujuan" placeholder="Contoh: Rak C3">
    </div>

    <div class="form-group">
        <label>Jumlah</label>
        <input type="number" name="jumlah" value="1" min="1" required>
    </div>

    <button type="submit">Proses Transaksi</button>
</form>