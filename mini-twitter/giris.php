<?php
// 1. Veritabanını ve hafızayı (Session) çağır
require_once 'baglan.php';

// 2. Kullanıcı zaten giriş yapmışsa onu tekrar giriş ekranında tutma, ana sayfaya (akışa) yolla!
if(isset($_SESSION['kullanici_id'])) {
    header("Location: index.php");
    exit;
}

$hata = "";

// 3. Form gönderildiyse (POST işlemi) çalışacak kodlar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kullanici_adi = trim($_POST['kullanici_adi']);
    $girilen_sifre = $_POST['sifre'];

    if (!empty($kullanici_adi) && !empty($girilen_sifre)) {
        
        // A. KONTROL: Veritabanında böyle bir kullanıcı var mı?
        $sorgu = $db->prepare("SELECT id, kullanici_adi, sifre FROM kullanicilar WHERE kullanici_adi = ?");
        $sorgu->execute([$kullanici_adi]);
        $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

        // B. EŞLEŞTİRME: Kullanıcı bulunduysa, şifresini kontrol et!
        // password_verify(): Kullanıcının girdiği düz şifre (123456) ile veritabanındaki kriptolu karmaşık şifreyi karşılaştırır.
        if ($kullanici && password_verify($girilen_sifre, $kullanici['sifre'])) {
            
            // C. SİHİRLİ AN: Şifre doğru! Yaka kartlarını (Session) takıyoruz.
            $_SESSION['kullanici_id'] = $kullanici['id']; // Bu çok önemli, içerikleri bu ID ile bağlayacağız!
            $_SESSION['kullanici_adi'] = $kullanici['kullanici_adi'];

            // D. Yönlendirme: Yaka kartını takan kişiyi Ana Sayfaya (Twitter Akışına) gönder
            header("Location: index.php");
            exit;
            
        } else {
            $hata = "Kullanıcı adı veya şifre hatalı! 🕵️‍♂️";
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
    <title>Mini Twitter - Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 text-center">
                        <h3 class="mb-4 text-success">👋 Tekrar Hoş Geldin</h3>

                        <?php if($hata != ""): ?>
                            <div class="alert alert-danger"><?php echo $hata; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <input type="text" name="kullanici_adi" class="form-control" placeholder="Kullanıcı Adı" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="sifre" class="form-control" placeholder="Şifre" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100 fw-bold">Giriş Yap</button>
                        </form>
                        
                        <div class="mt-3 text-muted">
                            Hesabın yok mu? <a href="kayit.php" class="text-decoration-none fw-bold">Hemen Kayıt Ol</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>