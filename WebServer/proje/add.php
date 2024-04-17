<!DOCTYPE html>
<ht lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<title>VERİ EKLEME</title>
</head>

	
<body>
	
<?php
include_once("config.php");

if(isset($_POST['Submit'])) {	
	$nfc = mysqli_real_escape_string($mysqli, $_POST['nfc']);
	$urunad = mysqli_real_escape_string($mysqli, $_POST['urunad']);
		
	if(empty($nfc) || empty($urunad)) {
				
		if(empty($nfc)) {
			echo "<font color='red'>NFC Kodu Boş Geçilemez!!!</font><br/>";
		}
		
		if(empty($urunad)) {
			echo "<font color='red'>Ürün Adı Boş Geçilemez!!!</font><br/>";
		}
		
		
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		
		$result = mysqli_query($mysqli, "INSERT INTO liste(nfc,urunad) VALUES('$nfc','$urunad')");
		
		//display success message
		echo "<font  color='green'>Veri Ekleme İşlemi Başarılı";
		echo "<br/><a class='btn btn-primary' href='index.php'>Geri Dön</a>";
	}
}
?>
</body>
</html>
