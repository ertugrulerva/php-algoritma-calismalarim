<?php
// 1. Kasayı ve Oturum sistemini açıyoruz
require_once 'baglan.php';

// 2. Kurye bize gerçekten bir e-posta getirdi mi? (Güvenlik kontrolü)
if (isset($_POST['email'])) {
    
    // Kuryedeki paketleri alıp kendi değişkenlerimize atıyoruz
    $ad_soyad = $_POST['ad_soyad'];
    $email = $_POST['email'];
    $gelen_sifre = $_POST['sifre'];

    // --- 1. AŞAMA: E-POSTA KONTROLÜ ---
    // Kasaya soruyoruz: "Bu e-posta adresiyle daha önce kayıt olan biri var mı?"
    $kontrol_sorgu = $db->prepare("SELECT id FROM kullanicilar WHERE email = ?");
    $kontrol_sorgu->execute([$email]);

    // rowCount(): Bulunan satır sayısını sayar. Eğer 0'dan büyükse, bu e-posta zaten var demektir!
    if ($kontrol_sorgu->rowCount() > 0) {
        
        echo "var"; // JavaScript'teki o Swal.fire('Hata!', 'Bu e-posta zaten kullanılıyor') kısmını tetikler.
        
    } else {
        
        // --- 2. AŞAMA: KRİPTOGRAFİ (ŞİFRELEME) ---
        // password_hash(): PHP'nin en güçlü şifreleme silahıdır. 
        // PASSWORD_DEFAULT: En güncel ve kırılamaz algoritmayı (şu an bcrypt) otomatik seçer.
        $kriptolu_sifre = password_hash($gelen_sifre, PASSWORD_DEFAULT);

        // --- 3. AŞAMA: KASAYA KAYDETME (CREATE) ---
        // Dikkat: Kasaya $gelen_sifre'yi değil, $kriptolu_sifre'yi kaydediyoruz!
        $ekle_sorgu = $db->prepare("INSERT INTO kullanicilar (ad_soyad, email, sifre) VALUES (?, ?, ?)");
        $kayit_islemi = $ekle_sorgu->execute([$ad_soyad, $email, $kriptolu_sifre]);

        // İşlem bittiyse kuryeye haberi verelim
        if ($kayit_islemi) {
            echo "basarili"; // SweetAlert2'nin o yeşil tikli harika animasyonunu tetikler!
        } else {
            echo "Hata oluştu, veritabanına yazılamadı.";
        }
    }
}
?>