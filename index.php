<?php require_once("baglanti.php");?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Anket Uygulaması</title>
  </head>
  <body>
    <?php require_once('header.php'); 
      $sorucek = $baglanti->prepare("SELECT * FROM sorular");
      $sorucek->execute();
      $Sorular = $sorucek->fetchAll(PDO::FETCH_ASSOC);
      $SoruSayisi = $sorucek->rowCount();

    ?>
    
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4 mt-4">
      <center><h3>Sorular</h3></center> 
      <form method="post">
    <?php 
      if ($SoruSayisi > 0) {
        $Numaralandirma = 0;
        foreach ($Sorular as $Soru) {
          $Numaralandirma++;
          ?>

      <div class="card mt-2">
        <div class="card-header">
           <?php echo $Numaralandirma.". ".$Soru['soru'] ?>
        </div>
         <div class="card-body">
          <blockquote class="blockquote mb-0">
           <input type="hidden" value="<?php echo $Soru['soru_id']; ?>" name="soru_id[]">
           <input type="radio" value="mukemmel" name="<?php echo "soru[]".$Numaralandirma; ?>">
           <input type="radio" value="normal" name="<?php echo "soru[]".$Numaralandirma; ?>">
           <input type="radio" value="kötü" name="<?php echo "soru[]".$Numaralandirma; ?>">
          </blockquote>
        </div>
      </div>

      <?php
        }//foreach kapatma parantezi
         }else{
           echo "<div class='alert alert->danger'>Görüntülenecek soru yok</div>";
         }
        ?>
        <div class="d-grid gap-2 mt-2">
        <input type="submit" class="btn btn-success btn-lg btn-block" name="gonder">
        </div>
        </form>
       
        <?php
        if(isset($_POST['gonder'])) {
          if(isset($_POST['soru'])){
            $GelenCevaplar = $_POST['soru'];
            $Soru_id = $_POST["soru_id"];
            $Cevaplar = array_combine($Soru_id, $GelenCevaplar);
            $ipadresi = $_SERVER['REMOTE_ADDR'];
            $zaman = time();

            foreach($Cevaplar as $soru_ID =>$Cevap){
              $CevapKaydet = $baglanti->prepare("INSERT INTO cevaplar SET soru_id=? , cevap=?");
              $CevapKaydet->execute([
               $soru_ID,
               $Cevap         
              ]);
              if($CevapKaydet) {
                $oyKullaniciKaydet = $baglanti->prepare("INSERT INTO oykullananlar SET ipardesi = ?, tarih = ?");
                $oyKullaniciKaydet->execute([
                  $ipadresi,
                  $zaman
                ]);
              }
            }//foreach kapatma süslüsü
            if($oyKullaniciKaydet) {
              echo "<div class='alert alert-success mt-2'>Anket Cevaplarınız Gönderildi.</div>";
            }
          }
        }
        ?>
        

    </div>
    <div class="col-md-4"></div>
  </div>







    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
<?php $baglanti = " "; ?>