<?php
// 1. Kasa Bilgileri (Kilit Ayarları)
$host = "localhost"; // Kasa nerede duruyor? (Kendi bilgisayarımızda)
$veritabani_adi = "todo_projesi"; // Az önce phpMyAdmin'de verdiğimiz isim
$kullanici_adi = "root"; // XAMPP'ın varsayılan kasa görevlisi (kullanıcı) adıdır
$sifre = ""; // XAMPP'ta varsayılan olarak şifre yoktur, boş bırakılır

// 2. Bağlantı Denemesi (Try - Catch Bloğu)
try {
    // PDO (PHP Data Objects): Modern ve en güvenli veritabanı bağlanma yöntemidir.
    $db = new PDO("mysql:host=$host;dbname=$veritabani_adi;charset=utf8", $kullanici_adi, $sifre);
    
    // Eğer bir hata yaparsak PHP'nin hatayı gizlemeyip bize detaylıca söylemesini istiyoruz:
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test için ekrana yazdırıyoruz (Sonra bu satırı sileceğiz)
    //echo "Harika! Veritabanına başarıyla bağlandık.";

} catch (PDOException $hata) {
    // Eğer şifre veya veritabanı adı yanlışsa, sistem çökmesin diye hatayı burada yakalıyoruz.
    echo "Maalesef kasaya bağlanılamadı. Hata şudur: " . $hata->getMessage();
}
?>