<?php

////////////////////////
$site_type = "html";
require_once 'includes/redirect.php';
///////////////////////////////////
require_once 'includes/db.php';

require_once 'includes/common.php';
///////////////////////////////////
function get_link ($id, $link){
	$id = addslash($id);
	$sql = "SELECT url FROM articles WHERE id = '$id' LIMIT 1";
	$result = @mysqli_query($link, $sql);
		if (@mysqli_num_rows($result) > 0):
			$row = @mysqli_fetch_assoc($result);
			return $row['url'];
		else:
			echo "<h1>Sorry, no such document found</h1>";
			exit();
		endif;
}

function get_url_contents($url){
	$crl = curl_init();
	$timeout = 5;
	curl_setopt ($crl, CURLOPT_URL,$url);
	curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
	$ret = curl_exec($crl);
	curl_close($crl);
	return $ret;
}
// $webpage = get_url_contents($_GET['url']);
//////////////////////////////////////////
$page_url = get_link ($_GET['url'],$link);

//////////////////////////////////////////
/*
if (strpos($page_url, 'punch')):
	$rem_script = "<script type='text/javascript' language='JavaScript' src='scripts/common.js'></script>";
	echo str_replace ($rem_script,"",file_get_contents($page_url));
else:
	header ("Location: $page_url");
endif;
*/
header ("Location: $page_url");



// Print page

?>