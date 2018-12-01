<?php
$img['logo'] = "http://www.newsng.com/assets/logo.png";
$img['j1'] = "http://static.jumia.com.ng/items_13/Nigeria/Fashion/Shoes/728x90.gif";
$img['j2'] = "http://static.jumia.com.ng/items_13/Nigeria/Fashion/Clothing/728x90.gif";
$img['j3'] = "http://static.jumia.com.ng/items_13/Nigeria/Beauty/Generic/728x90.gif";
$img['j4'] = "http://static.jumia.com.ng/items_13/Nigeria/Beauty/Makeup/728x90.gif";
$img['j5'] = "http://static.jumia.com.ng/items_13/Nigeria/Mobile/Deal/728x90.gif";
$img['j6'] = "http://static.jumia.com.ng/items_13/Nigeria/Mobile/Samsung/728x90.gif";


$imginfo = getimagesize($img[$_GET['img']]);
header("Content-type: ".$imginfo['mime']);
readfile($img[$_GET['img']]);

?>