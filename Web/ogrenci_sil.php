<?php
ob_start();
if(isset($_GET['ogrenci_id'])){
 $con=mysqli_connect("localhost","root","","yoklama");

 $ogrenci_id=$id =$_GET['ogrenci_id'];

 $sil=mysqli_query($con,"DELETE FROM `ogrenci` WHERE `ogrenci_id`='$ogrenci_id'");

 if($sil){header("Location:ogrenci.php");}else{echo "silinemedi";}

}else{echo "post verisi gönderilmedi";}

 ?>