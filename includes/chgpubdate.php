<?php
function chgpubdate($link, $dat){
	$sql = "UPDATE currdate SET currDate='$dat'";
	$result = @mysqli_query($link, $sql);
}

function getpubdate($link){
	$sql = "SELECT currDate FROM currdate LIMIT 1";
	$result = @mysqli_query($link, $sql);
	$row = @mysqli_fetch_assoc($result);
	return $row['currDate'];
}
?>