<?php
require_once "index.html";
?>
</br>
<div class="main-page">
</br>
</br>
    <div class="col-md-4 ticket-grid">
    <h1 align="center"><strong>Nesnelerin İnterneti</strong></h1><br>
<?php
 $con=mysqli_connect("localhost","root","","yoklama");
$ogrenci=mysqli_query($con,"SELECT `ders_adi`,`tarih`,`baslangicsaati`,`bitissaati`,`sinif_adi` FROM `ders`
JOIN `sinif` ON sinif.`sinif_id`=ders.`sinif_id`
JOIN `derszaman` ON derszaman.`ders_id`=`ders`.`ders_id`
JOIN `zaman` ON`zaman`.`zaman_id`=`derszaman`.`zaman_id` WHERE `ders_adi`='Nesnelerin interneti' ORDER BY `tarih`
");
if(mysqli_num_rows($ogrenci)>=1){
	echo '<table class="table table-striped table-bordered table-hover">'; 
	echo "<tr><th>Ders Adı</th><th>Ders Tarihi</th><th>Başlangıç Saati</th><th>Bitiş Saati</th></th><th>Sinif</th></tr>"; 
	while($row = mysqli_fetch_array($ogrenci))
{	
 echo "<tr><td>"; 
  echo $row['ders_adi'];
  echo "</td><td>";   
  echo $row['tarih'];
  echo "</td><td>";    
  echo $row['baslangicsaati'];
  echo "</td><td>";  
  echo $row['bitissaati'];
  echo "</td><td>";    
  echo $row['sinif_adi']; 
  echo "</td></tr>";
}
echo "</table>";  
} 
?>
</div>
	</div>
  <div class="col-md-4 ticket-grid">
    <h1 align="center"><strong>Derleyici Tasarımı</strong></h1><br>
<?php
 $con=mysqli_connect("localhost","root","","yoklama");
$ogrenci=mysqli_query($con,"SELECT `ders_adi`,`tarih`,`baslangicsaati`,`bitissaati`,`sinif_adi` FROM `ders`
JOIN `sinif` ON sinif.`sinif_id`=ders.`sinif_id`
JOIN `derszaman` ON derszaman.`ders_id`=`ders`.`ders_id`
JOIN `zaman` ON`zaman`.`zaman_id`=`derszaman`.`zaman_id` WHERE `ders_adi`='Derleyici tasarimi' ORDER BY `tarih`
");
if(mysqli_num_rows($ogrenci)>=1){
  echo '<table class="table table-striped table-bordered table-hover">'; 
  echo "<tr><th>Ders Adı</th><th>Ders Tarihi</th><th>Başlangıç Saati</th><th>Bitiş Saati</th></th><th>Sinif</th></tr>"; 
  while($row = mysqli_fetch_array($ogrenci))
{ 
 echo "<tr><td>"; 
  echo $row['ders_adi'];
  echo "</td><td>";   
  echo $row['tarih'];
  echo "</td><td>";    
  echo $row['baslangicsaati'];
  echo "</td><td>";  
  echo $row['bitissaati'];
  echo "</td><td>";    
  echo $row['sinif_adi']; 
  echo "</td></tr>";
}
echo "</table>";  
} 
?>
</div>
  </div>
  <div class="col-md-4 ticket-grid">
    <h1 align="center"><strong>Optimizasyon</strong></h1><br>
<?php
 $con=mysqli_connect("localhost","root","","yoklama");
$ogrenci=mysqli_query($con,"SELECT `ders_adi`,`tarih`,`baslangicsaati`,`bitissaati`,`sinif_adi` FROM `ders`
JOIN `sinif` ON sinif.`sinif_id`=ders.`sinif_id`
JOIN `derszaman` ON derszaman.`ders_id`=`ders`.`ders_id`
JOIN `zaman` ON`zaman`.`zaman_id`=`derszaman`.`zaman_id` WHERE `ders_adi`='Optimizasyon' ORDER BY `tarih`
");
if(mysqli_num_rows($ogrenci)>=1){
  echo '<table class="table table-striped table-bordered table-hover">'; 
  echo "<tr><th>Ders Adı</th><th>Ders Tarihi</th><th>Başlangıç Saati</th><th>Bitiş Saati</th></th><th>Sinif</th></tr>"; 
  while($row = mysqli_fetch_array($ogrenci))
{ 
 echo "<tr><td>"; 
  echo $row['ders_adi'];
  echo "</td><td>";   
  echo $row['tarih'];
  echo "</td><td>";    
  echo $row['baslangicsaati'];
  echo "</td><td>";  
  echo $row['bitissaati'];
  echo "</td><td>";    
  echo $row['sinif_adi']; 
  echo "</td></tr>";
}
echo "</table>";  
} 
?>
</div>
  </div>
