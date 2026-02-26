<?php
$sayi=21;
$asalMi=true;

for($i=2;$i<$sayi;$i++)
{
if($sayi%$i==0)
    {
        $asalMi=false;
        echo "$sayi Asal değildir.";
        break;
    }
}
if($asalMi)
    {
        echo "$sayi Asaldır.";
    }
?>