<?php
require_once 'includes/db.php';
require_once 'includes/common.php';
require_once 'includes/functions.php';
//////////////////////////////////////
$cat_s = strtolower(addslash($_REQUEST['cat']));

if ($cat_s == 'business' || $cat_s == 'entertainment' || $cat_s == 'fashion' || $cat_s == 'news' || $cat_s == 'politics' || $cat_s == 'sports' || $cat_s == 'technology' || $cat_s == 'health'): //Select a valid category
	$cat_c = ucfirst($cat_s);
	$cat_w = ucfirst($cat_s);
else:
	$cat_c = '';
	$cat_w = 'General';
endif;


if (!empty($_GET['dy']) && strlen($_GET['dy']) == 10):
	$pubdate = str_replace ("_", "-", addslash (substr ($_GET['dy'],0,11)));
else: // Set a default date
	$pubdate = "";
endif;

if (!empty($_GET['jid'])):
	$jid = addslash($_GET['jid']);
else:
	$jid = "";
endif;

$result = get_arts ($link, $cat_c, $pubdate, $jid);

$i=0;
while ($rows = @mysqli_fetch_assoc($result)){
	/*
	$det[$i]['id'] = $rows['id'];
	$det[$i]['title'] = $rows['title'];
	$det[$i]['description'] = $rows['description'];
	$det[$i]['img'] = $rows['img'];
	$det[$i]['source'] = $rows['source'];
	$det[$i]['link'] = "http://newsng.com/".$rows['code'];
	$det[$i]['orig'] = $rows['url'];
	$det[$i]['social_score'] = $rows['social_score'];
	
	$i++;
	*/
	
	$array[] = array(
    'id'       => $rows['id'],
    'title' => $rows['title'],
    'description' => $rows['description'],
    'img'     => $rows['img'],
    'source'     => $rows['source'],
    'link' => "http://newsng.com/".$rows['code'],
    'orig'  => $rows['url'],
    'social_score' => $rows['social_score']
  );
}

//$encode = array("Category" => $cat_w, "data" => $det, "dateTaken" => $pubdate, "currentDate" => date("Y-m-d H:i:s"));


//$json_encode = json_encode($encode);
header('Content-Type: application/json');
echo json_encode($array);
//echo $json_encode."<br/>";

//$obj = json_decode($json_encode); // this is the function used to decode the generated JSON

//print_r ($obj);
/* decode the generated JSON from the first 2 
foreach($obj->userdetails as $udetails){
    echo $udetails->name;
    echo "<br/>";
    echo $udetails->age;
    echo "<br/>";
}
foreach($obj->workdetails as $wdetails){
    echo $wdetails->company_name;
    echo "<br/>";
    echo $wdetails->employees;
    echo "<br/>";
}*/
?>