<?php
// 1. Kasayı açalım
require_once 'baglan.php';

// 2. SQL Komutu: "gorevler" tablosundaki her şeyi (*) getir. 
// ORDER BY id DESC: En son eklenen görev en üstte görünsün diye tersten sıralıyoruz.
$sorgu = $db->prepare("SELECT * FROM gorevler ORDER BY id DESC");
$sorgu->execute();

// 3. Gelen tüm satırları bir PHP Dizisi (Array) olarak yakala
// FETCH_ASSOC: Verileri sadece sütun isimleriyle (id, gorev_adi, durum) getir demek.
$gorevler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

// 4. DÜNYANIN EN ÖNEMLİ KISMI: Paketleme
// PHP'nin dizilerini JS doğrudan anlayamaz. O yüzden verileri "JSON" kargo kutusuna çevirip JS'ye fırlatıyoruz!
echo json_encode($gorevler);
?>