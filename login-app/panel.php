<?php
// 1. Önce yaka kartlarını okuyan sistemi çalıştır
session_start();

// 2. VİP KAPI KONTROLÜ (Güvenlik Görevlisi)
// Eğer bu adamın 'kullanici_id' isimli bir yaka kartı YOKSA (! işareti 'değilse/yoksa' demektir)
if (!isset($_SESSION['kullanici_id'])) {
    // Onu anında kapının önüne (Giriş sayfasına) koy ve kodun devamını okuma!
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container">
        <a class="navbar-brand" href="#">Benim Sistemim</a>
        <div class="d-flex">
            <a href="cikis.php" class="btn btn-danger btn-sm">Çıkış Yap <i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5 text-center">
                    <h1 class="display-4 text-success mb-3">🎉</h1>
                    <h2 class="mb-4">Hoş Geldin, <span class="text-primary"><?php echo $_SESSION['ad_soyad']; ?></span>!</h2>
                    <p class="lead text-muted">Burası sitemizin sadece giriş yapan üyelerin görebildiği gizli ve güvenli alanıdır.</p>
                    <p>Sisteme kayıtlı ID Numaran: <strong><?php echo $_SESSION['kullanici_id']; ?></strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>