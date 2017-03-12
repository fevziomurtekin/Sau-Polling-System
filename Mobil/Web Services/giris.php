<?PHP
if(isset($_POST['ogrenci_adisoyadi']) ){
$con=mysqli_connect("localhost","root","","yoklama");
$ad=$_POST['ogrenci_adisoyadi'];
$numara=$_POST['ogrenci_numarasi'];

// programdan post edilen ad ve numara verileri alınır.

		class User {

		public function does_user_exist($ad,$numara)
		{	$con=mysqli_connect("localhost","root","","yoklama");
			$query = "SELECT * from ogrenci where ogrenci_adisoyadi='$ad' and ogrenci_numarasi ='$numara'";

			// ogrenci adı ve numarası veritabanında sorgu yapıldıktan sonra 
			// Eger sonuc 0 dan büyükse ; {"success",1} mesajı gönderilir ve programda gerekli işlem yapılır. 
			// Eger sonuc 0 dan kücükse ; {"error",0} mesajı gönderilir ve programda gerekli işlem yapılır.


			$result = mysqli_query($con, $query);
			if(mysqli_num_rows($result)>0){
				$json['success'] = 1;
				echo json_encode($json);
				mysqli_close($con);
			}else{
				$json['error']=0;
				echo json_encode($json);
				mysqli_close($con);
			}
			
		}
		
	}
	$user = new User();
	if(isset($_POST['ogrenci_adisoyadi'],$_POST['ogrenci_numarasi'])) {
		$username = $_POST['ogrenci_adisoyadi'];
		$password = $_POST['ogrenci_numarasi'];

		// eğer boş gelirse post edilen veriler onun içinde "you must both inputs" mesajı döndürür.
		
		if(!empty($username) && !empty($password)){
			
			$encrypted_password = md5($password);
			$user->does_user_exist($username,$password);
			
		}else{
			echo json_encode("you must type both inputs");
		}
		
	}
}
?>