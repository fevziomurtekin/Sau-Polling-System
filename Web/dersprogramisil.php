<?php
ob_start();
if(isset($_GET['ders_adi']) && isset($_GET['tarih']) && isset($_GET['baslangicsaati']) && isset($_GET['bitissaati']) ){
 $con=mysqli_connect("localhost","root","","yoklama");

 $ders_adi=$_GET['ders_adi'];
 $tarih=$_GET['tarih'];
$baslangicsaati=$_GET['baslangicsaati'];
$bitissaati=$_GET['bitissaati'];

 $sil=mysqli_query($con,"DELETE FROM `derszaman` WHERE `ders_id` IN(SELECT `ders_id` FROM `ders` WHERE `ders_adi`='$ders_adi') AND `zaman_id` IN
(SELECT `zaman_id` FROM `zaman` WHERE (`zaman`.`baslangicsaati`='$baslangicsaati' AND zaman.`bitissaati`='$bitissaati' AND `zaman`.`tarih`='$tarih'))");

 if($sil){header("Location:dersprogrami.php");}else{echo "silinemedi";}

}else{echo "post verisi gönderilmedi";}

 ?>