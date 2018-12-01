<?php

function get_post_share_count($url,$app_id,$app_secret) {
	$urls = 'https://graph.facebook.com/v2.7/?id='. urlencode($url) . '&access_token='. $app_id . '|' . $app_secret;
	$string = @file_get_contents( $urls );
	if($string) {
		$fan_count = json_decode( $string,true );
		return intval($fan_count['share']['share_count']);
	}
}



$app_id = '361222975195';
$app_secret = '5cf538069c3e9b8c8201fee2eff4924b';
$url = 'http://punchng.com/fayose-aregbesola-disagree-sale-national-assets/';

echo get_post_share_count($url,$app_id,$app_secret);
exit();

/*///////////////////////
require_once 'Facebook/Facebook.php';
		
$fb = new Facebook([
	'app_id' => config(),
	'app_secret' => config(),
	'default_graph_version' => 'v2.5'
]);
//////////////////////////*/
		
		
$url = "https://graph.facebook.com/?fields=og_object{likes.limit(0).summary(true)},share&ids=".$url."&access_token=". $app_id . '|' . $app_secret;
//$url = "http://graph.facebook.com/?id=http://www.vanguardngr.com/2016/10/recruit-soldiers-crush-insurgents-rep-tells-fg/"
//curl --silent -X GET 
// create curl resource 
$ch = curl_init(); 

// set url 
curl_setopt($ch, CURLOPT_URL, $url); 

//return the transfer as a string 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

// $output contains the output string 
$output = curl_exec($ch); 

// close curl resource to free up system resources 
curl_close($ch);  


var_dump ($output);



if(isset($_GET['url']))
{
 $url=$_GET['url'];













/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////
 $rest_url = "http://api.facebook.com/restserver.php?format=json&method=links.getStats&urls=".urlencode($url);
 
 $json = json_decode(file_get_contents($rest_url),true);

 echo "Facebook Shares = ".$json[0][share_count];

 echo "Facebook Likes = ".$json[0][like_count];
 
 echo "Facebook Comments = ".$json[0][comment_count];
//////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
}
?>