<?php
ob_start();
if(isset($_GET['ders_id'])){
 $con=mysqli_connect("localhost","root","","yoklama");
 require_once "index.html";
 $ders_id=$id =$_GET['ders_id'];
 if(isset($_POST['ders_adi'])){
 $ders_adi=$_POST['ders_adi'];
 $duzenle=mysqli_query($con,"UPDATE `ders` SET `ders_adi`='$ders_adi' WHERE `ders_id`='$ders_id'");

 if($duzenle){
 	header("Location:ders.php");
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
		Ders Adı <br/> <br/><input type="text" name="ders_adi"  /> <br/> <br/>
		<input type="submit" value="Düzenle" /> <br/>
	</form>
</body>
</div>
</div>
</html>