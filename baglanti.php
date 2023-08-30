<?php
     try {
        $baglanti = new PDO("mysql:host=localhost;dbname=anketuygulamasi;charset=utf8","root","");
    }catch (Exception $e) {
        echo $e->getMessage();
    }
    
    /*function Filtrele($Deger){
        $a = trim($Deger);
        $b = strip_tags($a);
        $c = htmlspecialchars($b, ENT_QUOTES);
        $Sonuc = $c;
        return $Sonuc;
    }*/


?>