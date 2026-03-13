// 1. OYUNUN VERİTABANI: Sorular, Şıklar ve Doğru Cevaplar
// "const" kelimesi "sabit" demektir. Bu sorular oyun boyunca değişmeyeceği için const kullanıyoruz.

const sorular = [
    {
        soru: "Gökte gördüm köprü, rengi yedi türlü.",
        secenekler: ["Bulut", "Gökkuşağı", "Uçurtma"],
        dogruCevap: "Gökkuşağı"
    },
    {
        soru: "Çarşıdan aldım bir tane, eve geldim bin tane.",
        secenekler: ["Elma", "Ceviz", "Nar"],
        dogruCevap: "Nar"
    },
    {
        soru: "Dışı var içi yok, tekme yer suçu yok.",
        secenekler: ["Top", "Kutu", "Davul"],
        dogruCevap: "Top"
    },
    {
        soru: "Ben giderim o gider, içimde tık tık eder.",
        secenekler: ["Saat", "Kalp", "Ayakkabı"],
        dogruCevap: "Kalp"
    },
    {
        soru: "Kuyruğu var at değil, kanadı var kuş değil.",
        secenekler: ["Balık", "Uçak", "Kelebek"],
        dogruCevap: "Balık"
    },
    {
        soru: "Geceleri uçar, gündüzleri baş aşağı yatar.",
        secenekler: ["Baykuş", "Yarasa", "Örümcek"],
        dogruCevap: "Yarasa"
    },
    {
        soru: "Ağzı var dili yok, nefesi var canı yok.",
        secenekler: ["Flüt", "Rüzgar", "Soba"],
        dogruCevap: "Flüt"
    },
    {
        soru: "Sarıdır sarkar, düşerim diye korkar.",
        secenekler: ["Muz", "Armut", "Limon"],
        dogruCevap: "Armut"
    },
    {
        soru: "Yer altında sakallı dede.",
        secenekler: ["Havuç", "Pırasa", "Soğan"],
        dogruCevap: "Pırasa"
    },
    {
        soru: "Uzaktan baktım hiç yok, yakından baktım pek çok.",
        secenekler: ["Karınca", "Toz", "Kum"],
        dogruCevap: "Karınca"
    }
];

// Doğru çalışıp çalışmadığını test etmek için gizli bir mesaj yazdıralım
//console.log("Sorular başarıyla yüklendi! Toplam soru sayısı: " + sorular.length);

// ... (Yukarıdaki 10 soruluk 'sorular' dizisi aynen duruyor) ...

// 2. OYUNUN HAFIZASI (Değişkenler)
// Sistem hangi soruda olduğumuzu ve puanımızı aklında tutmalı.
let kacinciSoru = 0; 
let puan = 0;

// 3. SAHNEYİ KURAN YÖNETMEN (Fonksiyon)
// Bu fonksiyon her çağrıldığında ekranı temizleyip sıradaki soruyu çizecek.
function soruyuEkranaBas() {
    
    // A. Hangi sorudayız? O sorunun paketini (objesini) diziden alalım.
    const siradakiSoru = sorular[kacinciSoru];

    // B. HTML'deki o boş "Oyun Yükleniyor..." yazan kutuyu bul ve içine soruyu yaz!
    document.getElementById("soruKutusu").innerText = siradakiSoru.soru;

    // C. Skorbord'u Güncelle 
    // (kacinciSoru + 1) yapıyoruz çünkü yazılımda sayma 0'dan başlar ama insanlara "Soru 0" diyemeyiz :)
    document.getElementById("soruSirasi").innerText = "Soru: " + (kacinciSoru + 1) + " / " + sorular.length;

    // SKORBORD GÜNCELLEMESİ: Puanı da ekrana yazdırıyoruz!
    document.getElementById("puanTablosu").innerText = "Puan: " + puan;

    // D. Şıklar Kutusunu Bul ve İçini Temizle (Eğer eski sorunun şıkları varsa silinsin)
    const seceneklerAlani = document.getElementById("seceneklerKutusu");
    seceneklerAlani.innerHTML = ""; 

    // E. SİHİRBAZLIK: Şıkları tek tek butona çevirip kutunun içine atıyoruz
    siradakiSoru.secenekler.forEach(function(secenek) {
        
        // 1. Yeni bir buton elementi yarat (Yoktan var ediyoruz!)
        const buton = document.createElement("button");

        // 2. Butonun içine şıkkın yazısını (Örn: Gökkuşağı) ekle
        buton.innerText = secenek;

        // 3. Butona Bootstrap'in şık tasarım kodlarını (class) ekle
        buton.classList.add("btn", "btn-outline-primary", "btn-lg");

        // YENİ SİHİR BURADA: Butona "Tıklanma" (click) kulaklığı takıyoruz!
        // Biri bu butona tıklarsa, içindeki şıkkı (secenek) alıp Hakem'e (cevabiKontrolEt) gönderiyor.
        // DİKKAT: Hakeme sadece seçilen şıkkı değil, TIKLANAN BUTONUN KENDİSİNİ de (buton) gönderiyoruz!
        // Böylece hakem hangi butonu boyayacağını bilecek.
        buton.addEventListener("click", function() {
            cevabiKontrolEt(secenek, buton); 
        });

        // 4. Hazırladığımız bu butonu o boş çerçevenin (seceneklerKutusu) içine yerleştir
        seceneklerAlani.appendChild(buton);
    });
}

