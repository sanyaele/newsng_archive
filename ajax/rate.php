<?php
require_once '../includes/db.php';
require_once '../includes/common.php';
///////////////////////////////////
$rate = substr($_GET['rate'],0,4);
$story = addslash($_GET['story']);
$sess = "sess_".$story;
//modify rate
function rate ($rate,$story,$link,$type){
	if (($rate == 'good' && $type == '') || ($rate == 'bad' && $type == 'undo')):
		$sql = "UPDATE articles SET rate = rate+1 WHERE id='$story' LIMIT 1";
	elseif (($rate == 'bad' && $type == '') || ($rate == 'good' && $type == 'undo')):
		$sql = "UPDATE articles SET rate = rate-1 WHERE id='$story' LIMIT 1";
	endif;
	if (@mysqli_query($link,$sql)):
		return 1;
	else:
		return 0;
	endif;
}

if (!empty($rate) && !empty($story) && !isset($_SESSION[$sess])):
	if (rate($rate,$story,$link,'')):
		//Change picture
		echo "<img src=\"assets/".$rate."2.gif\" alt=\"$rate\" width=\"20\" height=\"20\" />";
		
		$_SESSION[$sess]=$rate;
	else:
		//Retain default picture
		echo "<img src=\"assets/".$rate.".gif\" alt=\"$rate\" width=\"20\" height=\"20\" />";
	endif;
	
	
elseif($_SESSION[$sess] == $rate): //if this user has rated this article before
	if (rate($rate,$story,$link,'undo')):
		//Change to default picture
		echo "<img src=\"assets/".$rate.".gif\" alt=\"$rate\" width=\"20\" height=\"20\" />";
		unset ($_SESSION[$sess]);
	else:
		//Retain selected picture
		echo "<img src=\"assets/".$rate."2.gif\" alt=\"$rate\" width=\"20\" height=\"20\" />";
	endif;
	
else:
	//Retain default picture
	echo "<img src=\"assets/".$rate.".gif\" alt=\"$rate\" width=\"20\" height=\"20\" />";
endif;
?>