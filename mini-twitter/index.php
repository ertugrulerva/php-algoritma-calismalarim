<?php
// 1. Veritabanı ve Hafıza
require_once 'baglan.php';

// 2. GÜVENLİK DUVARI: Yaka kartı (Session) olmayan giremez!
if(!isset($_SESSION['kullanici_id'])) {
    header("Location: giris.php");
    exit;
}

// O an giriş yapmış olan kişinin bilgilerini hafızadan alıyoruz
$aktif_kullanici_id = $_SESSION['kullanici_id'];
$aktif_kullanici_adi = $_SESSION['kullanici_adi'];

// 3. YENİ GÖNDERİ PAYLAŞMA İŞLEMİ (Form POST edildiyse)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['icerik'])) {
    $icerik = trim($_POST['icerik']);

    if (!empty($icerik)) {
        // Gönderiyi veritabanına ekle. DİKKAT: kullanici_id sütununa Session'daki ID'mizi yazıyoruz!
        $ekle = $db->prepare("INSERT INTO gonderiler (kullanici_id, icerik) VALUES (?, ?)");
        $ekle->execute([$aktif_kullanici_id, $icerik]);
        
        // Sayfayı yenile ki yeni gönderi anında aşağıda listelensin (F5 sorunu olmasın)
        header("Location: index.php");
        exit;
    }
}

// 4. İLİŞKİSEL VERİTABANI SİHRİ (INNER JOIN): Tüm gönderileri sahiplerinin isimleriyle çek!
// Kurgu: Gönderiler tablosundaki her satır için, o satırdaki 'kullanici_id' ile 'kullanicilar' tablosundaki 'id'yi eşleştir.
$sorgu = $db->query("
    SELECT gonderiler.id, gonderiler.kullanici_id, gonderiler.icerik, gonderiler.tarih, kullanicilar.kullanici_adi 
    FROM gonderiler 
    INNER JOIN kullanicilar ON gonderiler.kullanici_id = kullanicilar.id 
    ORDER BY gonderiler.id DESC
");
$tum_gonderiler = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Mini Twitter - Ana Sayfa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">🐦 Mini Twitter</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Merhaba, <strong><?php echo $aktif_kullanici_adi; ?></strong></span>
                <a href="cikis.php" class="btn btn-danger btn-sm">Çıkış Yap</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <div class="card shadow-sm border-0 mb-4 rounded-4">
                    <div class="card-body p-3">
                        <form method="POST">
                            <div class="mb-2">
                                <textarea name="icerik" class="form-control border-0 bg-light" rows="3" placeholder="Neler düşünüyorsun?" required style="resize: none;"></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Paylaş</button>
                            </div>
                        </form>
                    </div>
                </div>

                <h5 class="text-muted mb-3">Son Gönderiler</h5>

                <?php if(count($tum_gonderiler) > 0): ?>
                    <?php foreach($tum_gonderiler as $gonderi): ?>
                        <div class="card shadow-sm border-0 mb-3 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-primary fw-bold mb-1">@<?php echo $gonderi['kullanici_adi']; ?></h6>
                                <p class="mb-2 text-dark fs-5"><?php echo htmlspecialchars($gonderi['icerik']); ?></p>
                                <small class="text-muted"><?php echo date('d.m.Y H:i', strtotime($gonderi['tarih'])); ?></small>
                                
                                <?php if($gonderi['kullanici_id'] == $aktif_kullanici_id): ?>
                    <a href="sil.php?id=<?php echo $gonderi['id']; ?>" class="btn btn-outline-danger btn-sm">🗑️ Sil</a>
                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info text-center rounded-4">Henüz hiç gönderi yok. İlk yazan sen ol!</div>
                <?php endif; ?>

            </div>
        </div>
    </div>

</body>
</html>