<?php
$sayi1=0;
$sayi2=1;

for($i=0;$i<=10;$i++)
{
    echo $sayi1."<br>";
    $yeni_sayi=$sayi1+$sayi2;
    $sayi1=$sayi2;
    $sayi2=$yeni_sayi;
}
    
?>