<?php
// 1. Hafızayı ve Kasayı Aç
//session_start();
require_once 'baglan.php';

// 2. Kurye bize adres bilgilerini getirdi mi ve müşterinin sepeti gerçekten dolu mu?
if (isset($_POST['ad_soyad']) && isset($_POST['adres']) && isset($_SESSION['sepet']) && !empty($_SESSION['sepet'])) {
    
    $ad_soyad = $_POST['ad_soyad'];
    $adres = $_POST['adres'];
    $gercek_toplam_tutar = 0;

    // --- 3. AŞAMA: GÜVENLİ HESAPLAMA (Hacker Koruması) ---
    // JavaScript'ten gelen fiyata ASLA güvenmeyiz. Fiyatı kasadan (veritabanından) bizzat kendimiz çekip tekrar topluyoruz.
    foreach ($_SESSION['sepet'] as $urun_id => $adet) {
        $sorgu = $db->prepare("SELECT fiyat FROM urunler WHERE id = ?");
        $sorgu->execute([$urun_id]);
        $urun = $sorgu->fetch(PDO::FETCH_ASSOC);
        
        if ($urun) {
            $gercek_toplam_tutar += ($urun['fiyat'] * $adet);
        }
    }

    // --- 4. AŞAMA: MUHASEBEYE YAZ (CREATE İşlemi) ---
    // Müşterinin adını, adresini ve bizim hesapladığımız o güvenli tutarı 'siparisler' tablosuna kaydediyoruz.
    $ekle_sorgu = $db->prepare("INSERT INTO siparisler (ad_soyad, adres, toplam_tutar) VALUES (?, ?, ?)");
    $siparis_kaydi = $ekle_sorgu->execute([$ad_soyad, $adres, $gercek_toplam_tutar]);

    if ($siparis_kaydi) {
        
        // --- 5. AŞAMA: MÜŞTERİNİN SEPETİNİ BOŞALT ---
        // Sipariş başarıyla alındığı için artık o ürünlerin sepette durmasına gerek yok. Sepeti yırtıp atıyoruz.
        unset($_SESSION['sepet']);
        
        // Kuryeye sevinçli haberi ver (Bu JavaScript'teki o harika SweetAlert animasyonunu tetikleyecek)
        echo "basarili";
        
    } else {
        echo "hata_veritabani";
    }
} else {
    // Kurye boş geldi veya sepet zaten boş
    echo "hata_eksik_veri";
}
?>