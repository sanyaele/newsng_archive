<?php
$feedburnerfeed="http://feeds.feedburner.com/TodaysHottestNigerianNews/";
$ch = curl_init();
$useragent=$_SERVER['HTTP_USER_AGENT'];
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $feedburnerfeed);
$data = curl_exec($ch);
curl_close($ch);

echo $data;
?>