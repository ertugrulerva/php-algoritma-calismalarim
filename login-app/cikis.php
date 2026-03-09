<?php
// 1. Önce hafıza sistemini çağır
session_start();

// 2. HAFIZAYI SİL (Yaka kartını yırt at!)
// Bu komut, bu kullanıcıya ait olan $_SESSION içindeki her şeyi (id, ad_soyad) anında yok eder.
session_destroy();

// 3. Adamı tekrar giriş kapısına (index.php) yönlendir.
header("Location: index.php");
exit;
?>