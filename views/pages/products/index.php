<h2>Data Stok Barang & Reorder Point</h2>

<table>
    <thead>
        <tr>
            <th>Barcode</th>
            <th>Nama Barang</th>
            <th>Rak Saat Ini</th>
            <th>Stok</th>
            <th>Min. Stok</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <?php 
                    $is_reorder = $product['stok'] <= $product['min_stok'];
                    $row_class = $is_reorder ? "warning-stock" : "";
                ?>
                <tr class="<?= $row_class ?>">
                    <td><?= htmlspecialchars($product['barcode']) ?></td>
                    <td><?= htmlspecialchars($product['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($product['rak']) ?></td>
                    <td><?= $product['stok'] ?></td>
                    <td><?= $product['min_stok'] ?></td>
                    <td>
                        <?php if ($is_reorder): ?>
                            <span class="badge danger">⚠️ Reorder Segera!</span>
                        <?php else: ?>
                            <span class="badge success">Aman</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align: center;">Belum ada data barang.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>