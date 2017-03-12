<?PHP
if(isset($_POST['imza_ders']) ){
	$con=mysqli_connect("localhost","root","","yoklama");
	date_default_timezone_set('Europe/Istanbul');
	$saat=date('H')+1;
	$dakika=date('i');
	$saat_dakika=$saat.":".$dakika;
	$tarih=date('Y-m-d');

	//tarih ve saat verileri alınır.

	
	$imza_ders=$_POST['imza_ders'];
	$imza_adisoyadi=$_POST['imza_adisoyadi'];
	$imza_numarasi=$_POST['imza_numarasi'];

	// Post edilen imza atılan ders adı , imza atan öğrencinin adı soyadını ve numarasını değişkenlere atarız.


$once=mysqli_query($con,"SELECT * FROM `imza` WHERE (`imza_adsoyadi`='$imza_adisoyadi' AND `imza_numara`='$imza_numarasi' AND `imza_ders`='$imza_ders' AND `imza_tarihi`='$tarih')");

	// Daha önce o gün içerisinde imza attığı bir derse bir daha imza atmaması için yukarıdaki sorguyu çalıstırdık.

if(mysqli_num_rows($once)>0){

	// Eğer attıysa {"error",0} json verisini döndürecek ve programda buna göre işlem yapılacak.

				$json['error']=0;
				echo json_encode($json);
				mysqli_close($con);

	//aynı tarihte , aynı derste , bir öğrenci iki kere imza atamaz.

}else{
	$imza=mysqli_query($con,"INSERT INTO `imza`(`imza_saati`,`imza_tarihi`,`imza_adsoyadi`,`imza_numara`,`imza_ders`) VALUES ('$saat_dakika','$tarih','$imza_adisoyadi','$imza_numarasi','$imza_ders')");

	// Eğer imza atmadıysa {"success",1} json verisini döndürecek ve buna göre işlem yapacak.

	if($imza){	$json['success'] = 1;
				echo json_encode($json);
				mysqli_close($con);}
	else{	$json['error']=0;
				echo json_encode($json);
				mysqli_close($con);}	
}
}
?>