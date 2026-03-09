<?php
// 1. Kasayı aç
require_once 'baglan.php';

// 2. Kuryeden gelen ID var mı?
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // 3. SİLME KOMUTU (DELETE)
    // DİKKAT: "WHERE id = ?" yazmazsan kasadaki BÜTÜN görevleri silersin! 
    $sorgu = $db->prepare("DELETE FROM gorevler WHERE id = ?");
    $sil = $sorgu->execute([$id]);

    if ($sil) {
        echo "basarili";
    } else {
        echo "hata_olustu";
    }
}
?>