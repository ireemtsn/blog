


<?php 
require_once("../config.php");
$id =$_GET["id"];
$sql = "DELETE FROM kartlar WHERE id=$id";
$stmt= $baglanti->query($sql);
$stmt->execute([$id]);
  if($sql){
    header('Location:kartlar.php');
  }
  else{
  echo "silinirken bir hatayla karşılaşıldı";
   }


?>