<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>AJAX ile VKİ Hesaplama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light mt-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Vücut Kitle İndeksi</h5>
                    
                    <form id="vkiFormu">
                        <div class="mb-3">
                            <label>Kilo (kg):</label>
                            <input type="number" id="kiloKutusu" name="kilo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Boy (cm):</label>
                            <input type="number" id="boyKutusu" name="boy" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Hesapla (AJAX)</button>
                    </form>

                    <div id="sonucAlani" class="alert alert-info mt-3 d-none text-center">
                        VKİ: <strong id="vkiSonuc">0</strong> <br>
                        Durum: <strong id="durumSonuc">-</strong>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Formu yakalayalım
    const form = document.getElementById('vkiFormu');
    const sonucAlani = document.getElementById('sonucAlani');
    const vkiSonuc = document.getElementById('vkiSonuc');
    const durumSonuc = document.getElementById('durumSonuc');

    // Form "gönderilmeye" çalışıldığında...
    form.addEventListener('submit', function(olay) {
        
        // 1. DÜNYANIN EN ÖNEMLİ KODU: Sayfanın yenilenmesini (refresh) engelle!
        olay.preventDefault(); 

        // 2. Formun içindeki verileri (Kilo ve Boy) bir kargo paketine (FormData) koy
        const kargoPaketi = new FormData(form);

        // 3. AJAX Kuryesini Yola Çıkar! (Modern JS'de bunun adı 'fetch' fonksiyonudur)
        fetch('hesapla.php', {
            method: 'POST', // Gizli gönder
            body: kargoPaketi // Kargo paketini PHP'ye ver
        })
        .then(cevap => cevap.json()) // PHP'den gelen cevabı JSON (kutu) olarak aç
        .then(gelenVeri => {
            
            // 4. Kutu açıldı! Şimdi içindeki verileri ekrana yazdır
            vkiSonuc.textContent = gelenVeri.indeks_skoru;
            durumSonuc.textContent = gelenVeri.saglik_durumu;

            // Gizli olan sonuç kutusunun 'd-none' (display:none) sınıfını silip görünür yap
            sonucAlani.classList.remove('d-none');

        });
    });
</script>

</body>
</html>