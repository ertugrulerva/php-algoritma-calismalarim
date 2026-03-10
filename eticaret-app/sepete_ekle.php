<?php
// 1. Önce müşterinin hafızasını (yaka kartını) açıyoruz
session_start();

// 2. Kurye bize bir ürün ID'si getirdi mi?
if (isset($_POST['id'])) {
    $gelen_id = $_POST['id'];

    // 3. HAFIZADA SEPET VAR MI?
    // Eğer müşterinin hafızasında 'sepet' adında bir bölüm yoksa, ona boş bir sepet (dizi) veriyoruz.
    if (!isset($_SESSION['sepet'])) {
        $_SESSION['sepet'] = [];
    }

    // 4. ÜRÜN SEPETTE ZATEN VAR MI?
    // Eğer bu üründen sepette varsa, sayısını 1 artır. Yoksa ilk defa ekleniyordur, sayısını 1 yap.
    if (isset($_SESSION['sepet'][$gelen_id])) {
        $_SESSION['sepet'][$gelen_id]++; // Miktarını artır
    } else {
        $_SESSION['sepet'][$gelen_id] = 1; // İlk defa sepete atıldı
    }

    // 5. SEPETTE TOPLAM KAÇ EŞYA OLDU?
    // array_sum(): Sepetin içindeki tüm miktarları (3 tişört, 1 klavye = 4) otomatik toplar.
    $toplam_sayi = array_sum($_SESSION['sepet']);

    // Kuryeye toplam sayıyı verip JavaScript'e geri gönderiyoruz
    echo $toplam_sayi;
}
?>