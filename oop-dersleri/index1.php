<?php

class Kullanici {
    
    public $isim;
    public $rol;

    // SİHİRLİ FONKSİYON: Yapıcı Metot (Başında iki tane alt tire __ vardır)
    // Bu fonksiyona "Sınıf ayağa kalkarken benden hangi bilgileri isteyecek?" kuralını yazıyoruz.
    public function __construct($gelenIsim, $gelenRol) {
        $this->isim = $gelenIsim;
        $this->rol = $gelenRol;
        
        // Bonus: Nesne üretildiği an ekrana otomatik bilgi bile basabiliriz!
        echo "<small><em>(Sistem Mesajı: Yeni bir nesne üretildi: " . $this->isim . ")</em></small><br>";
    }

    public function kendiniTanit() {
        return "Merhaba, ben <strong>" . $this->isim . "</strong> ve rolüm: " . $this->rol . "<hr>";
    }
}

// ==========================================
// ARTIK ÜRETİM AŞAMASI TEK SATIR! (Amelelik bitti)

$kullanici1 = new Kullanici("Ahmet", "Admin");
echo $kullanici1->kendiniTanit();

$kullanici2 = new Kullanici("Mehmet", "Standart Üye");
echo $kullanici2->kendiniTanit();

// Hatta anında, tek satırda 3. bir kullanıcı daha üretelim!
$kullanici3 = new Kullanici("Ayşe", "Editör");
echo $kullanici3->kendiniTanit();

?>