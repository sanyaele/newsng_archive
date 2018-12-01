<?php
function get_video ($link){
	$sql = "SELECT video FROM videos ORDER BY dateAdded DESC LIMIT 1";
	$result = @mysqli_query($link,$sql);
	$row = @mysqli_fetch_assoc($result);
	return $row['video'];
}
?>