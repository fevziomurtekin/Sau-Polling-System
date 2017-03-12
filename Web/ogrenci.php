<?php
require_once "index.html";
?>
</br>
<div class="main-page">
<div class="pull-right"><?php echo "<a href=/ogrenci_ekle.php>Yeni öğrenci ekleyin</a>";?></div>
</br>
</br>

<?php
 $con=mysqli_connect("localhost","root","","yoklama");
$ogrenci=mysqli_query($con,"SELECT `ogrenci_id`,`ogrenci_adisoyadi`,`ogrenci_numarasi` FROM `ogrenci`");
if(mysqli_num_rows($ogrenci)>1){
	echo '<table class="table table-striped table-bordered table-hover">'; 
	echo "<tr><th>Id</th><th>Öğrenci Adı:</th><th>Öğrenci Numarası</th><th>Düzenle/Sil</th></tr>"; 
	while($row = mysqli_fetch_array($ogrenci))
{	
 echo "<tr><td>"; 
  echo $row['ogrenci_id'];
  echo "</td><td>";   
  echo $row['ogrenci_adisoyadi'];
  echo "</td><td>";    
  echo $row['ogrenci_numarasi'];
  echo "</td><td>";  
  echo "<a href=\"ogrenci_duzenle.php?ogrenci_id=".$row['ogrenci_id']."\">Düzenle</a> \t \t <a href=\"ogrenci_sil.php?ogrenci_id=".$row['ogrenci_id']."\">Sil</a>";
  echo "</td></tr>";
}
echo "</table>";  
} 
?>
</div>
