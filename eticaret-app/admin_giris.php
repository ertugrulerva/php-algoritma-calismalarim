<?php
session_start();
// Eğer patron zaten giriş yapmışsa, onu tekrar giriş ekranında tutma, direkt ürünlere yolla!
if(isset($_SESSION['admin_giris'])) {
    header("Location: admin_urunler.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Girişi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-dark d-flex align-items-center" style="height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5 text-center">
                    
                    <h1 class="text-primary mb-3"><i class="fa-solid fa-lock"></i></h1>
                    <h4 class="mb-4">Yönetici Girişi</h4>
                    
                    <form action="admin_kontrol.php" method="POST">
                        <div class="mb-3">
                            <input type="text" name="kullanici_adi" class="form-control" placeholder="Kullanıcı Adı" required>
                        </div>
                        <div class="mb-4">
                            <input type="password" name="sifre" class="form-control" placeholder="Şifre" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Giriş Yap</button>
                    </form>
                    
                    <div class="mt-4">
                        <a href="index.php" class="text-muted text-decoration-none"><i class="fa-solid fa-arrow-left"></i> Vitrine Dön</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>