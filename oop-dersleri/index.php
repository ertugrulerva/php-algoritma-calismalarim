<?php

// 1. SINIF (CLASS) - MİMARİ ÇİZİM / KALIP
// Bu bizim fabrikamızın şablonudur. Sadece bir kez tanımlarız.
class Kullanici1 {
    
    // A. ÖZELLİKLER (Properties) -> Eski adıyla Değişkenler
    public $isim;
    public $rol;

    // B. YETENEKLER (Methods) -> Eski adıyla Fonksiyonlar
    public function kendiniTanit() {
        // $this-> kelimesi "Bu Sınıfın İçindeki" anlamına gelir.
        return "Merhaba, ben " . $this->isim . " ve rolüm: " . $this->rol;
    }
}

// ==========================================

// 2. NESNE (OBJECT) - KALIPTAN ÜRETİLEN GERÇEK ÜRÜNLER
// 'new' kelimesi sihirli kelimedir. "Bana Kullanici kalıbından yeni bir kopya ver" demektir.

$kullanici1 = new Kullanici1(); 
$kullanici1->isim = "Ahmet";
$kullanici1->rol = "Admin";

$kullanici2 = new Kullanici1();
$kullanici2->isim = "Mehmet";
$kullanici2->rol = "Standart Üye";

// 3. SONUÇLARI EKRANA BASALIM
echo "<h3>1. Kullanıcı:</h3>";
echo $kullanici1->kendiniTanit();

echo "<h3>2. Kullanıcı:</h3>";
echo $kullanici2->kendiniTanit();

?>