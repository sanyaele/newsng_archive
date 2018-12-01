<?php
if (!empty($_REQUEST['cat'])): //select a category
	$cat_s = strtolower($_REQUEST['cat']);
	if ($cat_s == 'business' || $cat_s == 'entertainment' || $cat_s == 'fashion' || $cat_s == 'news' || $cat_s == 'politics' || $cat_s == 'sports' || $cat_s == 'technology' || $cat_s == 'health'): //Select a valid category
		$cat_c = ucfirst($_REQUEST['cat']);
	else:
		header ("Location: index.php");
	endif;
else:
	header ("Location: index.php");
endif;
////////////////////////
$site_type = "html";
require_once 'includes/redirect.php';
///////////////////////////////////
require_once 'includes/db.php';

require_once 'includes/common.php';
///////////////////////////////////
// get news for different sections
require_once 'includes/list.php';
require_once 'includes/archive.php';
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////

$new_news = new get_news($cat_c);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cat_c;?> News in Nigeria <?php echo $_GET['archive'];?></title>
<link rel="alternate" type="application/rss+xml" href="feed.php?cat=<?php echo $cat_c;?>" title="Today's Hottest Nigerian News - <?php echo $cat_c;?>" />
<link href="assets/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: 12px;
}
.style5 {
	color: #0066FF;
	line-height: 20px;
}
.style6 {font-size: 13px}
.style8 {color: #006699; font-weight: bold; }
.style9 {
	color: #FF0000;
	font-weight: bold;
}
.style11 {	font-size: 9px;
	color: #0000FF;
}
.style12 {	font-size: 10px;
	font-weight: bold;
}
-->
</style>
<script type="text/javascript" src="ajax/ajax.js"></script>
<script type="text/javascript">

		function rate(rate_type,story) {
			subject_id = story + '_' + rate_type + '_div';
			
			http.open("GET", "ajax/rate_story.php?rate=" + escape(rate_type) + "&story=" + escape(story), true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
			
			document.getElementById('name').value = "";
		}
		
</script>
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCC33" class="allborder">
  <tr>
    <td bgcolor="#FFFFFF"><?php
	include_once 'header.html';
	?>
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="5">
        <tr>
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top" bordercolor="#66FF02" class="style1"><span class="style9">Date: <?php echo $new_news->pubdate;?></span></td>
        </tr>
        <tr>
          <td width="75%" align="left" valign="top" bordercolor="#00FF00"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><script type="text/javascript"><!--
            google_ad_client = "pub-2732469417891860";
            /* 728x15, created 10/5/09 */
            google_ad_slot = "3415098669";
            google_ad_width = 728;
            google_ad_height = 15;
            //-->
            </script>
                    <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
                </td>
              </tr>
            </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                  <iframe src="http://rcm.amazon.com/e/cm?t=ne0d-20&o=1&p=48&l=ur1&category=books&banner=19YH3N7RRQ6621WZ60G2&f=ifr" width="728" height="90" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
                  </td>
                </tr>
                <tr>
                  <td><?php
	  echo $new_news->build_sections();
	  ?></td>
                </tr>
          </table></td>
          <td width="25%" align="left" valign="top" bordercolor="#006600"><script type="text/javascript"><!--
google_ad_client = "pub-2732469417891860";
/* 250x250, created 10/5/09 */
google_ad_slot = "0613640732";
google_ad_width = 250;
google_ad_height = 250;
//-->
      </script>
              <script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td><span class="style8 style12">Archives</span> </td>
                </tr>
                <tr>
                  <td height="200" align="left" valign="top" bordercolor="#B4C6DB" class="allborder"><?php archives();?>
                    &nbsp;
                    <form id="archives" name="archives" method="get" action="">
                      <span class="style11">
                      <select name="day" class="style1" id="day">
                        <option selected="selected">dd</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                      </select>
                      <select name="month" class="style1" id="month">
                        <option selected="selected">mm</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                      </select>
                      <label>
                      <select name="year" class="style1" id="year">
                        <option>Year</option>
                        <option value="2009">2009</option>
                        <option value="2010">2010</option>
                        <option value="2011">2011</option>
                      </select>
                      </label>
                      <label>
                      <input name="go" type="submit" class="style1" id="go" value="Find" />
                      </label>
                      </span>
                  </form></td>
                </tr>
              </table>
            <br /><br />
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- NewsNG_sscraper -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:600px"
     data-ad-client="ca-pub-2732469417891860"
     data-ad-slot="2999595071"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script><br />
<br />
              <table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td colspan="2"><span class="style8">Subscribe to our RSS Feed</span></td>
                </tr>
                <tr>
                  <td width="50%" height="100" align="center" valign="middle" bordercolor="#B4C6DB" class="allborder"><a href="http://feeds.feedburner.com/TodaysHottestNigerianNews" title="Subscribe to Newsng feed" rel="alternate" type="application/rss+xml"><img src="assets/rss_small.jpg" width="80" height="79" alt="" style="border:0"/></a></td>
                  <td width="50%" align="center" valign="middle" bordercolor="#B4C6DB" class="allborder"><a href="http://feeds.feedburner.com/newsng/<?php echo $cat_s;?>" title="Subscribe to Newsng feed" rel="alternate" type="application/rss+xml"><img src="assets/rss_small.jpg" alt="RSS Feeds" width="80" height="79" border="0" /></a></td>
                </tr>
                <tr>
                  <td align="center" valign="middle" bordercolor="#FFFFFF" bgcolor="#B4C6DB" class="allborder"><span class="style12">All News</span></td>
                  <td align="center" valign="middle" bordercolor="#FFFFFF" bgcolor="#B4C6DB" class="allborder"><span class="style12"><?php echo $cat_c;?></span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td style="font-size: 10px"><?php
	include_once 'header.html';
	?></td>
          <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
