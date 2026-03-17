<?php
// 1. Önce hafızaya (Session'a) erişmemiz lazım ki silebilelim
session_start();

// 2. SİHİRLİ KOMUT: Bütün hafızayı, yaka kartlarını ve oturumları anında imha et!
session_destroy();

// 3. Kullanıcıyı kapının dışına (Giriş sayfasına) fırlat
header("Location: giris.php");
exit;
?>