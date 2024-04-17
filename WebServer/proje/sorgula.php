<?php
include("config.php");
if (isset($_GET['nfc'])){
	$id = $_GET['nfc'];
	$result = mysqli_query($mysqli, "SELECT urunad FROM liste WHERE nfc = '$id'"); // using mysqli_query instead
	if (mysqli_num_rows($result) > 0) {
    // Sorgu sonucunda veri varsa
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row["urunad"];
    }
} 
}
else
	header("Location:index.php");
?>
