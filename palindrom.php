<?php
$kelime="radar";
$dizi=[];
$z=0;
$yeni_kelime="";    

for($i=strlen($kelime)-1;$i>=0;$i--)
{
$dizi[$z]=$kelime[$i];
$z++;
}

for($i=0;$i<strlen($kelime);$i++)
{
$yeni_kelime=$yeni_kelime.$dizi[$i];
}

echo $yeni_kelime."\n";

if($kelime==$yeni_kelime)
    {
        echo "Bu bir palindromdur.";
    }
    else
    {
        echo "Bu bir palindrom değildir.";
        
    }
?>
