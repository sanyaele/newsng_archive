<?php
////////////////////////
//$site_type = "mini";
//require_once '../includes/redirect.php';
///////////////////////////////////
require_once '../includes/db.php';
require_once '../includes/common.php';
require_once '../includes/archive.php';
require_once '../includes/pub_date.php';
require_once '../includes/functions.php';
require_once '../includes/topstories.php';
require_once '../includes/adverts.php';
//////////////////////////////
/// google analytics /////////
//////////////////////////////
//include_once 'g_analytics.php';
///////////////////////////////////
unset ($navbar); //remove $navbar if already existing
require_once 'includes/highlight.php';


// Set date if user is viewing an older article
if (!empty($_GET['archive']) && strlen($_GET['archive']) == 10):
	$pubdate = str_replace ("_", "-", addslash (substr ($_GET['archive'],0,11)));
elseif (!empty($_GET['day']) && !empty($_GET['month']) && !empty($_GET['year'])):
	$pubdate = substr (addslash ($_GET['year']."-".$_GET['month']."-".$_GET['day']), 0, 10);
	header ("Location: index.php?archive=$pubdate");
else: // Set a default date
	$pubdate = default_date($link);
	header ("Location: index.php?archive=$pubdate");
endif;


///Google Analytics
// Copyright 2010 Google Inc. All Rights Reserved.

$GA_ACCOUNT = "MO-7718160-3";
$GA_PIXEL = "/ga.php";

function googleAnalyticsGetImageUrl() {
global $GA_ACCOUNT, $GA_PIXEL;
$url = "";
$url .= $GA_PIXEL . "?";
$url .= "utmac=" . $GA_ACCOUNT;
$url .= "&utmn=" . rand(0, 0x7fffffff);
$referer = $_SERVER["HTTP_REFERER"];
$query = $_SERVER["QUERY_STRING"];
$path = $_SERVER["REQUEST_URI"];
if (empty($referer)) {
  $referer = "-";
}
$url .= "&utmr=" . urlencode($referer);
if (!empty($path)) {
  $url .= "&utmp=" . urlencode($path);
}
$url .= "&guid=ON";
return str_replace("&", "&amp;", $url);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Top Nigeria News on Mobile</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Nigerian news on your PC or mobile phone. Read and Share current and interesting Nigerian news as covered by different Nigerian newspapers and others." />
<meta name="keywords" content="nigeria, news, nigerian news, mobile news, news on the go, Punch, Guardian, Thisday,  Vanguard, Independent, Daily Trust, Tribune, Champion, The Sun" />
<meta name="google-site-verification" content="0sZXG0QJYvoRlcUXLf7e4st7zTQiJAJ9tDinQfX_wA8" />
<link rel="alternate" type="application/rss+xml" href="feed.php" title="Top Nigerian News" />
<link href="assets/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.form_box {font-size:10px;}
.style31 {color: #FFFFFF}
.style33 {font-size: 10px; font-weight: bold; color: #FFFF00; }
.style35 {font-size: 9px}
.h2div {
	padding:5px;
	background-color:#36C;
	color:#FFF;
	text-decoration:none;
	margin:2px;
}
-->
</style>
</head>

<body>
<div id="alldiv">

<h1><img src="http://newsng.com/assets/icon_small.png" alt="Nigerian News" width="25" height="30" /></h1>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- NewsNGResp -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2732469417891860"
     data-ad-slot="9444328273"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<div style="padding:5px;"><a href="contact.php">Contact</a></div>
<div style="text-align:right;">
<form action="http://www.google.com.ng" id="cse-search-box" target="_blank">
		  <div>
			<input type="hidden" name="cx" value="partner-pub-2732469417891860:6010882360" />
			<input type="hidden" name="ie" value="UTF-8" />
			<input type="text" name="q" size="15" />
			<input type="submit" name="sa" value="Search" />
		  </div>
		</form>
		
		<script type="text/javascript" src="http://www.google.com.ng/coop/cse/brand?form=cse-search-box&amp;lang=en"></script></div>
        
        
        
		<div class="ndet">
		<?php 
		$new_news = new get_news("News",$pubdate);
		echo $new_news->html;
		?>
        </div>
        <div class="more" id="more_news">
		  <?php 
            echo $new_news->more;
            ?>
          </div>
          
		<div class="ndet">
		<?php 
		  $new_politics = new get_news("Politics",$pubdate);
		  echo $new_politics->html;
		  ?>
          </div>
		  <div class="more" id="more_politics">
		  <?php 
		  echo $new_politics->more;
		  ?>
          </div>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- newMobile -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:100px"
     data-ad-client="ca-pub-2732469417891860"
     data-ad-slot="1834309871"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
		<div class="ndet">
		<?php 
			  $new_business = new get_news("Business",$pubdate);
			  echo $new_business->html;
		?>
           </div>   
          <div class="more" id="more_business">
              <?php 
			  echo $new_business->more;
			  ?>
          </div>
          
		  <div class="ndet">
		  <?php 
			$new_sports = new get_news("Sports",$pubdate);
			echo $new_sports->html;
			?>
            </div>
            <div class="more" id="more_sports">
              <?php 
			  echo $new_sports->more;
			  ?>
          </div>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- NewsNGResp -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2732469417891860"
     data-ad-slot="9444328273"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		<div class="ndet">
		<?php 
          $new_fashion = new get_news("Fashion",$pubdate);
          echo $new_fashion->html;
          ?>
          </div>
          
          <div class="more" id="more_fashion">
          <?php 
          echo $new_fashion->more;
          ?>
          </div>
		
		<div class="ndet">
		<?php 
		  $new_health = new get_news("Health",$pubdate);
		  echo $new_health->html;
		  ?>
          </div>
          <div class="more" id="more_health">
              <?php 
			  echo $new_health->more;
			  ?>
          </div>
		  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- NewsNGMobLink -->
<ins class="adsbygoogle"
     style="display:inline-block;width:200px;height:90px"
     data-ad-client="ca-pub-2732469417891860"
     data-ad-slot="1921061475"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
		  <div class="ndet">
		  <?php 
			$new_ent = new get_news("Entertainment",$pubdate);
			echo $new_ent->html;
			?>
            </div>
            <div class="more" id="more_ent">
              <?php 
			  echo $new_ent->more;
			  ?>
          </div>
		  
		  <div class="ndet">
		  <?php 
			$new_tech = new get_news("Technology",$pubdate);
			echo $new_tech->html;
			?>
             </div>
            <div class="more" id="more_tech">
              <?php 
			  echo $new_tech->more;
			  ?>
          </div>
		  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- NewsNGMobLink -->
<ins class="adsbygoogle"
     style="display:inline-block;width:200px;height:90px"
     data-ad-client="ca-pub-2732469417891860"
     data-ad-slot="1921061475"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
          
          <div style="background-color:#090; padding:5px;"><span class="style33">feedback to <a href="mailto:contact@newsng.com" class="style31">contact@newsng.com</a></span> &nbsp;&nbsp;<a href="http://www.newsng.com/?redirct=1" style="color:#FFF;">View Desktop Version</a></div>
          
          <span class="style35">&copy;Copyright2009-2011 <a href="http://www.goldensteps.com.ng">GoldenSteps Enterprises</a>.All Rights Reserved</span>
</div>
<?php
//renew session navigation
unset ($_SESSION['navbar']);
$_SESSION['navbar'] = $navbar;

$googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
echo '<img src="' . $googleAnalyticsImageUrl . '" />';
?>
</body>
</html>
