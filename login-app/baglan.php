<?php
// DÜNYANIN EN ÖNEMLİ KODU (Giriş sistemleri için)
// session_start() php'ye şunu der: "Bu siteye giren kişiye görünmez bir yaka kartı ver. Sayfalar arası gezerken onu tanıyacağım!"
session_start(); 

$host = "localhost";
$veritabani_adi = "kullanici_sistemi"; // Yeni kasamızın adı
$kullanici_adi = "root";
$sifre = "";

try {
    $db = new PDO("mysql:host=$host;dbname=$veritabani_adi;charset=utf8", $kullanici_adi, $sifre);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $hata) {
    echo "Kasa bağlantı hatası: " . $hata->getMessage();
    // Bağlantı koparsa sayfanın geri kalanını yükleme, durdur:
    exit; 
}
?>