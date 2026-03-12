<?php
// 1. Kasayı aç
require_once 'baglan.php';

// 2. Kamyon (Form) bize geldi mi kontrol et
if (isset($_POST['urun_adi']) && isset($_FILES['resim'])) {
    
    // --- BÖLÜM 1: STANDART YAZILARI TESLİM AL ---
    $urun_adi = $_POST['urun_adi'];
    $fiyat = $_POST['fiyat'];

    // --- BÖLÜM 2: ZIRHLI KAMYONDAN (FILES) RESMİ TESLİM AL ---
    // Resmin orijinal adını al (Örn: kirmizi_tisort.jpg)
    $resim_adi = $_FILES['resim']['name'];
    
    // Resmin geçici olarak bekletildiği yeri al (Bekleme Salonu)
    $resim_gecici_yol = $_FILES['resim']['tmp_name'];
    
    // Aynı isimde iki resim yüklenirse birbirini ezmesin diye resmin adının başına o anki saati/saniyeyi ekliyoruz
    // Örn: 1698754321_kirmizi_tisort.jpg olacak
    $yeni_resim_adi = time() . "_" . $resim_adi; 

    // Resmin kalıcı olarak yerleşeceği bizim fiziksel depomuzun yolu
    $hedef_klasor = "resimler/" . $yeni_resim_adi;

    // --- BÖLÜM 3: RESMİ FİZİKSEL OLARAK TAŞI ---
    // move_uploaded_file: PHP'nin en sihirli komutudur. Resmi "Bekleme Salonundan" alır, bizim "resimler" klasörümüze taşır!
    if (move_uploaded_file($resim_gecici_yol, $hedef_klasor)) {
        
        // --- BÖLÜM 4: VERİTABANINA (KASAYA) KAYDET ---
        // Resim başarıyla klasöre girdiyse, artık veritabanına sadece o resmin "YOLUNU" (Adresini) yazıyoruz.
        $ekle_sorgu = $db->prepare("INSERT INTO urunler (urun_adi, fiyat, resim_url) VALUES (?, ?, ?)");
        $kayit = $ekle_sorgu->execute([$urun_adi, $fiyat, $hedef_klasor]);

        if ($kayit) {
            echo "<h2>Harika! Ürün ve Fotoğrafı Başarıyla Eklendi!</h2>";
            echo "<a href='admin.php'>Yeni Ürün Ekle</a> | <a href='index.php'>Vitrine Git</a>";
        } else {
            echo "Hata: Veritabanına yazılamadı.";
        }

    } else {
        echo "Hata: Resim klasöre yüklenemedi! (resimler klasörünü oluşturduğuna emin ol)";
    }
} else {
    echo "Lütfen formu eksiksiz doldurun.";
}
?>