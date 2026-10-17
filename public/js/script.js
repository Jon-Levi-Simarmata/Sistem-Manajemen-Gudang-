// 1. Fungsi untuk menampilkan/menyembunyikan input Rak Tujuan
function toggleMutasi() {
    var action = document.getElementById('action').value;
    var rakGroup = document.getElementById('rakTujuanGroup');
    if (action === 'mutasi') {
        rakGroup.style.display = 'block';
    } else {
        rakGroup.style.display = 'none';
    }
}

// 2. Fungsi untuk menangani hasil scan barcode via kamera
function onScanSuccess(decodedText, decodedResult) {
    // Masukkan hasil bacaan barcode kamera secara otomatis ke dalam input text
    document.getElementById('barcode').value = decodedText;
    console.log(`Barcode terdeteksi: ${decodedText}`);
}

function onScanFailure(error) {
    // Menangani error kecil saat kamera mencari fokus barcode
}

// Inisialisasi library Html5QrcodeScanner
let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", 
    { fps: 10, qrbox: { width: 250, height: 150 } }, 
    false
);
html5QrcodeScanner.render(onScanSuccess, onScanFailure);