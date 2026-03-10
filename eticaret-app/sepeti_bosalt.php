<?php
// 1. Önce müşterinin hafızasını aç
session_start();

// 2. SADECE SEPETİ SİL (Çok Önemli!)
// unset() komutu, hafızadaki sadece belirttiğimiz çekmeceyi siler, diğerlerine dokunmaz.
if (isset($_SESSION['sepet'])) {
    unset($_SESSION['sepet']);
}

// 3. Müşteriyi tekrar sepet sayfasına geri gönder (Sepetin boşaldığını görsün)
header("Location: sepet.php");
exit;
?>