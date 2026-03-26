<?php

// 1. ANA SINIF (Parent Class) - Temel Özellikler Burada!
class Kullanici {
    public $isim;
    public $eposta;

    public function __construct($isim, $eposta) {
        $this->isim = $isim;
        $this->eposta = $eposta;
    }

    public function girisYap() {
        return "🟢 <b>{$this->isim}</b> sisteme başarıyla giriş yaptı.<br>";
    }
}

// ==========================================

// 2. ALT SINIF (Child Class) - 'extends' sihirli kelimesidir!
// "Admin bir Kullanıcıdır. Kullanıcının tüm yeteneklerini miras alsın!"
class Admin extends Kullanici {
    
    public $yetkiSeviyesi = "Süper Yönetici";

    // Ana sınıfta OLMAYAN, sadece Admin'e özel bir yetenek:
    public function kullaniciSil($silinecekKisi) {
        return "🚨 <b>DİKKAT:</b> Admin {$this->isim}, sistemden '{$silinecekKisi}' adlı kullanıcıyı SİLDİ!<br>";
    }
}

// ==========================================

// 3. ALT SINIF 2 - Başka bir mirasçı
class IcerikUretici extends Kullanici {
    
    // Sadece İçerik Üreticisine özel yetenek:
    public function makaleYaz($baslik) {
        return "📝 <b>{$this->isim}</b> yeni bir makale yayınladı: <i>{$baslik}</i><br>";
    }
}

// ==========================================
// KULLANIM AŞAMASI

echo "<h3>Sistem Hareketleri:</h3>";

// 1. Normal Kullanıcı
$normalUye = new Kullanici("Ahmet Yılmaz", "ahmet@mail.com");
echo $normalUye->girisYap();
// $normalUye->kullaniciSil("Mehmet"); // YANLIŞ! Normal üyenin böyle bir yetkisi yok, hata verir.

echo "<hr>";

// 2. Admin (Mirasçı)
$patron = new Admin("Aslan Kral", "aslan@mail.com");
echo $patron->girisYap(); // BEDAVA YETENEK! Admin sınıfına 'girisYap' yazmadık ama miras aldığı için çalışır!
echo $patron->kullaniciSil("Zararlı_Hesap_01"); // Kendine has yeteneği

echo "<hr>";

// 3. İçerik Üretici (Mirasçı)
$yazar = new IcerikUretici("Zeynep", "zeynep@mail.com");
echo $yazar->girisYap(); // Yine bedava yetenek
echo $yazar->makaleYaz("Laravel'e Neden Geçmeliyiz?"); // Kendine has yeteneği

?>