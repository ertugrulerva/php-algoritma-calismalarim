<?php 
// Eğer kullanıcı zaten giriş yapmışsa, onu tekrar giriş sayfasına sokmamalıyız!
// (Bunun mantığını bir sonraki adımda panel sayfasını yaparken çok net anlayacaksın)
session_start();
if(isset($_SESSION['kullanici_id'])){
    header("Location: panel.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">Hoş Geldiniz</h3>
                    
                    <form id="girisFormu">
                        <div class="mb-3">
                            <label class="form-label">E-Posta Adresiniz</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Şifreniz</label>
                            <input type="password" id="sifre" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100 py-2">Giriş Yap</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <a href="kayit.php" class="text-decoration-none">Hesabın yok mu? <b>Yeni Kayıt Oluştur</b></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

<script>
    const form = document.getElementById('girisFormu');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault(); 

        let kargo = new FormData();
        kargo.append('email', document.getElementById('email').value);
        kargo.append('sifre', document.getElementById('sifre').value);

        // Kurye bu sefer giris_islem.php'ye gidiyor
        fetch('giris_islem.php', {
            method: 'POST',
            body: kargo
        })
        .then(cevap => cevap.text())
        .then(sonuc => {
            if(sonuc === "basarili") {
                // Giriş başarılıysa SweetAlert ile küçük bir hoşgeldin mesajı verip içeri (panel.php) yönlendiriyoruz.
                Swal.fire({
                    icon: 'success',
                    title: 'Başarılı!',
                    text: 'Giriş yapılıyor, lütfen bekleyin...',
                    showConfirmButton: false, // Tamam butonunu gizle
                    timer: 1500 // 1.5 saniye sonra otomatik kapansın
                }).then(() => {
                    window.location.href = "panel.php"; // İçeri yönlendir!
                });
            } else {
                // Şifre yanlışsa veya e-posta yoksa hata ver
                Swal.fire({
                    icon: 'error',
                    title: 'Giriş Başarısız!',
                    text: 'E-posta adresiniz veya şifreniz hatalı.',
                });
            }
        });
    });
</script>
</body>
</html>