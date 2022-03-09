


<?php 
require_once("../config.php");
$id =$_GET["id"];
$sql = "DELETE FROM formalani WHERE id=$id";
$stmt= $baglanti->query($sql);
$stmt->execute([$id]);
  if($sql){
    header('Location:formalani.php');
  }
  else{
  echo "silinirken bir hatayla karşılaşıldı";
   }


?>