// YENİ FONKSİYON: HAKEM (Cevap Doğru mu Yanlış mı?)
function cevabiKontrolEt(kullanicininSectigi,tiklananButon) {
    
    // 1. OYUNU DONDUR: Kullanıcı art arda basamasın diye tüm butonları kilitliyoruz.
    const tumButonlar = document.getElementById("seceneklerKutusu").querySelectorAll("button");
    tumButonlar.forEach(function(btn) {
        btn.disabled = true; // Butonu tıklanamaz hale getirir
    });

    // Kopya kağıdına (veritabanına) bakıp doğru cevabı buluyoruz
    const dogruOlan = sorular[kacinciSoru].dogruCevap;

    // 1. KONTROL: Kullanıcının seçtiği ile doğru olan aynı mı? (=== işareti 'birebir aynı mı' demektir)
    if (kullanicininSectigi === dogruOlan) {
        puan += 10; // Doğruysa puan kumbarasına 10 ekle
        // Bootstrap'in mavi çerçeveli sınıfını sil, Yeşil (success) sınıfını ekle!
        tiklananButon.classList.remove("btn-outline-primary");
        tiklananButon.classList.add("btn-success"); 
    } else {
        // Yanlış bildiyse Kırmızı (danger) yap!
        tiklananButon.classList.remove("btn-outline-primary");
        tiklananButon.classList.add("btn-danger");

        // BONUS JEST: Adam yanlış bildi, bari doğru cevabın hangisi olduğunu yeşil yakıp gösterelim!
        tumButonlar.forEach(function(btn) {
            if (btn.innerText === dogruOlan) {
                btn.classList.remove("btn-outline-primary");
                btn.classList.add("btn-success");
            }
        });
    }

    // Puanı anında sağ üstte güncelle
    document.getElementById("puanTablosu").innerText = "Puan: " + puan;

  // 3. ZAMAN MAKİNESİ (setTimeout): 1.5 saniye bekle, sonra diğer soruya geç!
    setTimeout(function() {
        kacinciSoru++;

        if (kacinciSoru < sorular.length) {
            soruyuEkranaBas(); // Sıradaki soruyu çiz
        } else {
            // Oyun bitti ekranı
            document.getElementById("soruKutusu").innerText = "🎉 Oyun Bitti! Toplam Puanın: " + puan;
            document.getElementById("seceneklerKutusu").innerHTML = ""; 
            document.getElementById("soruSirasi").innerText = "Bitti";

            // YENİ EKLENEN SİHİR: TEKRAR OYNA BUTONU
            const tekrarButonu = document.createElement("button");
            tekrarButonu.innerText = "🔄 Tekrar Oyna";
            tekrarButonu.classList.add("btn", "btn-warning", "btn-lg", "mt-2", "fw-bold", "w-100", "shadow-sm");

            // Butona tıklandığında ne olacak?
            tekrarButonu.addEventListener("click", function() {
                // 1. Oyunun hafızasını (State) tamamen sıfırla!
                kacinciSoru = 0;
                puan = 0;
                
                // 2. Motoru yeniden çalıştır!
                soruyuEkranaBas();
            });

            // Butonu ekrana bas!
            document.getElementById("seceneklerKutusu").appendChild(tekrarButonu);
        }
    }, 1500); // 1500 milisaniye = 1.5 saniye bekleme süresi
}

// 4. OYUNU BAŞLAT!
// Sayfa açıldığında bu fonksiyonu bir kere çağırıyoruz ki ilk soru ekrana gelsin.
soruyuEkranaBas();