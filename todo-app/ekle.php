<?php
// 1. Kasayı açalım (Bağlantı dosyamızı çağırıyoruz)
require_once 'baglan.php';

// 2. AJAX kuryesinden (JavaScript'ten) gelen POST verisi var mı diye kontrol edelim
if (isset($_POST['gorev_adi'])) {
    
    // Kuryeden paketi (yazıyı) teslim alalım
    $gorev = $_POST['gorev_adi'];

    // 3. GÜVENLİK ZIRHI: SQL Komutunu Hazırlama (Prepare)
    // "INSERT INTO" komutu veritabanına yeni satır eklemek içindir.
    // DİKKAT: Değişkeni ($gorev) direkt kodun içine yazmıyoruz! Yerine "?" (soru işareti) koyuyoruz.
    $sorgu = $db->prepare("INSERT INTO gorevler (gorev_adi) VALUES (?)");

    // 4. Komutu çalıştır (Execute) ve soru işaretinin yerine kuryeden gelen paketi yerleştir
    $ekle = $sorgu->execute([$gorev]);

    // 5. İşlem bitti! Kuryeye geri dönüş (cevap) verelim
    if ($ekle) {
        echo "basarili"; // İşlem tamamsa JS'ye bu metni fırlat
    } else {
        echo "hata_olustu";
    }
}
?>