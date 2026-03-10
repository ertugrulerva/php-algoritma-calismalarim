<?php
// 1. Müşterinin hafızasını ve kasayı aç
require_once 'baglan.php';

$sepet_urunleri = []; // Sepetteki ürünlerin detaylarını koyacağımız boş kutu
$genel_toplam = 0;    // Ödenecek toplam para sıfırdan başlıyor

// 2. HAFIZADA SEPET VAR MI VE İÇİ DOLU MU?
if (isset($_SESSION['sepet']) && count($_SESSION['sepet']) > 0) {
    
    // 3. SEPETİN İÇİNDE DÖN (Hangi ID'den kaç adet var?)
    foreach ($_SESSION['sepet'] as $urun_id => $adet) {
        
        // Kasaya git ve bu ID'ye sahip ürünün resmini, adını, fiyatını getir
        $sorgu = $db->prepare("SELECT * FROM urunler WHERE id = ?");
        $sorgu->execute([$urun_id]);
        $urun = $sorgu->fetch(PDO::FETCH_ASSOC);
        
        if ($urun) {
            // Bulunan ürün paketinin içine müşterinin kaç tane seçtiğini (adet) de ekle
            $urun['adet'] = $adet;
            // Fiyatla adeti çarpıp bu ürün için ödenecek alt toplamı bul (Örn: 2 Tişört x 250TL = 500TL)
            $urun['alt_toplam'] = $urun['fiyat'] * $adet;
            
            // Faturadaki genel toplama bu alt toplamı ekle
            $genel_toplam += $urun['alt_toplam'];
            
            // Hazırlanan bu mükemmel paketi sepet listemize ekle
            $sepet_urunleri[] = $urun; 
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sepetim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4 shadow">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fa-solid fa-shop"></i> Benim Mağazam</a>
        <a href="index.php" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-arrow-left"></i> Alışverişe Dön</a>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Alışveriş Sepetim</h2>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    
                    <?php if (empty($sepet_urunleri)): ?>
                        <div class="text-center py-5">
                            <h1 class="text-muted"><i class="fa-solid fa-cart-arrow-down"></i></h1>
                            <h4 class="mt-3">Sepetiniz şu an boş.</h4>
                            <p class="text-muted">Hemen alışverişe başlayıp sepetinizi doldurun!</p>
                            <a href="index.php" class="btn btn-primary mt-2">Ürünlere Git</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Ürün</th>
                                        <th>Fiyat</th>
                                        <th>Adet</th>
                                        <th>Toplam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($sepet_urunleri as $item): ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo $item['resim_url']; ?>" alt="" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-2">
                                            <?php echo $item['urun_adi']; ?>
                                        </td>
                                        <td><?php echo $item['fiyat']; ?> ₺</td>
                                        <td><strong><?php echo $item['adet']; ?></strong></td>
                                        <td class="text-success fw-bold"><?php echo $item['alt_toplam']; ?> ₺</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
        
        <?php if (!empty($sepet_urunleri)): ?>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">Sipariş Özeti</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Ara Toplam</span>
                        <span><?php echo $genel_toplam; ?> ₺</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-success">
                        <span>Kargo</span>
                        <span>Ücretsiz</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5 fw-bold">Genel Toplam</span>
                        <span class="fs-5 fw-bold text-primary"><?php echo $genel_toplam; ?> ₺</span>
                    </div>
                    
                    <a href="odeme.php" class="btn btn-success w-100 py-2"><i class="fa-solid fa-credit-card"></i> Ödemeye Geç</a>
                    <a href="sepeti_bosalt.php" class="btn btn-outline-danger w-100 mt-2 py-2"><i class="fa-solid fa-trash"></i> Sepeti Boşalt</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
    </div>
</div>

</body>
</html>