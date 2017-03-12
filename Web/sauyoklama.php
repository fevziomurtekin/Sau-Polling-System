<?php
require_once "index.html";
$tarih=date('Y-m-d');
?>
</br>
	<div class="main-page">
			
				<!-- four-grids -->
				<div class="row four-grids">
					<div class="col-md-4 ticket-grid">
						<div class="tickets">
							<div class="grid-left">
								<div class="book-icon">
									<i class="fa fa-book"></i>
								</div>
							</div>
							<div class="grid-right">
								<a href="ders.php"><h3>Ders <span>Sayısı</span></h3></a>
								<p><?php $con=mysqli_connect("localhost","root","","yoklama");
								$ders=mysqli_query($con,"SELECT `ders_id` FROM `ders`");
								$ders_sayisi=mysqli_num_rows($ders);
								echo $ders_sayisi;?></p> 
							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
			
					<div class="col-md-4 ticket-grid">
						<div class="tickets">
							<div class="grid-left">
								<div class="book-icon">
									<i class="fa fa-bar-chart"></i>
								</div>
							</div>
							<div class="grid-right">
							</br>
								<a href="dersprogrami.php"><h3 >Ders <span>Programı</span></h3></a>
				
								
							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
					<div class="col-md-4 ticket-grid">
						<div class="tickets">
							<div class="grid-left">
								<div class="book-icon">
									<i class="fa fa-user"></i>
								</div>
							</div>
							<div class="grid-right">
								<a href="ogrenci.php"><h3>Öğrenci <span>Sayısı</span></h3></a>
								<p><?php $con=mysqli_connect("localhost","root","","yoklama");
								$ogrenci=mysqli_query($con,"SELECT `ogrenci_id` FROM `ogrenci`");
								$ogrenci_sayisi=mysqli_num_rows($ogrenci);
								echo $ogrenci_sayisi;?></p>
							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
					<div class="clearfix"> </div>
				</div>
				</br>
				<h1 align="center">Derslere Katılım</h1>
				</br><div class="col-md-6">
						<div class="tickets">
							<div class="grid-left">
								<div class="book-icon">
									<i class="fa fa-book"></i>
								</div>
							</div>
							<div class="grid-right">
								<a href="ogrenci.php"><h3 align="center">Nesnelerin  <span>İnterneti</span></h3></a>
								</br>
								<p><?php $con=mysqli_connect("localhost","root","","yoklama");
								$nesne=mysqli_query($con,"SELECT `ders_adi`,`tarih`,`baslangicsaati`,`bitissaati` FROM `ders`
JOIN `sinif` ON sinif.`sinif_id`=ders.`sinif_id`
JOIN `derszaman` ON derszaman.`ders_id`=`ders`.`ders_id`
JOIN `zaman` ON`zaman`.`zaman_id`=`derszaman`.`zaman_id` WHERE `ders_adi`='Nesnelerin interneti' ORDER BY `tarih`");
								$nesne_alim=mysqli_query($con,"SELECT `ders_id` FROM `dersalir` WHERE `ders_id`=1");
								$nesne_alimsayisi=mysqli_num_rows($nesne_alim);

								if(mysqli_num_rows($nesne)>1){
	echo '<table class="table table-striped table-bordered table-hover">'; 
	echo "<tr><th>Ders Adı</th><th>Ders Tarihi</th><th>Başlangıç Saati</th><th>Bitiş Saati</th><th>Dersi Alan Öğrenci</th><th>Dersi Katılım</th></tr>"; 
	while($row = mysqli_fetch_array($nesne))
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
  echo $nesne_alimsayisi;
   echo "</td><td>"; 
   if($tarih>$row['tarih']){
 echo "<a href=\"nesne_katilim.php?tarih=".$row['tarih']."&baslangicsaati=".$row['baslangicsaati']."&bitissaati=".$row['bitissaati']."\">Derse katilimi gör</a>";}
 else{echo "Ders islenmedi.";}
  echo "</td></tr>";
}
echo "</table>";  
} 
?></p>
							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
						<div class="tickets">
							<div class="grid-left">
								<div class="book-icon">
									<i class="fa fa-book"></i>
								</div>
							</div>
							<div class="grid-right">
								<a href="ogrenci.php"><h3 align="center">Derleyici  <span>Tasarımı</span></h3></a>
								</br>
								<p><?php $con=mysqli_connect("localhost","root","","yoklama");
								$derleyici=mysqli_query($con,"SELECT `ders_adi`,`tarih`,`baslangicsaati`,`bitissaati` FROM `ders`
JOIN `sinif` ON sinif.`sinif_id`=ders.`sinif_id`
JOIN `derszaman` ON derszaman.`ders_id`=`ders`.`ders_id`
JOIN `zaman` ON`zaman`.`zaman_id`=`derszaman`.`zaman_id` WHERE `ders_adi`='Derleyici tasarimi'ORDER BY `tarih`");
								$derleyici_alim=mysqli_query($con,"SELECT `ders_id` FROM `dersalir` WHERE `ders_id`=2");
								$derleyici_alimsayisi=mysqli_num_rows($derleyici_alim);

								if(mysqli_num_rows($derleyici)>1){
	echo '<table class="table table-striped table-bordered table-hover">'; 
	echo "<tr><th>Ders Adı</th><th>Ders Tarihi</th><th>Başlangıç Saati</th><th>Bitiş Saati</th><th>Dersi Alan Öğrenci</th><th>Dersi Katılım</th></tr>"; 
	while($row = mysqli_fetch_array($derleyici))
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
  echo $nesne_alimsayisi;
   echo "</td><td>"; 
   if($tarih>$row['tarih']){
   echo "<a href=\"derleyici_katilim.php?tarih=".$row['tarih']."&baslangicsaati=".$row['baslangicsaati']."&bitissaati=".$row['bitissaati']."\">Derse katilimi gör</a>";}
   else{echo "Ders islenmedi.";}
  echo "</td></tr>";
}
echo "</table>";  
} 
?></p>
							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
				</div>
	
		<div class="col-md-6">
						<div class="tickets">
							<div class="grid-left">
								<div class="book-icon">
									<i class="fa fa-book"></i>
								</div>
							</div>
							<div class="grid-right">
								<a href="ogrenci.php"><h3 align="center">Optimizasyon </span></h3></a>
								</br>
								<p><?php $con=mysqli_connect("localhost","root","","yoklama");
								$opti=mysqli_query($con,"SELECT `ders_adi`,`tarih`,`baslangicsaati`,`bitissaati` FROM `ders`
JOIN `sinif` ON sinif.`sinif_id`=ders.`sinif_id`
JOIN `derszaman` ON derszaman.`ders_id`=`ders`.`ders_id`
JOIN `zaman` ON`zaman`.`zaman_id`=`derszaman`.`zaman_id` WHERE `ders_adi`='Optimizasyon' ORDER BY `tarih`");
								$opti_alim=mysqli_query($con,"SELECT `ders_id` FROM `dersalir` WHERE `ders_id`=3");
								$opti_alimsayisi=mysqli_num_rows($opti_alim);
								if(mysqli_num_rows($opti)>1){
	echo '<table class="table table-striped table-bordered table-hover">'; 
	echo "<tr><th>Ders Adı</th><th>Ders Tarihi</th><th>Başlangıç Saati</th><th>Bitiş Saati</th><th>Dersi Alan Öğrenci</th><th>Dersi Katılım</th></tr>"; 
	while($row = mysqli_fetch_array($opti))
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
  echo $nesne_alimsayisi;
   echo "</td><td>"; 
   if($tarih>$row['tarih']){
   echo "<a href=\"opti_katilim	.php?tarih=".$row['tarih']."&baslangicsaati=".$row['baslangicsaati']."&bitissaati=".$row['bitissaati']."\">Derse katilimi gör</a>";}
   else{echo "Ders islenmedi.";}
  echo "</td></tr>";
}
echo "</table>";  
} 
?></p>
							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
				</div>