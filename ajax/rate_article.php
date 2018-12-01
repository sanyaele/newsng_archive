<?php
require_once '../includes/db.php';
require_once '../includes/common.php';
///////////////////////////////////
function rate_art ($link,$linkid,$rate){
	$rate = intval( substr(addslash($rate),0,2));
	$linkid = addslash($linkid);
	/////////////////////////////////////////////
	$sql = "INSERT INTO rate_article SET
	linkId = '$linkid',
	rate = '$rate',
	sess = '".session_id()."'
	ON DUPLICATE KEY UPDATE
	rate = '$rate'";
	if (@mysqli_query($link, $sql)):
		return 1;
	else:
		return 0;
	endif;
}

if (!empty($_GET['rate']) && !empty($_GET['linkid'])):
	rate_art($link,$_GET['linkid'],$_GET['rate']);
endif;
?>