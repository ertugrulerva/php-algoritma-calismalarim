<?php
// 1. Hafızayı ve Kasayı Aç
//session_start();
require_once 'baglan.php';

// 2. GÜVENLİK DUVARI: Sepet boşsa bu sayfaya girmesi yasak!
if (!isset($_SESSION['sepet']) || empty($_SESSION['sepet'])) {
    header("Location: index.php");
    exit;
}

// 3. Ekranda göstermek için sepetin toplamını tekrar hesaplıyoruz
$genel_toplam = 0;
foreach ($_SESSION['sepet'] as $urun_id => $adet) {
    $sorgu = $db->prepare("SELECT fiyat FROM urunler WHERE id = ?");
    $sorgu->execute([$urun_id]);
    $urun = $sorgu->fetch(PDO::FETCH_ASSOC);
    if ($urun) {
        $genel_toplam += ($urun['fiyat'] * $adet);
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ödeme Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4 shadow">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fa-solid fa-shop"></i> Benim Mağazam</a>
        <a href="sepet.php" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-arrow-left"></i> Sepete Dön</a>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fa-solid fa-truck"></i> Teslimat Bilgileri</h5>
                </div>
                <div class="card-body p-4">
                    <form id="odemeFormu">
                        <div class="mb-3">
                            <label class="form-label">Adınız ve Soyadınız</label>
                            <input type="text" id="ad_soyad" class="form-control" required placeholder="Örn: Ahmet Yılmaz">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Açık Adresiniz</label>
                            <textarea id="adres" class="form-control" rows="3" required placeholder="Mahalle, Sokak, Kapı No..."></textarea>
                        </div>
                        
                        <hr class="my-4">
                        <h5 class="mb-3"><i class="fa-solid fa-credit-card"></i> Kredi Kartı Bilgileri (Simülasyon)</h5>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Kart Üzerindeki İsim">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" placeholder="Kart Numarası (0000 0000 0000 0000)">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="text" class="form-control" placeholder="AA/YY">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="text" class="form-control" placeholder="CVC">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-3 mt-3 fs-5 fw-bold">
                            Siparişi Tamamla
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body p-4 text-center">
                    <h5 class="card-title mb-4">Ödenecek Tutar</h5>
                    <h1 class="display-5 text-primary fw-bold mb-4"><?php echo $genel_toplam; ?> ₺</h1>
                    <p class="text-muted"><i class="fa-solid fa-shield-halved"></i> 256-bit SSL ile Güvenli Ödeme</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<script>
    const form = document.getElementById('odemeFormu');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Sayfa yenilenmesini durdur

        // Müşterinin adını ve adresini kuryeye veriyoruz
        let kargo = new FormData();
        kargo.append('ad_soyad', document.getElementById('ad_soyad').value);
        kargo.append('adres', document.getElementById('adres').value);

        // Kurye siparişi arka planda kaydetmeye gidiyor
        fetch('siparis_isle.php', {
            method: 'POST',
            body: kargo
        })
        .then(cevap => cevap.text())
        .then(sonuc => {
            if(sonuc === "basarili") {
                Swal.fire({
                    icon: 'success',
                    title: 'Siparişiniz Alındı!',
                    text: 'Bizi tercih ettiğiniz için teşekkür ederiz. Ana sayfaya yönlendiriliyorsunuz...',
                    showConfirmButton: false,
                    timer: 2500
                }).then(() => {
                    window.location.href = "index.php"; // Ana sayfaya yolla
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: 'Sipariş oluşturulurken bir sorun oluştu.',
                });
            }
        });
    });
</script>
</body>
</html>