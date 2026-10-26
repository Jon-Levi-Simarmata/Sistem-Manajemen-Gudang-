
<h2>Daftar Barang Keluar</h2>

<p>Berikut adalah daftar transaksi barang keluar dari gudang.</p>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Barcode Barang</th>
            <th>Jumlah Keluar</th>
            <th>Tujuan</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($transaksi)): ?>
            <?php foreach ($transaksi as $item): ?>
                <tr>
                    <td><?= htmlspecialchars((string) ($item['id'] ?? '')) ?></td>
                    <td><?= htmlspecialchars((string) ($item['barcode'] ?? '')) ?></td>
                    <td><?= htmlspecialchars((string) ($item['jumlah'] ?? '')) ?></td>
                    <td><?= htmlspecialchars((string) ($item['tujuan'] ?? '')) ?></td>
                    
                    
                    <td>
                        <details>
                            <summary>Edit</summary>

                            <form method="POST"
                                action="/Sistem-Manajemen-Gudang-/public/transaksi/update">

                                <input type="hidden" name="id"
                                    value="<?= htmlspecialchars((string) ($item['id'] ?? '')) ?>">

                                <label>Barcode Barang</label>
                                <input type="text" name="barcode"
                                    value="<?= htmlspecialchars((string) ($item['barcode'] ?? '')) ?>"
                                    required>

                                <label>Jumlah Keluar</label>
                                <input type="number" name="jumlah"
                                    value="<?= htmlspecialchars((string) ($item['jumlah'] ?? '')) ?>"
                                    min="1" required>

                                <label>Tujuan</label>
                                <input type="text" name="tujuan"
                                    value="<?= htmlspecialchars((string) ($item['tujuan'] ?? '')) ?>"
                                    required>

                                <button type="submit">Simpan Perubahan</button>
                            </form>
                        </details>

                        <form method="POST"
                            action="/Sistem-Manajemen-Gudang-/public/transaksi/delete"
                            onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">

                            <input type="hidden" name="id"
                                value="<?= htmlspecialchars((string) ($item['id'] ?? '')) ?>">

                            <button type="submit">Hapus</button>
                        </form>
                    </td>


                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Belum ada data transaksi barang keluar.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
