<?php
require_once '../includes/db.php';
require_once '../includes/common.php';
require_once '../includes/functions.php';
//////////////////////////////////////
function get_date ($datetime){ // Reformat date
	$sec_diff = (strtotime(date("Y-m-d H:i:s")) - strtotime(date("$datetime")));
	
	if ($sec_diff < '60'): // Less than a minute
		$time_diff = round( abs($sec_diff), 0 ); // How many seconds ago
		return $time_diff . " Sec(s) ago";
	elseif ($sec_diff < '3600'): // Less Than an hour
		$time_diff = round( abs($sec_diff) / 60, 0 ); // How many minutes ago
		$secs_rem = round( abs($sec_diff) % 60, 0 ); // How many seconds remaining
		return  "$time_diff min(s) $secs_rem sec(s) ago";
	elseif ($sec_diff < '86400'): // Less Than a day
		$time_diff = round( abs($sec_diff) / 3600, 0 );  //How many hours ago
		$mins_rem = round( (abs($sec_diff) % 3600) / 60, 0 ); //How many minutes remaining
		return  "$time_diff hr(s) $mins_rem min(s) ago";
	else: // Less Than 3 days
		$time_diff = round( abs($sec_diff) / 86400, 0 ); //How many days ago
		$hrs_rem = round( (abs($sec_diff) % 86400) / 3600, 0 ); //How many hours remaining
		return  "$time_diff days $hrs_rem hrs ago";
	endif;
}

function get_news ($link,$cat,$num='10'){
	// Set Category ////////////////////////
	if (($cat != "") && ($cat != "All")):
		$cat = addslash($cat);
		$cat_where = "AND category.category = '$cat'";
	else:
		$cat_where = "";
	endif;
	
	$pubdate = default_date($link);

	$sql = "SELECT articles.id, articles.title, articles.description, articles.img, articles.social_score,  articles.timeAdded, shortcode.code, sources.source
	FROM articles, category, shortcode, sources
	WHERE articles.catId = category.id
	AND articles.id = shortcode.newsId
	AND articles.sourceId = sources.id
	$cat_where
	ORDER BY social_score DESC
	LIMIT $num";
	//echo $cat.$sql;
	$result = @mysqli_query ($link, $sql);
	while ($rows = @mysqli_fetch_assoc($result)){
		$pos = @strpos($rows['description'], ' ', 40);
		if ($pos !== false):
			$title = substr($rows['description'], 0, $pos).'...';
		else:
			$title = $rows['description'];
		endif;
		
		echo "<div class=\"widget_inner\">
		<div class=\"widget_header\"><a href=\"http://newsng.com/$rows[code]\" target=\"_blank\">$rows[title]</a>
		<div class=\"widget_date\">".get_date($rows['timeAdded'])."</div></div>
		<div class=\"widget_content\">$rows[description]<br />
		<span style=\"font-family:Georgia; font-size:10px;\"><strong>Source:</strong> $rows[source] | <strong>Buzz:</strong> $rows[social_score] </span></div>
	  </div>";
	}
}

//////////////////////////////////////
if (!empty($_GET['bc'])):
	$border_col = $_GET['bc'];
else:
	$border_col = '#7A96DF';
endif;

if (!empty($_GET['hc'])):
	$head_col = $_GET['hc'];
else:
	$head_col = '#003366';
endif;

if (!empty($_GET['f'])):
	$font = $_GET['f'];
else:
	$font = 'Tahoma';
endif;

if (!empty($_GET['n'])):
	$number = substr($_GET['n'],0,2);
else:
	$number = '10';
endif;

if (!empty($_GET['m'])):
	$header_v = 'none';
else:
	$header_v = 'block';
endif;

if (!empty($_GET['c'])):
	$cat = addslash($_GET['c']);
else:
	$cat = '';
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NewsNG.com Widget</title>
<link href="widget.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	font-family: <?php echo $font;?>;
}
.widget_inner {
	border: 1px solid <?php echo $border_col;?>;
}
.widget_header a {
	color: <?php echo $head_col;?>;
}
.mainhead {
	display: <?php echo $header_v;?>;
}
-->
</style>
<meta http-equiv="Refresh" content="12000" />
<style type="text/css">

#marqueecontainer{
position: relative;
width: <?php if (!empty($_POST['w'])){echo $_POST['w'];}?>px; /*marquee width */
height: <?php if (!empty($_POST['h'])){echo $_POST['h'];}?>px; /*marquee height */
background-color: white;
overflow: hidden;
padding: 2px;
}

</style>

<script type="text/javascript">

/***********************************************
* Cross browser Marquee II- © Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/

var delayb4scroll=2000 //Specify initial delay before marquee starts to scroll on page (2000=2 seconds)
var marqueespeed=1 //Specify marquee scroll speed (larger is faster 1-10)
var pauseit=1 //Pause marquee onMousever (0=no. 1=yes)?

////NO NEED TO EDIT BELOW THIS LINE////////////

var copyspeed=marqueespeed
var pausespeed=(pauseit==0)? copyspeed: 0
var actualheight=''

function scrollmarquee(){
if (parseInt(cross_marquee.style.top)>(actualheight*(-1)+8)) //if scroller hasn't reached the end of its height
cross_marquee.style.top=parseInt(cross_marquee.style.top)-copyspeed+"px" //move scroller upwards
else //else, reset to original position
cross_marquee.style.top=parseInt(marqueeheight)+8+"px"
}

function initializemarquee(){
cross_marquee=document.getElementById("vmarquee")
cross_marquee.style.top=0
marqueeheight=document.getElementById("marqueecontainer").offsetHeight
actualheight=cross_marquee.offsetHeight //height of marquee content (much of which is hidden from view)
if (window.opera || navigator.userAgent.indexOf("Netscape/7")!=-1){ //if Opera or Netscape 7x, add scrollbars to scroll and exit
cross_marquee.style.height=marqueeheight+"px"
cross_marquee.style.overflow="scroll"
return
}
setTimeout('lefttime=setInterval("scrollmarquee()",30)', delayb4scroll)
}

if (window.addEventListener)
window.addEventListener("load", initializemarquee, false)
else if (window.attachEvent)
window.attachEvent("onload", initializemarquee)
else if (document.getElementById)
window.onload=initializemarquee


</script>
</head>

<body>
<div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">
<div class="widget_outer" id="vmarquee" style="position: absolute; width: 98%;">
  <div class="mainhead"><a href="http://www.newsng.com" target="_blank">Trending Nigerian News on NewsNG.com</a></div>
  <?php get_news ($link,$cat,$number);?>
</div>
</div>
</body>
</html>
