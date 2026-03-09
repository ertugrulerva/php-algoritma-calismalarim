<?php
// 1. Kasayı aç
require_once 'baglan.php';

// 2. Kuryeden gelen ID var mı kontrol et
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // 3. SİHİRLİ GÜNCELLEME KOMUTU (UPDATE)
    // Mantık: durum = 1 - durum
    // Eğer durum 0 ise: 1 - 0 = 1 olur (Yapıldı)
    // Eğer durum 1 ise: 1 - 1 = 0 olur (Geri alındı)
    $sorgu = $db->prepare("UPDATE gorevler SET durum = 1 - durum WHERE id = ?");
    $guncelle = $sorgu->execute([$id]);

    if ($guncelle) {
        echo "basarili";
    } else {
        echo "hata_olustu";
    }
}
?>