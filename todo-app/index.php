<?php
// 1. KASAYI AÇIYORUZ
// require_once, "Bu sayfaya baglan.php dosyasını dahil et" demektir.
// Eğer baglan.php bulunamazsa sayfayı tamamen durdurur, bu yüzden çok güvenlidir.
require_once 'baglan.php';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Görev Yöneticisi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light mt-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    
                    <h3 class="card-title text-center text-primary mb-4">
                        <i class="fa-solid fa-list-check"></i> Görev Yöneticisi
                    </h3>
                    
                    <form id="gorevFormu" class="mb-4">
                        <div class="input-group">
                            <input type="text" id="yeniGorev" class="form-control form-control-lg" placeholder="Yeni bir görev yazın..." required>
                            <button type="submit" class="btn btn-primary btn-lg">Ekle</button>
                        </div>
                    </form>

                    <ul class="list-group" id="gorevListesi">
                        
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Marketten süt ve ekmek alınacak</span>
                            <div>
                                <button class="btn btn-sm btn-success"><i class="fa-solid fa-check"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </li>

                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Formu, metin kutusunu ve listeyi yakalayalım
    const form = document.getElementById('gorevFormu');
    const input = document.getElementById('yeniGorev');
    const liste = document.getElementById('gorevListesi');

    // 2. Form gönderilmeye (submit) çalışıldığında ne olacak?
    form.addEventListener('submit', function(e) {
        
        // DÜNYANIN EN ÖNEMLİ KODU: Sayfanın yenilenmesini durdur!
        e.preventDefault();
        
        // Kullanıcının kutuya yazdığı yazıyı alalım
        const gorevMetni = input.value;

        // Kuryeyi (Fetch API) yola çıkarıyoruz! Veriyi "ekle.php" dosyasına götürecek.
        // Veriyi gönderirken form (FormData) kullanıyoruz.
        let kargo = new FormData();
        kargo.append('gorev_adi', gorevMetni); // "gorev_adi" etiketiyle yazıyı kutuya koyduk

        fetch('ekle.php', {
            method: 'POST',
            body: kargo
        })
        .then(cevap => cevap.text()) // PHP'den gelen cevabı (başarılı/başarısız) metin olarak al
        .then(sonuc => {
            if(sonuc === "basarili") {
                // Eğer kayıt başarılıysa, metin kutusunu temizle
                input.value = "";
                // Ve ekrana bir uyarı ver (Şimdilik test için)
                //alert("Görev kasaya başarıyla eklendi!");
                gorevleriGetir(); // SİHİR! Sayfayı yenilemeden listeyi anında güncelle!
            } else {
                alert("Hata: " + sonuc);
            }
        });
    });
</script>

<script>
// GÖREVLERİ KASADAN ÇEKİP EKRANA YAZDIRAN FONKSİYON
function gorevleriGetir() {
    
    // 1. Kurye listele.php'ye gidiyor
    fetch('listele.php')
    
    // 2. DİKKAT! Önceki derste konuştuğumuz kısım:
    // Bu sefer PHP bize düz metin ("basarili") göndermiyor, içinde bir sürü veri olan bir JSON kutusu gönderiyor.
    // Bu yüzden cevap.text() DEĞİL, cevap.json() diyoruz ki kurye kutuyu doğru açsın!
    .then(cevap => cevap.json()) 
    
    // 3. Kutudan çıkan veriler (dizi) "veriler" adıyla buraya düştü!
    .then(veriler => {
        
        const liste = document.getElementById('gorevListesi');
        
        // Önce listeyi bir temizle (O sahte "Marketten süt..." yazısı silinsin)
        liste.innerHTML = ""; 

        // 4. Gelen her bir görev için döngü (Dizi içinde dönüyoruz)
        veriler.forEach(gorev => {

        // Eğer görev tamamlanmışsa (durum == 1), Bootstrap'in üstünü çizme (text-decoration-line-through) sınıfını ve gri rengini ekleyelim.
            let yaziStili = (gorev.durum == 1) ? "text-decoration-line-through text-muted" : "";

            // Butonun rengini de duruma göre değiştirelim (Yapıldıysa sarı geri al butonu, yapılmadıysa yeşil tik olsun)
            let butonRengi = (gorev.durum == 1) ? "btn-warning" : "btn-success";
            let butonIkoni = (gorev.durum == 1) ? "fa-rotate-left" : "fa-check";
            
            // Modern JS'de HTML yazmak çok kolaydır. (Ters tırnak `` kullanıyoruz)
            // ${gorev.gorev_adi} yazarak PHP'den gelen sütun ismini direkt HTML'in içine enjekte ediyoruz!
            // DİKKAT: Butonun içine onclick="durumGuncelle(${gorev.id})" ekledik!
            let eleman = `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="${yaziStili}">${gorev.gorev_adi}</span>
                    <div>
                        <button onclick="durumGuncelle(${gorev.id})" class="btn btn-sm ${butonRengi}">
                            <i class="fa-solid ${butonIkoni}"></i>
                        </button>
                        <button onclick="gorevSil(${gorev.id})" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </li>
            `;
            
            // Hazırladığımız bu satırı (<li>), listemizin (<ul>) içine ekliyoruz
            liste.innerHTML += eleman; 
        });
    });
}

// Sayfa ilk açıldığında listeyi doldurması için fonksiyonu hemen çalıştır:
gorevleriGetir();

// DURUM GÜNCELLEME KÜRYESİ
function durumGuncelle(gorev_id) {
    let kargo = new FormData();
    kargo.append('id', gorev_id); // Tıklanan butonun ID'sini kargoya koyduk

    fetch('guncelle.php', {
        method: 'POST',
        body: kargo
    })
    .then(cevap => cevap.text())
    .then(sonuc => {
        if(sonuc === "basarili") {
            // İşlem başarılıysa listeyi tekrar çağır (Böylece üstü çizili hali ekrana gelir)
            gorevleriGetir(); 
        } else {
            alert("Güncellenirken bir hata oluştu!");
        }
    });
}

// GÖREV SİLME KÜRYESİ
function gorevSil(gorev_id) {
    
    // Kullanıcıya "Emin misin?" diye soralım. Yanlışlıkla basmış olabilir!
    // confirm() kutusunda "Tamam"a basarsa sonuc true, "İptal"e basarsa false olur.
    let onay = confirm("Bu görevi tamamen silmek istediğinize emin misiniz?");
    
    if (onay) {
        let kargo = new FormData();
        kargo.append('id', gorev_id);

        fetch('sil.php', {
            method: 'POST',
            body: kargo
        })
        .then(cevap => cevap.text())
        .then(sonuc => {
            if(sonuc === "basarili") {
                // Kasadan silindiyse, listeyi tekrar çek ki ekrandan da kaybolsun
                gorevleriGetir(); 
            } else {
                alert("Silinirken bir hata oluştu!");
            }
        });
    }
}

</script>

</body>
</html>

</body>
</html>