<?php
$sayilar=[12,45,9,76,23,89,4,250,55];
$en_buyuk=$sayilar[0];


for($i=0;$i<count($sayilar);$i++)
{
    if($en_buyuk<$sayilar[$i])
    {
        $en_buyuk=$sayilar[$i];
    }
}
echo $en_buyuk;

?>