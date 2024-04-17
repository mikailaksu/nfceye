<?php
include_once("config.php");
$result = mysqli_query($mysqli, "SELECT * FROM liste ORDER BY id DESC"); // using mysqli_query instead
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<title>ANASAYFA</title>
</head>
<body>
<a class="btn btn-primary mt-5" href="add.html">YENİ ÜRÜN EKLE</a><br/><br/>

	<table class="table table-bordered text-center">

	<tr>
		<td>ID</td>
		<td>NFC KODU</td>
		<td>ÜRÜN ADI</td>
		<td>İŞLEMLER</td>
	</tr>
	<?php 
		while($res = mysqli_fetch_array($result)) { 		
		echo "<tr>";
		echo "<td>".$res['id']."</td>";
		echo "<td>".$res['nfc']."</td>";
		echo "<td>".$res['urunad']."</td>";	
		echo "<td><a class='btn btn-success' href=\"edit.php?id=$res[id]\">DÜZENLE</a> | <a class='btn btn-danger' href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Silmek İstediğinize Emin Misiniz?')\">SİL</a></td>";		
	}
	?>
	</table>
</body>
</html>

