<?php
// 1. Veritabanını çağır ve hafızayı başlat
require_once 'baglan.php';

// 2. Eğer kullanıcı zaten giriş yapmışsa, kayıt sayfasında işi yok! Ana sayfaya yolla.
if(isset($_SESSION['kullanici_id'])) {
    header("Location: index.php");
    exit;
}

// 3. Ekrana basılacak mesajlar için boş değişkenler hazırlıyoruz
$hata = "";
$basari = "";

// 4. SİHİRLİ KISIM: Eğer form POST edildiyse (Yani butona basıldıysa) aşağıdaki kodları çalıştır!
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kullanici_adi = trim($_POST['kullanici_adi']); // trim() sağdaki soldaki boşlukları siler
    $sifre = $_POST['sifre'];

    if (!empty($kullanici_adi) && !empty($sifre)) {
        
        // A. KONTROL: Bu kullanıcı adı daha önce alınmış mı?
        $kontrol = $db->prepare("SELECT id FROM kullanicilar WHERE kullanici_adi = ?");
        $kontrol->execute([$kullanici_adi]);
        
        if ($kontrol->rowCount() > 0) {
            // Eğer veritabanından 0'dan fazla satır dönerse, demek ki bu isim alınmış!
            $hata = "Bu kullanıcı adı zaten alınmış. Lütfen başka bir tane seçin 🕵️‍♂️";
        } else {
            // B. GÜVENLİK: Şifreyi asla düz metin (123456) olarak kaydetmiyoruz! (Kriptoluyoruz)
            $kriptolu_sifre = password_hash($sifre, PASSWORD_DEFAULT);

            // C. KAYIT: Yeni kullanıcıyı veritabanına ekle
            $ekle = $db->prepare("INSERT INTO kullanicilar (kullanici_adi, sifre) VALUES (?, ?)");
            $sonuc = $ekle->execute([$kullanici_adi, $kriptolu_sifre]);

            if ($sonuc) {
                $basari = "Harika! Kaydın başarıyla oluşturuldu. Şimdi giriş yapabilirsin! 🎉";
            } else {
                $hata = "Kayıt sırasında sistemsel bir hata oluştu.";
            }
        }
    } else {
        $hata = "Lütfen tüm alanları doldurun.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Mini Twitter - Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 text-center">
                        <h3 class="mb-4 text-primary">📝 Kayıt Ol</h3>

                        <?php if($hata != ""): ?>
                            <div class="alert alert-danger"><?php echo $hata; ?></div>
                        <?php endif; ?>

                        <?php if($basari != ""): ?>
                            <div class="alert alert-success"><?php echo $basari; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <input type="text" name="kullanici_adi" class="form-control" placeholder="Kullanıcı Adı" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="sifre" class="form-control" placeholder="Şifre" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Aramıza Katıl</button>
                        </form>
                        
                        <div class="mt-3 text-muted">
                            Zaten üye misin? <a href="giris.php" class="text-decoration-none fw-bold">Giriş Yap</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>