<?php
ob_start();
require_once "index.html";
 $con=mysqli_connect("localhost","root","","yoklama");
 if(isset($_POST['ders_adi'])){
 $ders_adi=$_POST['ders_adi'];
 $sinif_id=$_POST['sinif'];
 $ekle=mysqli_query($con,"INSERT INTO `ders` (`ders_adi`,`sinif_id`) VALUES ('$ders_adi','$sinif_id')");

 if($ekle){
 	header("Location:ders.php");
 }else{echo "düzenlenmedi";}
 
}else{}


 ?>
 <html>
 <div class="main-page">
 <div class="container">
<head>
<title>Ders Bilgilerini Düzenle</title>
</head>
<body>
</br>
</br>
<h1>Ders Ekle</h1>
<br/> <br/>
	<form action="<?PHP $_PHP_SELF ?>" method="post">
		Ders Adı <br/> <br/><input type="text" name="ders_adi"  /> <br/> <br/>
		<input type="radio" name="sinif" value="1" checked="on"> 1103<br>
    	<input type="radio" name="sinif" value="2"> 1105<br>
    	<input type="radio" name="sinif" value="3"> 1107<br></br>
		<input type="submit" value="Ekle" /> <br/>
	</form>
</body>
</div>
</div>
</html>