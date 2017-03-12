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




$nesne_katilim=mysqli_query($con,"SELECT `imza_ders`,`imza_adsoyadi`,`imza_numara`,`imza_tarihi`,`imza_saati` FROM `imza` WHERE `imza_ders`='Nesnelerin interneti' AND `imza_tarihi`='$tarih' AND `imza_saati`<'$bitissaati' AND `imza_saati`>='$baslangicsaati' ORDER BY `imza_tarihi`");
// baslangic ve bitis tarihi gelecek.
$nesne_katilim_Sayisi=mysqli_num_rows($nesne_katilim);
$nesne_alim=mysqli_query($con,"SELECT `ders_id` FROM `dersalir` WHERE `ders_id`=1");
$nesne_alimsayisi=mysqli_num_rows($nesne_alim);
$oran=doubleval($nesne_katilim_Sayisi/$nesne_alimsayisi)*100;
     

if(mysqli_num_rows($nesne_katilim)>=1){
  echo '<strong>'.htmlspecialchars("Derse Katılım Yüzdesi: \t").'</strong>';
echo "<progress value='$oran' max='100'> 
</progress>   \t %$oran
";
echo "</br></br>";
	echo '<table class="table table-striped table-bordered table-hover">'; 
	echo "<tr><th>Ders Adı</th><th>Öğrenci Adı Soyadı</th><th>Öğrenci Numarasi</th><th>Ders Tarihi</th><th>Imza Saati</th></tr>"; 

	while($row = mysqli_fetch_array($nesne_katilim))
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