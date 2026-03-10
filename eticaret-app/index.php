<?php
require_once 'baglan.php';

// Kasadaki tüm ürünleri çekelim
$sorgu = $db->prepare("SELECT * FROM urunler ORDER BY id DESC");
$sorgu->execute();
$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

// YENİ EKLEYECEĞİMİZ KISIM: Sayfa yüklenirken sepetteki ürün sayısını bul
$sepetteki_urun_sayisi = 0;
if (isset($_SESSION['sepet'])) {
    $sepetteki_urun_sayisi = array_sum($_SESSION['sepet']);
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Mini E-Ticaret</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4 shadow">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fa-solid fa-shop"></i> Benim Mağazam</a>
        
        <a href="sepet.php" class="btn btn-warning">
            <i class="fa-solid fa-cart-shopping"></i> Sepetim
            <span id="sepetSayaci" class="badge bg-danger rounded-pill"><?php echo $sepetteki_urun_sayisi; ?></span>
        </a>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Tüm Ürünler</h2>
    
    <div class="row">
        <?php foreach($urunler as $urun): ?>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                
                <img src="<?php echo $urun['resim_url']; ?>" class="card-img-top" alt="Ürün" style="height: 200px; object-fit: cover;">
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo $urun['urun_adi']; ?></h5>
                    
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="fs-4 fw-bold text-success"><?php echo $urun['fiyat']; ?> ₺</span>
                        <button onclick="sepeteEkle(<?php echo $urun['id']; ?>)" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Sepete Ekle</button>
                    </div>
                </div>
                
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
// SEPETE EKLEME KURYESİ
function sepeteEkle(urunId) {
    let kargo = new FormData();
    kargo.append('id', urunId);

    // Kurye ürünü alıp sepete_ekle.php'ye götürüyor
    fetch('sepete_ekle.php', {
        method: 'POST',
        body: kargo
    })
    .then(cevap => cevap.text())
    .then(toplamUrunSayisi => {
        // Gelen cevabı (sepetteki toplam ürün sayısını) yukarıdaki kırmızı rozetin içine yaz!
        document.getElementById('sepetSayaci').innerText = toplamUrunSayisi;
    });
}
</script>

</body>
</html>