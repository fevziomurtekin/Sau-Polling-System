<?PHP
if(isset($_POST['beacon_uuid']) ){
	date_default_timezone_set('Europe/Istanbul');
	$saat=date('H')+1;
	$tarih=date('Y-m-d');	

	//tarih ve saat verileri alınır.
	
	$con=mysqli_connect("localhost","root","","yoklama");
	$beacon_uuid=$_POST['beacon_uuid'];
	$beacon_major=$_POST['beacon_major'];
	$beacon_minor=$_POST['beacon_minor'];
	$ad=$_POST['ogrenci_adisoyadi'];
	$numara=$_POST['ogrenci_numarasi'];

	// Localhosta bağlanıp , Programdan post edilen veriler değişkenlere atanır.

	// post edilen paremetreler yanı sıra tarih ve saati  uyan dersin adını alırız.Eğer ders varsa  ona göre sorgu yaparız.

	$ders_adi=mysqli_query($con,"SELECT  `ders_adi` AS ad FROM `ogrenci`
JOIN `dersalir` ON `ogrenci`.`ogrenci_id`=`dersalir`.`ogrenci_id`
JOIN `ders` ON `ders`.`ders_id`=`dersalir`.`ders_id`
JOIN `sinif` ON `sinif`.`sinif_id`=`ders`.`sinif_id`
JOIN `beacon` ON `beacon`.`beacon_id`=`sinif`.`beacon_id`
JOIN `derszaman` ON `derszaman`.`ders_id`=`ders`.`ders_id`
JOIN `zaman` ON`zaman`.`zaman_id`=`derszaman`.`zaman_id`
WHERE (`ogrenci_adisoyadi`='$ad' AND `ogrenci_numarasi`='$numara' AND `beacon_uuid`='$beacon_uuid' AND `beacon_major`='$beacon_major' AND `beacon_minor`='$beacon_minor' AND 
	`baslangicsaati`<='$saat' AND `bitissaati`>'$saat' AND `tarih`='$tarih' )");
	
	
	 $sayi=mysqli_num_rows($ders_adi);
	if($sayi>0){

		

	$nesne=mysqli_query($con,"SELECT  `ders_adi` AS ad FROM `ogrenci`
JOIN `dersalir` ON `ogrenci`.`ogrenci_id`=`dersalir`.`ogrenci_id`
JOIN `ders` ON `ders`.`ders_id`=`dersalir`.`ders_id`
JOIN `sinif` ON `sinif`.`sinif_id`=`ders`.`sinif_id`
JOIN `beacon` ON `beacon`.`beacon_id`=`sinif`.`beacon_id`
JOIN `derszaman` ON `derszaman`.`ders_id`=`ders`.`ders_id`
JOIN `zaman` ON`zaman`.`zaman_id`=`derszaman`.`zaman_id`
WHERE (`ders_adi`='Nesnelerin interneti' AND `ogrenci_adisoyadi`='$ad' AND `ogrenci_numarasi`='$numara' AND `beacon_uuid`='$beacon_uuid' AND `beacon_major`='$beacon_major' AND `beacon_minor`='$beacon_minor' AND 
	`baslangicsaati`<='$saat' AND `bitissaati`>'$saat' AND `tarih`='$tarih' )");

	// Nesnelerin interneti dersi varsa $nesne değişkenine atanır.

	$derleyici=mysqli_query($con,"SELECT  `ders_adi` AS ad FROM `ogrenci`
JOIN `dersalir` ON `ogrenci`.`ogrenci_id`=`dersalir`.`ogrenci_id`
JOIN `ders` ON `ders`.`ders_id`=`dersalir`.`ders_id`
JOIN `sinif` ON `sinif`.`sinif_id`=`ders`.`sinif_id`
JOIN `beacon` ON `beacon`.`beacon_id`=`sinif`.`beacon_id`
JOIN `derszaman` ON `derszaman`.`ders_id`=`ders`.`ders_id`
JOIN `zaman` ON`zaman`.`zaman_id`=`derszaman`.`zaman_id`
WHERE (`ders_adi`='Derleyici tasarimi' AND `ogrenci_adisoyadi`='$ad' AND `ogrenci_numarasi`='$numara' AND `beacon_uuid`='$beacon_uuid' AND `beacon_major`='$beacon_major' AND `beacon_minor`='$beacon_minor' AND 
	`baslangicsaati`<='$saat' AND `bitissaati`>'$saat' AND `tarih`='$tarih' )");

	// Derleyici dersi varsa $derleyici değişkenine atanır.

	$mobil=mysqli_query($con,"SELECT  `ders_adi` AS ad FROM `ogrenci`
JOIN `dersalir` ON `ogrenci`.`ogrenci_id`=`dersalir`.`ogrenci_id`
JOIN `ders` ON `ders`.`ders_id`=`dersalir`.`ders_id`
JOIN `sinif` ON `sinif`.`sinif_id`=`ders`.`sinif_id`
JOIN `beacon` ON `beacon`.`beacon_id`=`sinif`.`beacon_id`
JOIN `derszaman` ON `derszaman`.`ders_id`=`ders`.`ders_id`
JOIN `zaman` ON`zaman`.`zaman_id`=`derszaman`.`zaman_id`
WHERE (`ders_adi`='Mobil Uygulama Geliştirme' AND `ogrenci_adisoyadi`='$ad' AND `ogrenci_numarasi`='$numara' AND `beacon_uuid`='$beacon_uuid' AND `beacon_major`='$beacon_major' AND `beacon_minor`='$beacon_minor' AND 
	`baslangicsaati`<='$saat' AND `bitissaati`>'$saat' AND `tarih`='$tarih' )");

	// Mobil uygulama dersi varsa $mobil değişkenine atanır.

	$opti=mysqli_query($con,"SELECT  `ders_adi` AS ad FROM `ogrenci`
JOIN `dersalir` ON `ogrenci`.`ogrenci_id`=`dersalir`.`ogrenci_id`
JOIN `ders` ON `ders`.`ders_id`=`dersalir`.`ders_id`
JOIN `sinif` ON `sinif`.`sinif_id`=`ders`.`sinif_id`
JOIN `beacon` ON `beacon`.`beacon_id`=`sinif`.`beacon_id`
JOIN `derszaman` ON `derszaman`.`ders_id`=`ders`.`ders_id`
JOIN `zaman` ON`zaman`.`zaman_id`=`derszaman`.`zaman_id`
WHERE (`ders_adi`='Optimizasyon' AND `ogrenci_adisoyadi`='$ad' AND `ogrenci_numarasi`='$numara' AND `beacon_uuid`='$beacon_uuid' AND `beacon_major`='$beacon_major' AND `beacon_minor`='$beacon_minor' AND 
	`baslangicsaati`<='$saat' AND `bitissaati`>'$saat' AND `tarih`='$tarih' )");
	
	// Optimizasyon dersi varsa $opti değişkenine atanır.

		if(mysqli_num_rows($nesne))
			{	$json['success'] = 1;
				echo json_encode($json);
				mysqli_close($con);}

				//nesne dersi varsa {"success",1} döndürür. Programda gerekli işlemler yapılır.
	
	
		
		if(mysqli_num_rows($derleyici))
			{	$json['success'] = 2;
				echo json_encode($json);
				mysqli_close($con);}	

				//derleyici dersi varsa {"success",2} döndürür. Programda gerekli işlemler yapılır.
	
	
	
		if(mysqli_num_rows($mobil))
			{	$json['success'] = 3;
				echo json_encode($json);
				mysqli_close($con);}	

				//mobil dersi varsa {"success",3} döndürür. Programda gerekli işlemler yapılır.
		
		
		if(mysqli_num_rows($opti))
			{	$json['success'] = 4;
				echo json_encode($json);
				mysqli_close($con);}	
		
			//optimizasyon dersi varsa {"success",4} döndürür. Programda gerekli işlemler yapılır.
	

	}
	else{
				$json['error']=0;
				echo json_encode($json);
				mysqli_close($con);

			//ders yoksa {"error",0} döndürür. Programda gerekli işlemler yapılır.
	
	
	}

	
	
}

?>
