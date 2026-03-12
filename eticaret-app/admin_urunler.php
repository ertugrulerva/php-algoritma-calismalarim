<?php

// 1. Kasamızı açıyoruz
require_once 'baglan.php';

// GÜVENLİK DUVARI: Sadece yaka kartı (session) olanlar girebilir!
if(!isset($_SESSION['admin_giris'])) {
    header("Location: admin_giris.php");
    exit; // Yaka kartı yoksa sayfayı okumayı anında durdur ve kapıya at!
}


// 2. Kasadaki tüm ürünleri 'en son eklenen en üstte olacak şekilde' (ORDER BY id DESC) çekiyoruz
$sorgu = $db->prepare("SELECT * FROM urunler ORDER BY id DESC");
$sorgu->execute();
$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Paneli - Ürün Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4 shadow">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-gear"></i> Yönetici Paneli</a>
        <div>
            <a href="admin.php" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i> Yeni Ürün Ekle</a>
            <a href="index.php" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-shop"></i> Vitrine Git</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Dükkandaki Tüm Ürünler</h2>
    
    <div class="card shadow-sm border-0">
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Barkod (ID)</th>
                            <th>Fotoğraf</th>
                            <th>Ürün Adı</th>
                            <th>Fiyat</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php foreach($urunler as $urun): ?>
                        <tr>
                            <td><strong>#<?php echo $urun['id']; ?></strong></td>
                            
                            <td>
                                <img src="<?php echo $urun['resim_url']; ?>" alt="Ürün" style="width: 50px; height: 50px; object-fit: cover;" class="rounded border">
                            </td>
                            
                            <td><?php echo $urun['urun_adi']; ?></td>
                            <td><span class="text-success fw-bold"><?php echo $urun['fiyat']; ?> ₺</span></td>
                            
                            <td>
                                <a href="urun_duzenle.php?id=<?php echo $urun['id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i> Düzenle</a>
                                
                                <a href="urun_sil.php?id=<?php echo $urun['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu ürünü kalıcı olarak silmek istediğinize emin misiniz?');">
                                    <i class="fa-solid fa-trash"></i> Sil
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</body>
</html>