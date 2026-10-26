
"use strict";

document.addEventListener("DOMContentLoaded", function () {
    const ambil = (id) => document.getElementById(id);

    const formBarang = ambil("formBarang");
    const daftarBarang = ambil("daftarBarang");
    const cariBarang = ambil("cariBarang");
    const pesan = ambil("pesan");
    const jumlahData = ambil("jumlahData");

    const totalProduk = ambil("totalProduk");
    const totalStok = ambil("totalStok");
    const stokMenipis = ambil("stokMenipis");
    const totalRak = ambil("totalRak");

    const formMasuk = ambil("formMasuk");
    const formKeluar = ambil("formKeluar");
    const formMutasi = ambil("formMutasi");
    const formOpname = ambil("formOpname");
    const daftarRiwayat = ambil("daftarRiwayat");
    const hasilOpname = ambil("hasilOpname");

    const kunciBarang = "gudangKelompokBarangV1";
    const kunciRiwayat = "gudangKelompokRiwayatV1";

    function bacaPenyimpanan(kunci) {
        try {
            const data = JSON.parse(localStorage.getItem(kunci) || "[]");
            return Array.isArray(data) ? data : [];
        } catch (error) {
            return [];
        }
    }

    let barang = bacaPenyimpanan(kunciBarang);
    let riwayat = bacaPenyimpanan(kunciRiwayat);

    function simpan(kunci, data) {
        try {
            localStorage.setItem(kunci, JSON.stringify(data));
            return true;
        } catch (error) {
            pesan.textContent =
                "Penyimpanan browser gagal. Periksa pengaturan browser.";
            return false;
        }
    }

    function cariData(barcode) {
        const kode = barcode.trim().toLowerCase();
        return barang.find(
            (item) => item.barcode.toLowerCase() === kode
        );
    }

    function catat(jenis, item, keterangan, jumlah) {
        riwayat.unshift({
            waktu: new Date().toLocaleString("id-ID"),
            jenis: jenis,
            barcode: item.barcode,
            keterangan: keterangan,
            jumlah: jumlah
        });

        // Simpan riwayat maksimal 200 transaksi.
        riwayat = riwayat.slice(0, 200);
        simpan(kunciRiwayat, riwayat);
        tampilkanRiwayat();
    }

    function buatSel(baris, teks) {
        const sel = document.createElement("td");
        sel.textContent = teks;
        baris.appendChild(sel);
        return sel;
    }

    function tampilkanBarang() {
        const kata = cariBarang.value.trim().toLowerCase();

        const hasil = barang.filter((item) =>
            item.barcode.toLowerCase().includes(kata) ||
            item.nama.toLowerCase().includes(kata)
        );

        daftarBarang.replaceChildren();

        if (hasil.length === 0) {
            const baris = document.createElement("tr");
            const sel = document.createElement("td");

            sel.colSpan = 8;
            sel.textContent = barang.length === 0
                ? "Belum ada data barang."
                : "Barang tidak ditemukan.";

            baris.appendChild(sel);
            daftarBarang.appendChild(baris);
        }

        hasil.forEach((item, index) => {
            const baris = document.createElement("tr");

            buatSel(baris, String(index + 1));
            buatSel(baris, item.barcode);
            buatSel(baris, item.nama);
            buatSel(baris, String(item.stok));
            buatSel(baris, String(item.minimum));
            buatSel(baris, item.rak);

            const selStatus = buatSel(baris, "");
            const label = document.createElement("span");

            if (item.stok <= item.minimum) {
                label.textContent = "Minimum";
                label.className = "status status-minimum";
            } else {
                label.textContent = "Aman";
                label.className = "status status-aman";
            }

            selStatus.appendChild(label);

            const selAksi = buatSel(baris, "");
            const tombol = document.createElement("button");

            tombol.type = "button";
            tombol.className = "btn-hapus";
            tombol.textContent = "Hapus";

            tombol.addEventListener("click", function () {
                if (!confirm("Hapus barang " + item.nama + "?")) {
                    return;
                }

                const sebelumnya = barang;
                barang = barang.filter(
                    (data) => data.barcode !== item.barcode
                );

                if (!simpan(kunciBarang, barang)) {
                    barang = sebelumnya;
                    tampilkanBarang();
                    return;
                }

                catat("Hapus", item, "Barang dihapus", item.stok);
                pesan.textContent = "Barang berhasil dihapus.";
                tampilkanBarang();
            });

            selAksi.appendChild(tombol);
            daftarBarang.appendChild(baris);
        });

        totalProduk.textContent = String(barang.length);
        totalStok.textContent = String(
            barang.reduce((total, item) => total + item.stok, 0)
        );
        stokMenipis.textContent = String(
            barang.filter((item) => item.stok <= item.minimum).length
        );
        totalRak.textContent = String(
            new Set(barang.map((item) => item.rak)).size
        );
        jumlahData.textContent = "Total: " + barang.length + " jenis barang";
    }

    function tampilkanRiwayat() {
        daftarRiwayat.replaceChildren();

        if (riwayat.length === 0) {
            const baris = document.createElement("tr");
            const sel = document.createElement("td");
            sel.colSpan = 5;
            sel.textContent = "Belum ada transaksi.";
            baris.appendChild(sel);
            daftarRiwayat.appendChild(baris);
            return;
        }

        riwayat.forEach((transaksi) => {
            const baris = document.createElement("tr");
            buatSel(baris, transaksi.waktu);
            buatSel(baris, transaksi.jenis);
            buatSel(baris, transaksi.barcode);
            buatSel(baris, transaksi.keterangan);
            buatSel(baris, String(transaksi.jumlah));
            daftarRiwayat.appendChild(baris);
        });
    }

    formBarang.addEventListener("submit", function (event) {
        event.preventDefault();

        const barcode = ambil("barcode").value.trim();
        const nama = ambil("namaBarang").value.trim();
        const stok = Number(ambil("stokAwal").value);
        const minimum = Number(ambil("stokMinimum").value);
        const rak = ambil("rakBarang").value.trim();

        if (!barcode || !nama || !rak) {
            pesan.textContent = "Lengkapi semua kolom barang.";
            return;
        }

        if (
            !Number.isSafeInteger(stok) || stok < 0 ||
            !Number.isSafeInteger(minimum) || minimum < 0
        ) {
            pesan.textContent = "Stok harus bilangan bulat minimal 0.";
            return;
        }

        if (cariData(barcode)) {
            pesan.textContent = "Barcode sudah terdaftar.";
            return;
        }

        const item = { barcode, nama, stok, minimum, rak };
        barang.push(item);

        if (!simpan(kunciBarang, barang)) {
            barang.pop();
            return;
        }

        catat("Tambah", item, "Barang baru ditambahkan", stok);
        formBarang.reset();
        pesan.textContent = "Barang berhasil ditambahkan!";
        tampilkanBarang();
    });

    cariBarang.addEventListener("input", tampilkanBarang);

    formMasuk.addEventListener("submit", function (event) {
        event.preventDefault();

        const item = cariData(ambil("barcodeMasuk").value);
        const jumlah = Number(ambil("jumlahMasuk").value);
        const supplier = ambil("supplier").value.trim();

        if (!item) {
            pesan.textContent = "Barcode barang masuk tidak ditemukan.";
            return;
        }

        if (!Number.isSafeInteger(jumlah) || jumlah <= 0 || !supplier) {
            pesan.textContent = "Isi jumlah masuk dan supplier dengan benar.";
            return;
        }

        const stokLama = item.stok;
        item.stok += jumlah;

        if (!simpan(kunciBarang, barang)) {
            item.stok = stokLama;
            return;
        }

        catat("Barang Masuk", item, supplier, jumlah);
        formMasuk.reset();
        pesan.textContent = "Barang masuk berhasil dicatat.";
        tampilkanBarang();
    });

    formKeluar.addEventListener("submit", function (event) {
        event.preventDefault();

        const item = cariData(ambil("barcodeKeluar").value);
        const jumlah = Number(ambil("jumlahKeluar").value);
        const tujuan = ambil("tujuan").value.trim();

        if (!item) {
            pesan.textContent = "Barcode barang keluar tidak ditemukan.";
            return;
        }

        if (!Number.isSafeInteger(jumlah) || jumlah <= 0 || !tujuan) {
            pesan.textContent = "Isi jumlah keluar dan tujuan dengan benar.";
            return;
        }

        if (jumlah > item.stok) {
            pesan.textContent = "Stok tidak mencukupi.";
            return;
        }

        const stokLama = item.stok;
        item.stok -= jumlah;

        if (!simpan(kunciBarang, barang)) {
            item.stok = stokLama;
            return;
        }

        catat("Barang Keluar", item, tujuan, -jumlah);
        formKeluar.reset();
        pesan.textContent = "Barang keluar berhasil dicatat.";
        tampilkanBarang();
    });

    formMutasi.addEventListener("submit", function (event) {
        event.preventDefault();

        const item = cariData(ambil("barcodeMutasi").value);
        const rakBaru = ambil("rakTujuan").value.trim();

        if (!item) {
            pesan.textContent = "Barcode barang tidak ditemukan.";
            return;
        }

        if (!rakBaru) {
            pesan.textContent = "Masukkan rak tujuan.";
            return;
        }

        const rakLama = item.rak;
        item.rak = rakBaru;

        if (!simpan(kunciBarang, barang)) {
            item.rak = rakLama;
            return;
        }

        catat("Mutasi Rak", item, rakLama + " → " + rakBaru, 0);
        formMutasi.reset();
        pesan.textContent = "Lokasi rak berhasil dipindahkan.";
        tampilkanBarang();
    });

    formOpname.addEventListener("submit", function (event) {
        event.preventDefault();

        const item = cariData(ambil("barcodeOpname").value);
        const fisik = Number(ambil("stokFisik").value);

        if (!item) {
            hasilOpname.textContent = "Barcode barang tidak ditemukan.";
            return;
        }

        if (
            ambil("stokFisik").value === "" ||
            !Number.isSafeInteger(fisik) || fisik < 0
        ) {
            hasilOpname.textContent =
                "Stok fisik harus bilangan bulat minimal 0.";
            return;
        }

        const stokLama = item.stok;
        const selisih = fisik - stokLama;
        item.stok = fisik;

        if (!simpan(kunciBarang, barang)) {
            item.stok = stokLama;
            return;
        }

        catat("Stock Opname", item,
            "Stok sistem " + stokLama + ", stok fisik " + fisik,
            selisih);

        hasilOpname.textContent =
            "Opname selesai. Selisih stok: " + selisih + ".";
        formOpname.reset();
        tampilkanBarang();
    });

    tampilkanBarang();
    tampilkanRiwayat();
});
