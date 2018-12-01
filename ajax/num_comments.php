<?php
require_once '../includes/db.php';
require_once '../includes/common.php';
///////////////////////////////////

function get_comm_no ($link, $newsId){
	$newsId = addslash ($newsId);
	$sql = "SELECT COUNT(1) AS num FROM comments WHERE newsId = '$newsId'";
	$result = @mysqli_query($link, $sql);
	$row = @mysqli_fetch_assoc($result);
	return $row['num'];
}
if (!empty($_GET['newsid'])):
	echo get_comm_no ($link,$_GET['newsid'])." Comments";
else:
	echo "N/A";
endif;
?>