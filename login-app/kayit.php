<?php require_once 'baglan.php'; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">Yeni Hesap Oluştur</h3>
                    
                    <form id="kayitFormu">
                        <div class="mb-3">
                            <label class="form-label">Adınız ve Soyadınız</label>
                            <input type="text" id="ad_soyad" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-Posta Adresiniz</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Şifreniz</label>
                            <input type="password" id="sifre" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2">Kayıt Ol</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <a href="index.php" class="text-decoration-none">Zaten hesabın var mı? <b>Giriş Yap</b></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

<script>
    const form = document.getElementById('kayitFormu');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Sayfa yenilenmesini durdur

        // Kuryeyi (AJAX) yola çıkarma hazırlığı
        let kargo = new FormData();
        kargo.append('ad_soyad', document.getElementById('ad_soyad').value);
        kargo.append('email', document.getElementById('email').value);
        kargo.append('sifre', document.getElementById('sifre').value);

        // Kurye kayit_islem.php'ye gidiyor (Bir sonraki adımda yazacağız)
        fetch('kayit_islem.php', {
            method: 'POST',
            body: kargo
        })
        .then(cevap => cevap.text())
        .then(sonuc => {
            // İŞTE SÖZ VERDİĞİMİZ ŞIK UYARILAR (SweetAlert2)
            if(sonuc === "basarili") {
                Swal.fire({
                    icon: 'success',
                    title: 'Harika!',
                    text: 'Kaydınız başarıyla oluşturuldu. Giriş yapabilirsiniz.',
                    confirmButtonText: 'Tamam'
                }).then(() => {
                    form.reset(); // Formu temizle
                    // İstersen burada giriş sayfasına (index.php) yönlendirme yapabiliriz
                });
            } else if(sonuc === "var") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Hata!',
                    text: 'Bu e-posta adresi zaten kullanılıyor!',
                    confirmButtonText: 'Anladım'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Eyvah!',
                    text: 'Kayıt sırasında bir hata oluştu: ' + sonuc,
                });
            }
        });
    });
</script>
</body>
</html>