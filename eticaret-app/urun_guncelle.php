<?php
// 1. Kasayı aç
require_once 'baglan.php';

// 2. Kamyon (Form) geldi mi? İçinde 'id' var mı?
if (isset($_POST['id'])) {
    
    // Zarfın (POST) içindeki yazıları teslim alıyoruz
    $id = $_POST['id'];
    $urun_adi = $_POST['urun_adi'];
    $fiyat = $_POST['fiyat'];
    $eski_resim_url = $_POST['eski_resim_url']; // O gizli kutuya sakladığımız eski resmin yolu!

    // Başlangıçta "Güncel Resim", eski resim olarak kabul edilsin.
    $guncel_resim_yolu = $eski_resim_url; 

    // --- SİHİRLİ KARAR ANI: Patron yeni resim yükledi mi? ---
    // $_FILES['resim']['name'] boş değilse, demek ki kamyonda yeni bir dosya var!
    if (isset($_FILES['resim']) && $_FILES['resim']['name'] != "") {
        
        // 1. Yeni resmi teslim al ve adını değiştir (Saat ekle)
        $yeni_resim_adi = time() . "_" . $_FILES['resim']['name'];
        $resim_gecici_yol = $_FILES['resim']['tmp_name'];
        $hedef_klasor = "resimler/" . $yeni_resim_adi;

        // 2. Yeni resmi fiziksel olarak klasörümüze taşı
        if (move_uploaded_file($resim_gecici_yol, $hedef_klasor)) {
            
            // 3. YENİ RESİM YÜKLENDİĞİ İÇİN, ESKİ RESMİ FİZİKSEL OLARAK ÇÖPE AT!
            // unlink() ile o gizli kutudan gelen eski resmi siliyoruz ki klasörümüz çöplüğe dönmesin.
            if (file_exists($eski_resim_url)) {
                unlink($eski_resim_url);
            }
            
            // 4. Güncel resim yolumuzu artık "yeni yüklenen resim" olarak değiştiriyoruz.
            $guncel_resim_yolu = $hedef_klasor;
        }
    }

    // --- KASAYI (VERİTABANINI) GÜNCELLEME VAKTİ ---
    // UPDATE komutu, var olan bir satırın üzerine yazar. WHERE id = ? çok önemlidir, yoksa dükkandaki tüm ürünler değişir!
    $guncelle_sorgu = $db->prepare("UPDATE urunler SET urun_adi = ?, fiyat = ?, resim_url = ? WHERE id = ?");
    $islem = $guncelle_sorgu->execute([$urun_adi, $fiyat, $guncel_resim_yolu, $id]);

    // İşlem bittikten sonra patronu tekrar ürün listesine fırlat!
    if ($islem) {
        header("Location: admin_urunler.php");
        exit;
    } else {
        echo "Hata: Güncelleme sırasında bir sorun oluştu.";
    }

} else {
    echo "Hata: Eksik bilgi gönderdiniz.";
}
?>