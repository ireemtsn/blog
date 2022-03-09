<?php
include("config.php");   
session_start();        // admin panelinde giriş yapmadan girmemek için yazılan kod  
  if (isset($_SESSION['oturum'])) {         // BUNA COK GEREK YOK 
      
  }else {
      header("Location:giris.php");
   }
  

          if ($_POST) { // Post olup olmadığını kontrol ediyoruz.
                  $baslik = $_POST['baslik'];
                  $hata = '';
   
   
                  if ($_FILES["foto"]["name"] != "") {
                   $foto = strtolower($_FILES['foto']['name']);
                   if (file_exists('images/' . $foto)) {
                       $hata = "$foto diye bir dosya var";
                   } else {
                       $boyut = $_FILES['foto']['size'];
                       if ($boyut > (1920 * 1080 * 20)) {
                           $hata = 'Dosya boyutu 20MB den büyük olamaz.';
                       } else {
                           $dosya_tipi = $_FILES['foto']['type'];
                           $dosya_uzanti = explode('.', $foto);
                           $dosya_uzanti = $dosya_uzanti[count($dosya_uzanti) - 1];
   
                           if (!in_array($dosya_tipi, ['image/png', 'image/jpeg']) || !in_array($dosya_uzanti, ['png', 'jpg'])) {
                               //if (($dosya_tipi != 'image/png' || $dosya_uzanti != 'png' )&&( $dosya_tipi != 'image/jpeg' || $dosya_uzanti != 'jpg')) {
                               $hata = 'Hata, dosya türü JPEG veya PNG olmalı.';
                           } else {
                               $dosya = $_FILES["foto"]["tmp_name"];
                               copy($dosya, "../fotograf/" . $foto);
                               
                           }
                       }
                   }
               } else {
                   //Eğer kullanıcı fotoğraf seçmedi ise veri tabanındaki resimi değiştirmiyoruz
                   
               }

               if ($hata == "") { // Veri alanlarının boş olmadığını kontrol ettiriyoruz.
                   //Değişecek veriler
                   $satir = [
                    'baslik' => $baslik,
                    'foto' => $foto,
                ];
                   // Veri güncelleme sorgumuzu yazıyoruz.
                $sql = "INSERT INTO album SET foto=:foto, baslik=:baslik";             
                $durum = $baglanti->prepare($sql)->execute($satir);
   
                if ($durum)
                {
                   header("Location:album.php");
               } else {
                       echo 'Düzenleme hatası oluştu: '; // id bulunamadıysa veya sorguda hata varsa hata yazdırıyoruz.
                   }
               } 
               if ($hata != "") {
           echo '<script>swal("Hata","' . $hata . '","error");</script>';
       }
           }





   // -----------------------------------------------------

    $sorgu = $baglanti->query("SELECT * FROM album ORDER BY id DESC LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);
  
   
   
   ?>
<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
      <title>Hello, world!</title>

        <style>
           .lightbox-gallery {
   
   
    color: #000;
    overflow-x: hidden
}

.lightbox-gallery p {
    color: #fff
}

.lightbox-gallery h2 {
    font-weight: bold;
    margin-bottom: 40px;
    padding-top: 40px;
    color: #fff
}

@media (max-width:767px) {
    .lightbox-gallery h2 {
        margin-bottom: 25px;
        padding-top: 25px;
        font-size: 24px
    }
}

.lightbox-gallery .intro {
    font-size: 16px;
    max-width: 500px;
    margin: 0 auto 40px
}

.lightbox-gallery .intro p {
    margin-bottom: 0
}

.lightbox-gallery .photos {
    padding-bottom: 20px
}

.lightbox-gallery .item {
    padding-bottom: 30px
}
        </style>

   </head>
   <body class="bg-dark">




      <div class="container">
         <div class="row justify-content-center " style="margin-top: 200px">
            <div class="card w-25" >
               <div class="card-header">
                  Albüm Ekle
               </div>
               <div class="card-body">
                  <form action="" method="POST" enctype="multipart/form-data">
                  <div class="form-group mt-3">
                        <label class="mb-3" for="exampleFormControlFile1">Başlık</label><br>
                        <input type="text" name="baslik" class="form-control-file mb-3">
                     </div>
                     <div class="form-group mt-3">
                        <label class="mb-3" for="exampleFormControlFile1">Resim Ekle</label><br>
                        <input type="file" name="foto" class="form-control-file mb-3" id="exampleFormControlFile1">
                     </div>
                     <button style="width:50%"  type="submit" class="btn btn-primary">Ekle</button>
               </div>
               </form>
            </div>
         </div>
      </div>
              
              
    

<div class="lightbox-gallery">
    <div class="container">
        <div class="intro">
            <h2 class="text-center">Lightbox Gallery</h2>
            <p class="text-center">Find the lightbox gallery for your project. click on any image to open gallary</p>
        </div>
        <div class="row photos">

        <?php foreach ($sorgu as $row) { ?>
            <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="../img/<?=$row['foto']?>"   data-lightbox="photos"><img class="img-fluid" src="../img/<?=$row['foto']?>" ></a></div>
          
          <?php } ?>
        </div>

    </div>
</div>

      



      <!-- Optional JavaScript; choose one of the two! -->
      <!-- Option 1: Bootstrap Bundle with Popper -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
      <!-- Option 2: Separate Popper and Bootstrap JS -->
      <!--
         <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
         -->
   </body>
</html>