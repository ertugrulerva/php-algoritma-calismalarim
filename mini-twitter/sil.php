<?php
require_once 'baglan.php';

// Güvenlik: Yaka kartı yoksa kov!
if(!isset($_SESSION['kullanici_id'])) {
    header("Location: giris.php");
    exit;
}

// Eğer URL'de bir "id" geldiyse işlemi başlat
if(isset($_GET['id'])) {
    $silinecek_id = $_GET['id'];
    $aktif_kullanici = $_SESSION['kullanici_id'];

    // ARKA PLAN GÜVENLİĞİ: Sadece "gönderi id'si şu olanı sil" DEMİYORUZ!
    // "Gönderi id'si şu olan VE sahibi şu anki kullanıcı olan" gönderiyi sil diyoruz! (Çifte güvenlik)
    $sil = $db->prepare("DELETE FROM gonderiler WHERE id = ? AND kullanici_id = ?");
    $sil->execute([$silinecek_id, $aktif_kullanici]);
}

// İşlem bitince hemen ana sayfaya geri dön
header("Location: index.php");
exit;
?>