<?php
// 1. Kasayı ve Oturum sistemini (session_start) açıyoruz
require_once 'baglan.php';

// 2. Kurye bize e-posta ve şifre getirdi mi?
if (isset($_POST['email']) && isset($_POST['sifre'])) {
    
    $gelen_email = $_POST['email'];
    $gelen_sifre = $_POST['sifre'];

    // 3. AŞAMA: KASADA BU E-POSTAYI ARA
    // Kasaya diyoruz ki: "Bana bu e-postaya sahip olan adamın TÜM bilgilerini (id, ad_soyad, sifre) getir."
    $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE email = ?");
    $sorgu->execute([$gelen_email]);
    
    // Gelen adamın verilerini bir dizi olarak ($kullanici) yakala
    $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

    // 4. AŞAMA: KULLANICI VAR MI VE ŞİFRESİ DOĞRU MU?
    // Eğer böyle bir e-posta varsa ($kullanici boş değilse)
    if ($kullanici) {
        
        // SİHİRLİ KOMUT: password_verify()
        // Kullanıcının yazdığı "123456" ile kasadaki "$2y$10$..." metnini karşılaştırır. Eşleşirse TRUE (Doğru) döndürür.
        if (password_verify($gelen_sifre, $kullanici['sifre'])) {
            
            // --- GİRİŞ BAŞARILI! YAKA KARTINI TAKIYORUZ ---
            // $_SESSION (Oturum) bizim görünmez hafızamızdır.
            // Bu adamın ID'sini ve Adını bu hafızaya yazıyoruz ki diğer sayfalarda onu tanıyalım!
            $_SESSION['kullanici_id'] = $kullanici['id'];
            $_SESSION['ad_soyad'] = $kullanici['ad_soyad'];
            
            // Kuryeye sevinçli haberi ver (Bu kelime JS'deki SweetAlert'i tetikleyecek)
            echo "basarili";
            
        } else {
            // E-posta var ama şifre yanlış!
            echo "hata";
        }
        
    } else {
        // Kasada böyle bir e-posta hiç yok!
        echo "hata";
    }
}
?>