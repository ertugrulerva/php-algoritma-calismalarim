<?php

class BankaHesabi {
    
    // 1. ÖZELLİKLER (Properties)
    public $hesapSahibi; // Herkes görebilir ve değiştirebilir
    private $bakiye;     // SADECE bu sınıfın içindeki kodlar görebilir ve değiştirebilir! (KIRMIZI ÇİZGİ)

    // 2. YAPICI METOT (Hesap Açılışı)
    public function __construct($isim, $ilkBakiye) {
        $this->hesapSahibi = $isim;
        $this->bakiye = $ilkBakiye;
        echo "<strong>{$this->hesapSahibi}</strong> adına yeni hesap açıldı. İlk Bakiye: {$this->bakiye} TL <hr>";
    }

    // 3. BAKİYE GÖSTERİCİ (Getter)
    // Bakiye private olduğu için dışarıdan okunamayacak. Onu okumak için bu fonksiyonu kullanacağız.
    public function bakiyeGoster() {
        return "Güncel Bakiyeniz: <b>" . $this->bakiye . " TL</b><br>";
    }

    // 4. PARA YATIRMA (Kontrollü Giriş)
    public function paraYatir($miktar) {
        if ($miktar > 0) {
            $this->bakiye += $miktar; // += demek üstüne ekle demektir
            echo "<span style='color:green'>+ $miktar TL yatırıldı.</span><br>";
        } else {
            echo "<span style='color:red'>Hata: Geçersiz tutar!</span><br>";
        }
    }

    // 5. PARA ÇEKME (Kontrollü Çıkış)
    public function paraCek($miktar) {
        if ($miktar <= $this->bakiye) {
            $this->bakiye -= $miktar; // -= demek içinden çıkar demektir
            echo "<span style='color:orange'>- $miktar TL çekildi.</span><br>";
        } else {
            echo "<span style='color:red'>Hata: Yetersiz bakiye! Çekmek istediğiniz tutar: $miktar TL</span><br>";
        }
    }
}

// ==========================================
// KULLANIM AŞAMASI

// 1. Bankaya gidip hesabımızı açıyoruz
$benimHesabim = new BankaHesabi("Aslan Kral", 1000);

// 2. İşlemler yapıyoruz (Kurallara uygun şekilde)
$benimHesabim->paraYatir(500);  // 500 ekle
$benimHesabim->paraCek(200);    // 200 çıkar
$benimHesabim->paraCek(5000);   // Yetersiz bakiye hatası verecek!

// 3. Son durumu görelim
echo $benimHesabim->bakiyeGoster();


// 🚨 HACKER GİRİŞİMİ! (Aşağıdaki satırın başındaki // işaretlerini silersen ne olur?)
// $benimHesabim->bakiye = 5000000; 

?>