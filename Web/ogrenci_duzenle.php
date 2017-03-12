<?php
ob_start();
if(isset($_GET['ogrenci_id'])){
 $con=mysqli_connect("localhost","root","","yoklama");
 require_once "index.html";
 $ogrenci_id=$id =$_GET['ogrenci_id'];
 if(isset($_POST['ogrenci_adisoyadi']) && isset($_POST['ogrenci_numarasi'])){
 $ogrenci_adisoyadi=$_POST['ogrenci_adisoyadi'];
 $ogrenci_numarasi=$_POST['ogrenci_numarasi'];
 $duzenle=mysqli_query($con,"UPDATE `ogrenci` SET `ogrenci_adisoyadi`='$ogrenci_adisoyadi' , `ogrenci_numarasi`='$ogrenci_numarasi' WHERE `ogrenci_id`='$ogrenci_id'");

 if($duzenle){
 	header("Location:ogrenci.php");
 }else{echo "düzenlenmedi";}
 
}else{echo "post verisi gönderilmedi";}
}

 ?>
 <html>
 <div class="main-page">
 <div class="container">
<head>
<title>Öğrenci Bilgilerini Düzenle</title>
</head>
<body>
<h1>Öğrenci Bilgilerini Düzenle</h1>
<br/> <br/>
	<form action="<?PHP $_PHP_SELF ?>" method="post">
		Öğrenci Adı <br/> <br/><input type="text" name="ogrenci_adisoyadi"  /> <br/> <br/>
		Öğrenci Numarası <br/> <br/><input type="text" name="ogrenci_numarasi"  /> <br/> <br/>
		<input type="submit" value="Düzenle" /> <br/>
	</form>
</body>
</div>
</div>
</html>