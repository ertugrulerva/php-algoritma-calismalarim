<?php
// GÜVENLİK DUVARI: Sadece yaka kartı (session) olanlar girebilir!
session_start();
if(!isset($_SESSION['admin_giris'])) {
    header("Location: admin_giris.php");
    exit; // Yaka kartı yoksa sayfayı okumayı anında durdur ve kapıya at!
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Paneli - Ürün Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4 shadow">
    <div class="container">
        <a class="navbar-brand" href="#">⚙️ Yönetici Paneli</a>
        <a href="index.php" class="btn btn-outline-light btn-sm">Müşteri Ekranına Git</a>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">Yeni Ürün Ekle</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="urun_kaydet.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label">Ürün Adı</label>
                            <input type="text" name="urun_adi" class="form-control" required placeholder="Örn: Mavi Gömlek">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Fiyatı (TL)</label>
                            <input type="number" step="0.01" name="fiyat" class="form-control" required placeholder="Örn: 299.90">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Ürün Fotoğrafı (Sadece Resim)</label>
                            <input type="file" name="resim" class="form-control" accept="image/*" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">Ürünü Kasaya Ekle</button>
                    </form>
                    </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>