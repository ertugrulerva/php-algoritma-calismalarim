<?php

// 1. Kasayı aç
require_once 'baglan.php';

// GÜVENLİK DUVARI: Sadece yaka kartı (session) olanlar girebilir!
if(!isset($_SESSION['admin_giris'])) {
    header("Location: admin_giris.php");
    exit; // Yaka kartı yoksa sayfayı okumayı anında durdur ve kapıya at!
}

// 2. Hangi ürün düzenlenecek? (URL'den gelen ID'yi alıyoruz)
if (!isset($_GET['id'])) {
    header("Location: admin_urunler.php"); // ID yoksa listeye geri postala
    exit;
}

$id = $_GET['id'];

// 3. Kasadan bu ürünün şu anki (eski) bilgilerini çek
$sorgu = $db->prepare("SELECT * FROM urunler WHERE id = ?");
$sorgu->execute([$id]);
$urun = $sorgu->fetch(PDO::FETCH_ASSOC);

// Eğer biri URL'ye kafadan uydurma bir ID yazarsa
if (!$urun) {
    echo "Böyle bir ürün bulunamadı.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning py-3">
                    <h5 class="mb-0 text-dark">Ürünü Düzenle: <?php echo $urun['urun_adi']; ?></h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="urun_guncelle.php" method="POST" enctype="multipart/form-data">
                        
                        <input type="hidden" name="id" value="<?php echo $urun['id']; ?>">
                        
                        <input type="hidden" name="eski_resim_url" value="<?php echo $urun['resim_url']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Ürün Adı</label>
                            <input type="text" name="urun_adi" class="form-control" value="<?php echo $urun['urun_adi']; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Fiyatı (TL)</label>
                            <input type="number" step="0.01" name="fiyat" class="form-control" value="<?php echo $urun['fiyat']; ?>" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label d-block">Mevcut Fotoğraf</label>
                            <img src="<?php echo $urun['resim_url']; ?>" alt="Mevcut Resim" style="width: 100px; height: 100px; object-fit: cover;" class="mb-2 rounded border">
                            
                            <label class="form-label mt-2">Yeni Fotoğraf Yükle</label>
                            <div class="form-text text-muted mb-2">Resmi değiştirmek istemiyorsanız burayı boş bırakın.</div>
                            <input type="file" name="resim" class="form-control" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-warning w-100 py-2 fw-bold">Değişiklikleri Kaydet</button>
                        <a href="admin_urunler.php" class="btn btn-secondary w-100 py-2 mt-2">İptal ve Geri Dön</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>