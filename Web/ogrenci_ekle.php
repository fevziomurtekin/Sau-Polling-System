<?php
ob_start();
require_once "index.html";
 $con=mysqli_connect("localhost","root","","yoklama");
 if(isset($_POST['ogrenci_adisoyadi']) && isset($_POST['ogrenci_numarasi'])){
 $ogrenci_adisoyadi=$_POST['ogrenci_adisoyadi'];
 $ogrenci_numarasi=$_POST['ogrenci_numarasi'];
 $ekle=mysqli_query($con,"INSERT INTO `ogrenci` (`ogrenci_adisoyadi`,`ogrenci_numarasi`) VALUES ('$ogrenci_adisoyadi','$ogrenci_numarasi')");

 if($ekle){
 	header("Location:ogrenci.php");
 }else{echo "düzenlenmedi";}
 
}else{}


 ?>
 <html>
 <div class="main-page">
 <div class="container">
<head>
<title>Öğrenci Bilgilerini Düzenle</title>
</head>
<body>
</br>
</br>
<h1>Öğrenci Ekle</h1>
<br/> <br/>
	<form action="<?PHP $_PHP_SELF ?>" method="post">
		Öğrenci Adı <br/> <br/><input type="text" name="ogrenci_adisoyadi"  /> <br/> <br/>
		Öğrenci Numarası <br/> <br/><input type="text" name="ogrenci_numarasi"  /> <br/> <br/>
		<input type="submit" value="Ekle" /> <br/>
	</form>
</body>
</div>
</div>
</html>