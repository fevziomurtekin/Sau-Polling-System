<?php
ob_start();
if(isset($_GET['ders_id'])){
 $con=mysqli_connect("localhost","root","","yoklama");

 $ders_id=$id =$_GET['ders_id'];

 $sil=mysqli_query($con,"DELETE FROM `ders` WHERE `ders_id`='$ders_id'");

 if($sil){header("Location:ders.php");}else{echo "silinemedi";}

}else{echo "post verisi gönderilmedi";}

 ?>