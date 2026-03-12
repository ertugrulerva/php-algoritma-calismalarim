<?php
session_start();

if(isset($_POST['kullanici_adi']) && isset($_POST['sifre'])) {
    
    $gelen_kullanici = $_POST['kullanici_adi'];
    $gelen_sifre = $_POST['sifre'];

    // PATRONUN BİLGİLERİ (Gerçek hayatta burası veritabanından gelir ama şimdilik PHP içine gömüyoruz)
    $dogru_kullanici = "patron";
    $dogru_sifre = "123456";

    // Kuryenin getirdiği şifre ile bizim belirlediğimiz şifre eşleşiyor mu?
    if($gelen_kullanici == $dogru_kullanici && $gelen_sifre == $dogru_sifre) {
        
        // Şifre doğruysa PATRONA YAKA KARTINI TAK!
        $_SESSION['admin_giris'] = true; 
        
        // Yaka kartını taktıktan sonra onu ürünler listesine gönder
        header("Location: admin_urunler.php");
        exit;
        
    } else {
        // Şifre yanlışsa hata mesajıyla tekrar kapıya yolla
        echo "<h1>Hatalı şifre veya kullanıcı adı!</h1>";
        echo "<a href='admin_giris.php'>Geri Dön</a>";
    }
} else {
    header("Location: admin_giris.php");
}
?>