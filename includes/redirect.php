<?php
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$symbian = strpos($_SERVER['HTTP_USER_AGENT'],"Nokia");
$opmini = strpos($_SERVER['HTTP_USER_AGENT'],"Opera Mini");

if ($iphone || $android || $palmpre || $ipod || $berry || $symbian || $opmini == true) {
	if ($site_type == 'detail'){
		header('Location: http://m.newsng.com/story-detail.php?story='.$_REQUEST['story']);
	}else{
		header('Location: http://m.newsng.com/redirect.html');
		//OR
		echo "<script>window.location='http://m.newsng.com/redirect.html'</script>";
		exit();
	}
	
 }
?>