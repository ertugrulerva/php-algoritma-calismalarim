<?php
// Müşterinin sepetini aklımızda tutmak için hafızayı başlatıyoruz!
session_start(); 

$host = "localhost";
$veritabani_adi = "mini_eticaret";
$kullanici_adi = "root";
$sifre = "";

try {
    $db = new PDO("mysql:host=$host;dbname=$veritabani_adi;charset=utf8", $kullanici_adi, $sifre);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $hata) {
    echo "Kasa bağlantı hatası: " . $hata->getMessage();
    exit;
}
?>