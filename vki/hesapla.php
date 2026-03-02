<?php
// hesapla.php - Sadece veriyi alır, hesaplar ve geri fırlatır.

// 1. AJAX'tan gelen POST verilerini yakalayalım
$kilo = $_POST['kilo'];
$boy = $_POST['boy'];

// 2. Boy cm olarak gelecek (örn: 180). Matematiği doğru yapmak için metreye (1.80) çeviriyoruz.
$boyMetre = $boy / 100;

// 3. Vücut Kitle İndeksi Formülü
$vki = $kilo / ($boyMetre * $boyMetre);

// Çıkan küsuratlı sayıyı (örn: 24.5678) yuvarlıyoruz ki şık dursun
$vki = round($vki, 1); 

// 4. Durumu belirliyoruz
$durum = "";
if ($vki < 18.5) {
    $durum = "Zayıf";
} elseif ($vki >= 18.5 && $vki <= 24.9) {
    $durum = "Normal Kilo";
} elseif ($vki >= 25 && $vki <= 29.9) {
    $durum = "Fazla Kilolu";
} else {
    $durum = "Obez";
}

// 5. SONUÇ PAKETLEME (EN ÖNEMLİ KISIM)
// PHP ve JavaScript farklı dillerdir. Anlaşabilmeleri için sonucu "JSON" formatına (evrensel kargo kutusuna) çevirip gönderiyoruz.
$cevap = [
    "indeks_skoru" => $vki,
    "saglik_durumu" => $durum
];

echo json_encode($cevap);
?>