<?php

////////////////////////
if (empty($_GET['redirct'])):
	$site_type = "html";
	require_once 'includes/redirect.php';
endif;
///////////////////////////////////
require_once 'includes/db.php';

require_once 'includes/common.php';
require_once 'includes/archive.php';
require_once 'includes/pub_date.php';
require_once 'includes/functions.php';
require_once 'includes/topstories.php';
///////////////////////////////////
require_once 'includes/highlight.php';


// Set date if user is viewing an older article
if (!empty($_GET['archive']) && strlen($_GET['archive']) == 10):
	$pubdate = str_replace ("_", "-", addslash (substr ($_GET['archive'],0,11)));
elseif (!empty($_GET['day']) && !empty($_GET['month']) && !empty($_GET['year'])):
	$pubdate = substr (addslash ($_GET['year']."-".$_GET['month']."-".$_GET['day']), 0, 10);
	header ("Location: archive.php?archive=$pubdate");
else: // Set a default date
	header ("Location: index.php");
endif;

$arch_pubdate = str_replace ("-", "_", $pubdate);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name=viewport content="width=device-width, initial-scale=1">
<meta name="description" content="Nigerian news online. Read and Share the most recent and interesting news as covered by Nigerian news media, presented in the most accessible manner and into one unified system." />
<meta name="google-site-verification" content="0sZXG0QJYvoRlcUXLf7e4st7zTQiJAJ9tDinQfX_wA8" />
<title>Nigerian News Archive - Read current and hot Nigerian news on www.NewsNG.com</title>
<link rel="alternate" type="application/rss+xml" href="feed.php" title="Today's Hottest Nigerian News" />
<link href="assets/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: 12px;
}
.style8 {color: #006699; font-weight: bold; }
.style9 {
	color: #FF0000;
	font-weight: bold;
}

.style11 {	font-size: 9px;
	color: #0000FF;
}
.style12 {font-size: 10px}
.style14 {font-size: 10px; font-weight: bold; }
.style18 {color: #FFFFFF; font-weight: bold; font-size: 10px; }
.style28 {font-family: Tahoma, Verdana; font-size: 9px; font-weight: bold; }
.form_box {font-size:10px;}
.style30 {
	color: #FFFF00;
	font-weight: bold;
	font-size: 10px;
	font-family: Tahoma, Verdana;
}
.style31 {color: #FFFFFF}
.style33 {font-size: 10px; font-weight: bold; color: #FFFF00; }
.style34 {
	font-family: Tahoma, Verdana;
	font-weight: bold;
	color: #006600;
}
.style35 {color: #FF0000}
-->
</style>
<script type="text/javascript" src="ajax/ajax.js"></script>
<script type="text/javascript">
		function showmore (cat){
			link_div = "link_" + cat;
			more_div = "more_" + cat;
			
			document.getElementById(more_div).style.visibility = "visible";
			document.getElementById(link_div).innerHTML = '<strong onclick="showless(\'' + cat + '\')">- Hide more ' + cat + ' stories...</strong>';
		}
		
		function showless (cat){
			link_div = "link_" + cat;
			more_div = "more_" + cat;
			
			document.getElementById(more_div).style.visibility = "hidden";
			document.getElementById(link_div).innerHTML = '<strong onclick="showmore(\'' + cat + '\')">+ Show more ' + cat + ' stories...</strong>';
		}
		
		function showhidecomment (newsid){
			
			subject_id = "commentpack_" + newsid;
			inner_comment = "comment_div_" + newsid;
			inner_comment_display = document.getElementById(inner_comment).style.display;
			
				
				
			
			if (inner_comment_display == 'none' || inner_comment_display == 'block'){
				document.getElementById(inner_comment).style.display = "inline";
				document.getElementById(inner_comment).innerHTML = '<img src="assets/Processing.gif" />';
				
				http.open("GET", "ajax/comment_index.php?news_id=" + escape(newsid), true);
				http.onreadystatechange = handleHttpResponse;
				http.send(null);
			}else{
				document.getElementById(inner_comment).style.display = "none";
			}
		}
		
		function show_name_email(name_email){
			document.getElementById(name_email).style.display = "inline";
		}
		
		
		function clear_textbox(box){
			if (document.getElementById(box).value == "Your comment here ..."){
				document.getElementById(box).value = "";
			}
		}
		
		
		function countchars(box,container){
			boxcont=document.getElementById(box).value;
			if (boxcont.length>500){
				document.getElementById(box).value = boxcont.substr(0,500);
				document.getElementById(container).innerHTML="500";
			}else{
				document.getElementById(container).innerHTML=boxcont.length;
			}
			
		}
		
		function put_comment(newsid) {
			subject_id = 'commentpack_' + newsid;
			name_box = 'name_' + newsid;
			email_box = 'email_' + newsid;
			comment_box = 'comment_' + newsid;
			
			name_value = document.getElementById(name_box).value;
			email_value = document.getElementById(email_box).value;
			comment_value = document.getElementById(comment_box).value;
			
			inner_comment = "comment_div_" + newsid;
			document.getElementById(inner_comment).innerHTML = '<img src="assets/Processing.gif" />';
			
			http.open("GET", "ajax/comment_index.php?name=" + escape(name_value) + "&email=" + escape(email_value) + "&news_id=" + escape(newsid) + "&comment=" + escape(comment_value), true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
</script>
<meta name="google-site-verification" content="j8eYP1fZjlvCFUswaHd-fkDxz0SSmaAHRNABmS4ZqAE" />
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#060" class="allborder">
  <tr>
    <td align="left"><?php
	include_once 'header.html';
	?>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td width="98%">&nbsp;</td>
          <td width="2%" align="right">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" bgcolor="#FFFFFF">
        <tr>
          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%" height="160" align="left" valign="top">
          <div class="date" title="<?php echo date("D jS F, Y",strtotime($pubdate));?>"><p><?php echo date("j",strtotime($pubdate));?><span><?php echo date("M",strtotime($pubdate));?></span></p></div></td>
                <td width="50%" height="100" align="center" valign="middle">&nbsp;</td>
                <td width="27%" align="right"><!-- Place this tag where you want the +1 button to render -->
          <g:plusone size="tall"></g:plusone></td>
              </tr>
          </table></td>
          <td align="center" valign="middle"><a href="advertise.php"><img src="assets/advertise.jpg" width="307" height="86" border="0" alt="Advertise with us" /></a></td>
        </tr>
        <tr>
          <td align="left" valign="top"><script type="text/javascript"><!--
					google_ad_client = "pub-2732469417891860";
					/* 728x90, created 10/5/09 */
					google_ad_slot = "9338416308";
					google_ad_width = 728;
					google_ad_height = 90;
					//-->
					</script>
					  <script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script> </td>
          <td width="25%" rowspan="2" align="left" valign="top" class="style1"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" bordercolor="#000000" class="allborder">
            <tr>
              <td width="234" align="center" class="commentlink">FEATURED VIDEO NEWS</td>
            </tr>
            <tr>
              <td align="center" valign="middle"><iframe title="YouTube video player" width="100%" height="240" src="http://www.youtube.com/embed/3OvrTIUYOKk" frameborder="0" allowfullscreen="allowfullscreen"></iframe></td>
            </tr>
          </table>
            <br />
            <table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td align="center" bgcolor="#0000FF"><span class="style18">TOP STORIES</span></td>
              </tr>
            <tr>
              <td align="left" class="topstories">
                <?php
                topstories ($link,$pubdate);
                ?>              </td>
              </tr>
            
            
          </table>
            <br />
            <table width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td bgcolor="#FF0000"><span class="style12 style15">Send me Nigerian news daily</span></td>
              </tr>
              <tr>
                <td height="100" align="left" valign="top" bordercolor="#FF0000" class="allborder"><form id="newsletter" name="newsletter" method="post" action="newsletter.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="36%" align="right"><span class="archive">Firstname</span></td>
                        <td width="64%"><label>
                          <input name="firstname" type="text" class="archive" id="firstname" size="20" maxlength="30" />
                        </label></td>
                      </tr>
                      <tr>
                        <td align="right"><span class="archive">Lastname</span></td>
                        <td><label>
                          <input name="lastname" type="text" class="archive" id="lastname" size="20" maxlength="30" />
                        </label></td>
                      </tr>
                      <tr>
                        <td align="right"><span class="archive">Email</span></td>
                        <td><label>
                          <input name="email" type="text" class="archive" id="email" size="20" maxlength="50" />
                        </label></td>
                      </tr>
                      <tr>
                       <td colspan="2"><?php
						  require_once('includes/recaptchalib.php');
						  $publickey = "6LfTFPcSAAAAAFBIf7HqNkfYk9FjPMdCRDhdP9JG"; // you got this from the signup page
						  echo recaptcha_get_html($publickey);
						?></td>
                      </tr>
                      <tr>
                        <td><input name="sub" type="hidden" id="sub" value="1" /></td>
                        <td><label>
                          <input name="subscribe" type="submit" class="style9" id="subscribe" value="Subscribe" />
                        </label></td>
                      </tr>
                    </table>
                </form></td>
              </tr>
              <tr>
                <td align="left" valign="top" bordercolor="#FF0000" bgcolor="#FF0000" class="comments allborder"><span class="style30">Add <span class="style31">admin@newsng.com</span> to your email contact, to ensure you receive these mails</span></td>
              </tr>
            </table>
            <br />
            <br />
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
            <table width="100%" border="0" cellpadding="2" cellspacing="0" bordercolor="#0000FF" class="allborder">
              
              <tr>
                <td align="center"><a href="http://www.nigeriantraffic.com" class="style40">Get road traffic information in Lagos, Nigeria now!</a></td>
              </tr>
              <tr>
                <td align="center"><a href="http://www.nigeriantraffic.com"><img src="assets/NigerianTraffic.gif" alt="Nigerian Traffic" name="NigerianTraffic" width="190" height="90" border="0" id="NigerianTraffic" /></a></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFFF00"><span class="archive style37"><a href="http://www.nigeriantraffic.com"><strong> www.NigerianTraffic.com</strong></a></span></td>
              </tr>
            </table>
            <br />
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="50%" height="100" align="center" valign="middle"><a href="http://feeds.feedburner.com/TodaysHottestNigerianNews" title="Subscribe to Newsng feed" rel="alternate" type="application/rss+xml"><img src="assets/rss_small.jpg" width="80" height="79" alt="Subscribe to our Feed" style="border:0"/></a><br />
                  <a href="http://feeds.feedburner.com/TodaysHottestNigerianNews"><span class="style28">RSS Feed</span></a></td>
                <td width="50%" align="center" valign="middle"><a href="http://twitter.com/newsng" title="Follow us on Twitter"><img src="assets/twitter_img.jpg" alt="follow us on twitter" width="80" height="80" border="0" /></a><br />
                  <a href="http://twitter.com/newsng"><span class="style28">Follow on Twitter</span></a></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center">
                <script src="http://widgets.twimg.com/j/2/widget.js"></script>
				<script>
                new TWTR.Widget({
                  version: 2,
                  type: 'search',
                  search: 'Nigeria News',
                  interval: 15000,
                  title: 'Nigerian News on Twitter',
                  subject: 'Tweets About Nigeria',
                  width: 250,
                  height: 250,
                  theme: {
                    shell: {
                      background: '#8ec1da',
                      color: '#ffffff'
                    },
                    tweets: {
                      background: '#ffffff',
                      color: '#444444',
                      links: '#1985b5'
                    }
                  },
                  features: {
                    scrollbar: false,
                    loop: true,
                    live: true,
                    hashtags: true,
                    timestamp: true,
                    avatars: true,
                    behavior: 'default'
                  }
                }).render().start();
                </script>                </td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td><span class="style8 style12">Archives</span> </td>
                </tr>
                <tr>
                  <td height="200" align="left" valign="top" bordercolor="#B4C6DB" class="allborder"><?php archives();?>
                    &nbsp;
                    <form id="archives" name="archives" method="get" action="archive.php">
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
            <br />
              <table width="100%" border="0" cellpadding="3" cellspacing="2">
                <tr>
                  <td bgcolor="#CCCCCC" class="style14"><a href="newspapers.php">Nigerian Newspapers</a> Currently Covered</td>
                </tr>
                <tr>
                  <td bgcolor="#ECE9D8" class="style14"><a href="newspapers.php?url=newspaper_articles.php?p=punch">The Punch</a></td>
                </tr>
                <tr>
                  <td bgcolor="#ECE9D8" class="style14"><a href="newspapers.php?url=newspaper_articles.php?p=thisday">Thisday</a></td>
                </tr>
                <tr>
                  <td bgcolor="#ECE9D8" class="style14"><a href="newspapers.php?url=newspaper_articles.php?p=guardian">Guardian</a></td>
                </tr>
                <tr>
                  <td bgcolor="#ECE9D8" class="style14"><a href="newspapers.php?url=newspaper_articles.php?p=vanguard">Vanguard</a></td>
                </tr>
                <tr>
                  <td bgcolor="#ECE9D8" class="style14"><a href="newspapers.php?url=newspaper_articles.php?p=independent">Daily Independent</a></td>
                </tr>
                <tr>
                  <td bgcolor="#ECE9D8" class="style14"><a href="newspapers.php?url=newspaper_articles.php?p=sunnews">Daily Sun</a></td>
                </tr>
                <tr>
                  <td bgcolor="#ECE9D8" class="style14"><a href="newspapers.php?url=newspaper_articles.php?p=tribune">Nigerian Tribune</a></td>
                </tr>
                <tr>
                  <td bgcolor="#ECE9D8" class="style14"><a href="newspapers.php?url=newspaper_articles.php?p=businessday">Business Day</a></td>
                </tr>
                <tr>
                  <td bgcolor="#ECE9D8" class="style14"><a href="newspapers.php?url=newspaper_articles.php?p=thenation">The Nation</a></td>
                </tr>
                <tr>
                  <td bgcolor="#ECE9D8" class="style14"><a href="newspapers.php?url=newspaper_articles.php?p=dailytrust">Daily Trust</a></td>
                </tr>
              </table>
              <br />
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left"><a href="http://sitetrail.com/newsng.com"><img src="http://sitetrail.com/widgets/value/newsng.com" border="0" /></a></td>
			    </tr>
				  <tr>
                  <td align="center" valign="middle"><div id="webutation-badge">
 <script type="text/javascript">
  (function() {
  window.domain = 'newsng.com';
    function async_load(){
     var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;
     s.src = 'http://www.webutation.net/js/load_badge.js';
     var x = document.getElementById('webutation-link'); x.parentNode.insertBefore(s, x); }
    if (window.attachEvent) window.attachEvent('onload', async_load); else window.addEventListener('load', async_load, false);
  })();
 </script>
 <a id="webutation-link"  href="http://www.webutation.net/go/review/newsng.com">newsng.com Webutation</a>
</div></td>
                </tr>
              </table></td>
        </tr>
        
        <tr>
          <td width="75%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
            </script>                </td>
              </tr>
            </table>
              <table width="100%" border="0" cellspacing="3" cellpadding="0">
                <tr>
                  <td width="50%" align="left" valign="top"><br />
                    <table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="tbl">
                    <tr>
                      <td><img src="assets/newsbar.gif" width="150" height="31" alt="News" /></td>
                    </tr>
                    <tr>
                      <td><?php 
				$new_news = new get_news("News",$pubdate);
				echo $new_news->html;
				?></td>
                    </tr>
                    <tr>
                      <td bgcolor="#DEE3ED" class="more"> more News stories:<br />
                          <?php 
							echo $new_news->more;
							?>                      </td>
                    </tr>
                  </table>
                    <table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="tbl">
                      <tr>
                        <td><img src="assets/politicsbar.gif" width="150" height="31" alt="Politics" /></td>
                      </tr>
                      <tr>
                        <td><?php 
			  $new_politics = new get_news("Politics",$pubdate);
			  echo $new_politics->html;
			  ?></td>
                      </tr>
                      <tr>
                        <td bgcolor="#DEE3ED" class="more"> more Politics stories:<br />
                            <?php 
			  echo $new_politics->more;
			  ?>                        </td>
                      </tr>
                    </table>
                    <table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="tbl">
                      <tr>
                        <td><img src="assets/technologybar.gif" width="150" height="31" alt="Politics" /></td>
                      </tr>
                      <tr>
                        <td><?php 
			  $new_technology = new get_news("Technology",$pubdate);
			  echo $new_technology->html;
			  ?></td>
                      </tr>
                      <tr>
                        <td bgcolor="#DEE3ED" class="more"> more Technology stories:<br />
                          <?php 
			  echo $new_technology->more;
			  ?></td>
                      </tr>
                    </table>
                    <table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="tbl">
                      <tr>
                        <td><img src="assets/fashionbar.gif" width="150" height="31" alt="Fashion" /></td>
                      </tr>
                      <tr>
                        <td><?php 
			$new_fashion = new get_news("Fashion",$pubdate);
			echo $new_fashion->html;
			?></td>
                      </tr>
                      <tr>
                        <td bgcolor="#DEE3ED" class="more"> more Fashion stories:<br />
                          <?php 
			  echo $new_fashion->more;
			  ?>                        </td>
                      </tr>
                    </table>
                  <br /></td>
                  <td width="50%" align="left" valign="top"><br />
                    <table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="tbl">
                    <tr>
                      <td><img src="assets/businessbar.gif" width="150" height="31" alt="Business" /></td>
                    </tr>
                    <tr>
                      <td><?php 
			$new_business = new get_news("Business",$pubdate);
			echo $new_business->html;
			?></td>
                    </tr>
                    <tr>
                      <td bgcolor="#DEE3ED" class="more"> more Business stories:<br />
                          <?php 
							  echo $new_business->more;
							  ?>                      </td>
                    </tr>
                  </table>
                    <table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="tbl">
                      <tr>
                        <td><img src="assets/sportsbar.gif" width="150" height="31" alt="Sports" /></td>
                      </tr>
                      <tr>
                        <td><?php 
					  $new_sports = new get_news("Sports",$pubdate);
					  echo $new_sports->html;
					  ?></td>
                      </tr>
                      <tr>
                        <td bgcolor="#DEE3ED" class="more"> more Sports stories:<br />
                            <?php 
							  echo $new_sports->more;
							  ?>                        </td>
                      </tr>
                    </table>
                    <table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="tbl">
                      <tr>
                        <td><img src="assets/healthbar.gif" width="150" height="31" alt="Sports" /></td>
                      </tr>
                      <tr>
                        <td><?php 
					  $new_health = new get_news("Health",$pubdate);
					  echo $new_health->html;
					  ?></td>
                      </tr>
                      <tr>
                        <td bgcolor="#DEE3ED" class="more"> more Health stories:<br />
                          <?php 
							  echo $new_health->more;
							  ?></td>
                      </tr>
                    </table>
                    <table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="tbl">
                      <tr>
                        <td><img src="assets/entertainmentbar.gif" width="202" height="31" alt="Entertainment" /></td>
                      </tr>
                      <tr>
                        <td><?php 
					  $new_ent = new get_news("Entertainment",$pubdate);
					  echo $new_ent->html;
					  ?></td>
                      </tr>
                      <tr>
                        <td bgcolor="#DEE3ED" class="more"> more Entertainment stories:<br />
                            <?php 
			  echo $new_ent->more;
			  ?>                        </td>
                      </tr>
                    </table>
                  <br /></td>
                </tr>
            </table></td>
        </tr>
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
            </script></td>
          <td align="center">&nbsp;</td>
        </tr>
        
        <tr>
          <td><?php
	include_once 'footer.html';
	?></td>
          <td bgcolor="#006600"><span class="style33">Send feedback to <a href="mailto:contact@newsng.com" class="style31">contact@newsng.com</a></span></td>
        </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7718160-3");
pageTracker._trackPageview();
} catch(err) {}</script>


<!--Floating Facebook Widget by www.NewsNG.com START-->
<script type="text/javascript"> /*<![CDATA[*/ jQuery(document).ready(function() {jQuery(".theblogwidgets").hover(function() {jQuery(this).stop().animate({right: "0"}, "medium");}, function() {jQuery(this).stop().animate({right: "-250"}, "medium");}, 500);}); /*]]>*/ </script> <style type="text/css"> .theblogwidgets{background: url("http://3.bp.blogspot.com/-TaZRLv66f8g/UoMnTyTbF6I/AAAAAAAAAGY/U4qcf-SP6d0/TheBlogWidgets_facebook_widget.png") no-repeat scroll left center transparent !important; float: right;height: 270px;padding: 0 5px 0 46px;width: 245px;z-index:  99999;position:fixed;right:-250px;top:20%;} .theblogwidgets div{ padding: 0; margin-right:-8px; border:4px solid  #3b5998; background:#fafafa;} .theblogwidgets span{bottom: 4px;font: 8px "lucida grande",tahoma,verdana,arial,sans-serif;position: absolute;right: 6px;text-align: right;z-index: 99999;} .theblogwidgets span a{color: gray;text-decoration:none;} .theblogwidgets span a:hover{text-decoration:underline;} } </style><div class="theblogwidgets" style="">
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Ffacebook.com%2Fnewsng&width=245&colorscheme=light&show_faces=true&border_color=white&connections=9&stream=false&header=false&height=270" scrolling="no" frameborder="0"style="border: white; overflow: hidden; height: 270px; width: 245px;background:#fafafa;color:000;"><!--Brought to you by www.TheBlogWidgets.com--></iframe><span><center>
<a style="color:#a8a8a8;font-size:8px;" href="http://www.theblogwidgets.com/2013/11/floating-facebook-like-box-widget-for.html">Floating Facebook Widget</a></center>
</span></div>
</div>
<!--Floating Facebook Widget by www.TheBlogWidgets.com END-->

<script type="text/javascript">
  var vglnk = { key: 'db9d033454321a1af3f57506056cbb6d' };

  (function(d, t) {
    var s = d.createElement(t); s.type = 'text/javascript'; s.async = true;
    s.src = '//cdn.viglink.com/api/vglnk.js';
    var r = d.getElementsByTagName(t)[0]; r.parentNode.insertBefore(s, r);
  }(document, 'script'));
</script>
</body>
</html>
