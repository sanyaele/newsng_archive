<?php
//$site_type = "mini";
//require_once '../includes/redirect.php';
///////////////////////////////////
require_once '../includes/db.php';
require_once '../includes/common.php';
require_once '../includes/functions.php';
///////////////////////////////////
// redirect if navigation not found
if (empty($_SESSION['navbar'])):
	$_SESSION['navbar'][] = $_REQUEST['story'];
endif;
///////////////////////////////////
class get_details {
	public $id;
	////////////////
	public $title;
	public $desc;
	public $links="";
	public $url;
	public $comments="";
	public $firstlink="";
	public $firstid;
	public $shortlink;
	public $story_img;
	
	function __construct($id){
		global $link;
		////////////////
		$this->id = substr (addslash($id), 0, 15);
		
		if ($this->story_detail ($link)):
			$this->comments = getcomments ($link, $this->id);
			if (empty($_SESSION['rated'][$this->id])):
				rate($link, $this->id);
			endif;
		else:
			header ("Location: index.php");
		endif;
	}
	
	function story_detail ($link){
		$result = get_art ($link, $this->id);
		if (@mysqli_num_rows($result) > 0):
			while ($rows = @mysqli_fetch_assoc($result)){
				
				$this->shortlink = $rows['code'];
				$this->story_img = $rows['img'];
				$this->title = $rows['title'];
				$this->desc = $rows['description'];
				$this->links = " <a href='http://www.google.com/gwt/x?hl=en&source=m&rd=1&u=$rows[url]' title='$rows[source]'>$rows[source]</a>";
				$this->url = $rows['url'];
				$this->social_score = $rows['social_score'];
			}
			
			//////////////////////////////////////////////////////////////////////////////////////////////
			
			return TRUE;
		else:
			return FALSE;
		endif;
		
	}
}
///////////////////////////////////
///////////////////////////////////
// Add to comment if fields not empty
if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['comment'])):
	require_once 'includes/comments.php';
	$addcomm = new addcomment;
	$addcomm->clean();
	$addcomm->add($link);
endif;
///////////////////////////////////
if (empty($_REQUEST['story'])):
	header ("Location: index.php");
else:
	// get story details
	$story = new get_details($_REQUEST['story']);
endif;

//Get navigation///////////////////////////////////////
$curr_nav_key = array_search ($_REQUEST['story'],$_SESSION['navbar']);
$prev_nav = $curr_nav_key - 1;
$next_nav = $curr_nav_key + 1;
//////////////////////////////////////////////////////


