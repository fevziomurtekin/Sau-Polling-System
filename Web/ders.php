<?php
require_once "index.html";
?>
</br>
<div class="main-page">
<div class="pull-right"><?php echo "<a href=/ders_ekle.php>Yeni ders ekleyin</a>";?></div>
</br>
</br>

<?php
 $con=mysqli_connect("localhost","root","","yoklama");
$ders=mysqli_query($con,"SELECT `ders_id`,`ders_adi` FROM `ders`");
if(mysqli_num_rows($ders)>1){
	echo '<table class="table table-striped table-bordered table-hover">'; 
	echo "<tr><th>Id</th><th>Ders Adı:</th><th>Düzenle/Sil</th></tr>"; 
	while($row = mysqli_fetch_array($ders))
{	
 echo "<tr><td>"; 
  echo $row['ders_id'];
  echo "</td><td>";   
  echo $row['ders_adi'];
  echo "</td><td>";    
  echo "<a href=\"ders_duzenle.php?ders_id=".$row['ders_id']."\">Düzenle</a> \t \t <a href=\"ders_sil.php?ders_id=".$row['ders_id']."\">Sil</a>";
  echo "</td></tr>";
}
echo "</table>";  
} 
?>
</div>