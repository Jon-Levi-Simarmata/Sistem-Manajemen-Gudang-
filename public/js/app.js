// 1. Tampilkan form Rak Tujuan jika jenis transaksi mutasi
function toggleMutasi() {
    var action = document.getElementById('action').value;
    var rakGroup = document.getElementById('rakTujuanGroup');
    if (rakGroup) {
        if (action === 'mutasi') {
            rakGroup.style.display = 'block';
        } else {
            rakGroup.style.display = 'none';
        }
    }
}

// 2. Callback Scanner Barcode via Kamera HP
function onScanSuccess(decodedText, decodedResult) {
    let barcodeInput = document.getElementById('barcode');
    if (barcodeInput) {
        barcodeInput.value = decodedText;
        barcodeInput.style.backgroundColor = '#dcfce7';
        setTimeout(() => {
            barcodeInput.style.backgroundColor = '#fff';
        }, 500);
    }
    console.log(`Barcode terdeteksi: ${decodedText}`);
}

function onScanFailure(error) {
    // Abaikan error fokus kamera
}

// 3. Inisialisasi Scanner Kamera jika ada div #reader
if (document.getElementById('reader')) {
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", 
        { fps: 10, qrbox: { width: 250, height: 150 } }, 
        false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
}