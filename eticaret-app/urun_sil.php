<?php
// 1. Kasayı aç
require_once 'baglan.php';

// 2. Kurye bize adres çubuğunda (URL) bir 'id' getirdi mi? 
// Not: Linkten (adres çubuğundan) gelen veriler $_POST ile DEĞİL, $_GET ile yakalanır!
if (isset($_GET['id'])) {
    
    $silinecek_id = $_GET['id'];

    // --- AŞAMA 1: ÜRÜNÜN FOTOĞRAFI NEREDE? ---
    // Ürünü silmeden önce kasaya soruyoruz: "Bu ID'ye sahip ürünün resim_url'si nedir?"
    $sorgu = $db->prepare("SELECT resim_url FROM urunler WHERE id = ?");
    $sorgu->execute([$silinecek_id]);
    $urun = $sorgu->fetch(PDO::FETCH_ASSOC);

    // Eğer kasa böyle bir ürün bulduysa işlemlere başla
    if ($urun) {
        
        $resim_yolu = $urun['resim_url']; // Örn: resimler/169875_tisort.jpg
        
        // --- AŞAMA 2: FİZİKSEL FOTOĞRAFI ÇÖPE AT ---
        // file_exists(): "Klasörde gerçekten böyle bir dosya var mı?" diye kontrol eder.
        // unlink(): PHP'nin silgi komutudur. Belirtilen dosyayı bilgisayardan kalıcı olarak siler!
        if (file_exists($resim_yolu)) {
            unlink($resim_yolu); 
        }

        // --- AŞAMA 3: KASADAN (VERİTABANINDAN) KAYDI SİL ---
        $sil_sorgu = $db->prepare("DELETE FROM urunler WHERE id = ?");
        $sil_sorgu->execute([$silinecek_id]);

        // --- AŞAMA 4: PATRONU LİSTEYE GERİ GÖNDER ---
        // İşlem bittikten sonra bu beyaz sayfada kalmasın, otomatik olarak tabloya dönsün.
        header("Location: admin_urunler.php");
        exit;
        
    } else {
        echo "Hata: Kasada böyle bir ürün zaten yok!";
    }
    
} else {
    // Sayfaya direkt elle /urun_sil.php yazıp girmeye çalışanlara verilecek cevap
    echo "Hata: Silinecek bir ürün ID'si göndermediniz.";
}
?>