/////// Google Analytics ////////////
/////////////////////////////////////
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name=viewport content="width=device-width, initial-scale=1">
<meta name="description" content="Read and Share the most recent and interesting news as covered by Nigerian newspapers, presented in the most accessible manner and into one unified system." />
<meta name="google-site-verification" content="0sZXG0QJYvoRlcUXLf7e4st7zTQiJAJ9tDinQfX_wA8" />
<title>News Nigeria</title>
<link rel="alternate" type="application/rss+xml" href="feed.php" title="Today's Hottest Nigerian News" />
<link href="assets/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: 12px;
}
.form_box {font-size:10px;}
.style31 {color: #FFFFFF}
.style33 {font-size: 10px; font-weight: bold; color: #FFFF00; }
.style35 {font-size: 9px}
.style37 {
	font-size: 11px;
	color: #000000;
}
.style38 {
	font-family: Tahoma;
	font-size: 11px;
	font-weight: bold;
}
-->
</style>
<meta name="google-site-verification" content="j8eYP1fZjlvCFUswaHd-fkDxz0SSmaAHRNABmS4ZqAE" />
</head>

<body>
<table width="240" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td align="left"><img src="assets/logo.gif" alt="Nigerian News" width="236" height="35" /></td>
  </tr>
  
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left"><a href="index.php">Home</a> | <a href="contact.php">Contact</a></td>
      </tr>
      <tr>
        <td align="left"><form action="http://www.google.com.ng" id="cse-search-box" target="_blank">
		  <div>
			<input type="hidden" name="cx" value="partner-pub-2732469417891860:6010882360" />
			<input type="hidden" name="ie" value="UTF-8" />
			<input type="text" name="q" size="15" />
			<input type="submit" name="sa" value="Search" />
		  </div>
		</form>
		
		<script type="text/javascript" src="http://www.google.com.ng/coop/cse/brand?form=cse-search-box&amp;lang=en"></script></td>
      </tr>
    </table>    </td>
  </tr>
  <tr>
    <td align="center"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- newMobile -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:100px"
     data-ad-client="ca-pub-2732469417891860"
     data-ad-slot="1834309871"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left"><a href="story-detail.php?story=<?php echo $_SESSION['navbar'][$prev_nav];?>" class="commentlink"><strong>&lt;&lt; PREV</strong></a></td>
        <td width="50%" align="right"><a href="story-detail.php?story=<?php echo $_SESSION['navbar'][$next_nav];?>" class="commentlink"><strong>NEXT &gt;&gt;</strong></a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><h1>Read Article:<br /> <a href="<?php echo $story->url; ?>" rel="nofollow"><?php echo $story->title; ?></a></h1></td>
  </tr>
  <tr>
    <td align="left"><iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.newsng.com%2Fstory-detail.php%3Ftitle%3D<?php echo str_replace (" ", "-", $story->title);?>%26story%3D<?php echo $story->id;?>&amp;layout=button_count&amp;show_faces=false&amp;width=225&amp;action=like&amp;font=tahoma&amp;colorscheme=light&amp;height=21&amp;ref=<?php echo $story->id;?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px;" allowTransparency="true"></iframe><a href="http://twitter.com/share" class="twitter-share-button" data-url="http://newsng.com/<?php echo $story->shortlink;?>" data-text="<?php echo ucfirst($story->title);?>" data-count="none" data-via="NewsNG">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></td>
  </tr>
  <tr>
    <td align="left"><span class="style37"><?php echo $story->desc; ?></span></td>
  </tr>
  <tr>
    <td align="left"><span class="sscore">Buzz: <span style="color: #990000;"><?php echo $story->social_score; ?></span></span>
    </td>
  </tr>
  <tr>
    <td align="left"><strong class="sources"><?php echo $story->links; ?></strong>
    <hr /></td>
  </tr>
  <tr>
    <td align="center"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- NewsNGResp -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2732469417891860"
     data-ad-slot="9444328273"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></td>
  </tr>
  <tr>
    <td align="left"><?php echo $story->comments; ?></td>
  </tr>
  <tr>
    <td align="left"><form id="comments" name="comments" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <table width="233" border="0" align="center" cellpadding="1" cellspacing="0" bordercolor="#009900">
        <tr>
          <td align="left"><span class="commentlink">Name</span>
            <input name="name" type="text" class="form_box" id="name" value="<?php echo $_SESSION['name'];?>" size="10" />
            <label></label></td>
          </tr>
        <tr>
          <td align="left"><span class="commentlink">
            <label>Email</label>
          </span>            <input name="email" type="text" class="form_box" id="email" value="<?php echo $_SESSION['email'];?>" size="10" /></td>
          </tr>
        <tr>
          <td align="center"><label>
            <textarea name="comment" cols="20" rows="5" class="form_box" id="comment"></textarea>
          </label></td>
        </tr>
        
        <tr>
          <td align="center"><label>
            <input name="story" type="hidden" id="story" value="<?php echo $_REQUEST['story']; ?>" />
            <input name="news_id" type="hidden" id="news_id" value="<?php echo $_REQUEST['story']; ?>" />
            <input type="submit" name="Addcomment" id="Addcomment" value="Add Comment" />
          </label></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td align="left"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- NewsNGMobLink -->
<ins class="adsbygoogle"
     style="display:inline-block;width:200px;height:90px"
     data-ad-client="ca-pub-2732469417891860"
     data-ad-slot="1921061475"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#006600"><span class="style33">Send feedback to <a href="mailto:contact@newsng.com" class="style31">contact@newsng.com</a></span></td>
  </tr>
  <tr>
    <td align="center"><span class="style35">&copy;Copyright2009-2011 <a href="http://www.goldensteps.com.ng">GoldenSteps Enterprises</a>.All Rights Reserved</span></td>
  </tr>
</table>
<?php 
//////////////////////////////
/// google analytics /////////
//////////////////////////////
$googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
echo '<img src="' . $googleAnalyticsImageUrl . '" />';
?>
</body>
</html>
