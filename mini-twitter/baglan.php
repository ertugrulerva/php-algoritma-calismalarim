<?php
// Hafızayı (Oturumları) en baştan başlatıyoruz ki ileride giriş yapınca herkesin yaka kartını takabilelim
session_start();

$host = 'localhost';
$dbname = 'minitwitter_db'; // Yeni veritabanımızın adı
$kullanici = 'root';
$sifre = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $kullanici, $sifre);
    // Hataları daha net görebilmek için ayar yapıyoruz
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Bağlantı Hatası: " . $e->getMessage();
    exit;
}
?>