<?php require_once "index.html";?>
</br>
<div class="main-page">
</br>
</br>
<div class="container">
<?php
ob_start();
if(isset($_GET['tarih']) && isset($_GET['baslangicsaati']) && isset($_GET['bitissaati'])){
 $con=mysqli_connect("localhost","root","","yoklama");

  $tarih=$_GET['tarih'];
 $baslangicsaati=$_GET['baslangicsaati'];
 $bitissaati=$_GET['bitissaati'];
 
$opti_katilim=mysqli_query($con,"SELECT `imza_ders`,`imza_adsoyadi`,`imza_numara`,`imza_tarihi`,`imza_saati` FROM `imza` WHERE `imza`.`imza_ders`='Optimizasyon' AND `imza_tarihi`='$tarih' AND `imza_saati`<'$bitissaati' AND `imza_saati`>='$baslangicsaati' ORDER BY `imza_tarihi`");
  $opti_alim=mysqli_query($con,"SELECT `ders_id` FROM `dersalir` WHERE `ders_id`=3");
                $opti_alimsayisi=mysqli_num_rows($opti_alim);
  $opti_katilim_sayisi=mysqli_num_rows($opti_katilim);
if(mysqli_num_rows($opti_katilim)>=1){
    $oran=doubleval($opti_katilim_sayisi/$opti_alimsayisi)*100;
    echo '<strong>'.htmlspecialchars("Derse Katılım Yüzdesi: \t").'</strong>';
echo "<progress value='$oran' max='100'> 
</progress>   \t %$oran
";
	echo '<table class="table table-striped table-bordered table-hover">'; 
	echo "<tr><th>Ders Adı</th><th>Öğrenci Adı Soyadı</th><th>Öğrenci Numarasi</th><th>Ders Tarihi</th><th>Imza Saati</th>th></tr>"; 
	while($row = mysqli_fetch_array($opti_katilim))
{	
 echo "<tr><td>"; 
  echo $row['imza_ders'];
  echo "</td><td>";   
  echo $row['imza_adsoyadi'];
  echo "</td><td>";    
  echo $row['imza_numara'];
  echo "</td><td>";  
  echo $row['imza_tarihi'];
  echo "</td><td>";  
  echo $row['imza_saati'];
  echo "</td></tr>";
}
echo "</table>";  
} 
else{ echo '<strong>'.htmlspecialchars("Derse Katılım Yüzdesi: \t").'</strong>';;
echo "<progress value='0' max='100'> 
</progress>   \t %0
";}
}
?>
  
</div>
</div>