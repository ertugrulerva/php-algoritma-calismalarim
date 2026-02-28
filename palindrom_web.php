<?php
$mesaj="";
if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $kelime=$_POST["kelime"];
        $yeni_kelime="";
        for($i=strlen($kelime)-1;$i>=0;$i--)
        {
            $yeni_kelime=$yeni_kelime.$kelime[$i];
        }
        if($kelime==$yeni_kelime)
        {
            $mesaj="Tebrikler! <b>'$kelime'</b> bir palindromdur.";
        }
        else
        {
            $mesaj="Maalesef! <b>'$kelime'</b> bir palindrom değildir.";
        }
    }
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palindrom Kontrol Makinesi</title>
    <style>
        body {
        background-color: #f4f4f9; /* Sayfanın arka plan rengi (Açık gri) */
        font-family: Arial, sans-serif; /* Kullanılacak yazı tipi */
        text-align: center; /* Sayfadaki her şeyi tam ortaya hizala */
        margin-top: 50px; /* Sayfanın en üstünden 50 piksel boşluk bırak */
    }
    form {
        background-color: white; /* Kartın içi beyaz olsun */
        width: 300px; /* Genişliği 300 piksel olsun */
        margin: 0 auto; /* Kutuyu ekranın tam ortasına getirir (sağdan soldan otomatik boşluk) */
        padding: 20px; /* Kutunun İÇİNDEKİ boşluk (yazılar kenarlara yapışmasın diye) */
        border-radius: 10px; /* Kutunun köşelerini 10 piksel yuvarlat (yumuşak görünüm) */
        box-shadow: 0px 4px 8px rgba(0,0,0,0.1); /* Kutuya hafif bir gölge ekle (Derinlik katar) */
    }
    input[type="text"] {
        width: 90%; /* Kutunun genişliğini formun %90'ı kadar yap */
        padding: 10px; /* İç boşluk (yazı rahat sığsın) */
        margin-bottom: 15px; /* Altındaki butonla arasına 15 piksel boşluk bırak */
        border: 1px solid #ccc; /* Etrafına ince, gri bir çizgi (çerçeve) çek */
        border-radius: 5px; /* Çerçevenin köşelerini hafif yuvarlat */
    }
    button {
        background-color: #007bff; /* Arka planı mavi yap */
        color: white; /* İçindeki yazının rengi beyaz olsun */
        padding: 10px 20px; /* İç boşluklar (Butonu dolgunlaştırır) */
        border: none; /* Çerçevesini tamamen kaldır */
        border-radius: 5px; /* Köşeleri yuvarlat */
        cursor: pointer; /* Fareyle üzerine gelince imleci "el" işaretine (tıklanabilir) çevir */
    }
    button:hover {
        background-color: #0056b3; /* Fare üstüne gelince maviyi biraz koyulaştır */
    }
    </style>

</head>
<body>
    <h2>Palindrom Kontrol Makinesine Hoş Geldin!</h2>
    <p>Tersten okunuşu da aynı olan bir kelime girin:</p>

    <form action="" method="post">
    <label for="kelime_kutusu">Kelime:</label>
    <input type="text" id="kelime_kutusu" name="kelime" placeholder="Örn: radar" required>
    <button type="submit">Kontrol Et</button>
    </form>
    <hr>
    <h3>Sonuç: <?php echo $mesaj; ?></h3>

</body>
</html>