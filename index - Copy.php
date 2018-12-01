<?php
//header("HTTP/1.1 301 Moved Permanently");
//header("Location: http://newsng.com/nigeria-news/");
//////////////////////////////////////////////////////

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
require_once 'includes/adverts.php';
///////////////////////////////////
require_once 'includes/highlight.php';
require_once 'includes/get_video.php';

// Set publication date
//$pubdate = default_date($link);
$pubdate = date("Y-m-d");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Read Nigerian News and Newspapers Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Nigerian news on your PC or mobile phone. Read and Share current and interesting Nigerian news as covered by different Nigerian newspapers and others." />
<meta name="keywords" content="nigeria, news, nigerian news, mobile news, news on the go, Punch, Guardian, Thisday,  Vanguard, Independent, Daily Trust, Tribune, Champion, The Sun" />
<meta name="google-site-verification" content="0sZXG0QJYvoRlcUXLf7e4st7zTQiJAJ9tDinQfX_wA8" />

<link rel="alternate" type="application/rss+xml" href="feed.php" title="Today's Hottest Nigerian News" />
<link href='http://fonts.googleapis.com/css?family=Josefin+Sans|Open+Sans' rel='stylesheet' type='text/css'>
<link href="assets/css.css" rel="stylesheet" type="text/css" />
<link href="homecss.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style37 {font-family: Tahoma, Verdana}
.style39 {font-family: Tahoma}
.style40 {
	font-size: 12px;
	font-weight: bold;
	font-family: Tahoma, Geneva, sans-serif;
}
.style42 {
	font-family: Tahoma, Verdana;
	font-weight: bold;
	font-size: 11px;
}
.style43 {
	color: #0000FF;
	font-weight: bold;
}
.style44 {color: #0000FF}
.style45 {color: #666666}
h3 {
	font-family: 'Josefin Sans', sans-serif;
	font-size: medium;
}
-->
</style>
<script type="text/javascript" src="ajax/ajax.js"></script>
<script type="text/javascript" src="js/homejs.js"></script>
<meta name="google-site-verification" content="j8eYP1fZjlvCFUswaHd-fkDxz0SSmaAHRNABmS4ZqAE" />
<!-- Place this tag in your head or just before your close body tag -->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script>
document.write('<script src="//sharebutton.net/plugin/sharebutton.php?type=vertical&u=' + encodeURIComponent(document.location.href) + '"></scr' + 'ipt>');
</script>
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
          <td align="center" valign="middle"><a href="widgets.php"><img src="assets/widget.gif" alt="Create a widget for your website" width="300" height="57" border="0" /><br />
          </a><a href="advertise.php"><img src="assets/advertise.jpg" width="307" height="86" border="0" alt="Advertise with us" /> </a></td>
        </tr>
        <tr>
          <td align="left" valign="top"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- 728x90, created 10/5/09 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:728px;height:90px"
                 data-ad-client="ca-pub-2732469417891860"
                 data-ad-slot="9338416308"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
          <?php //echo get_adv();?></td>
          <td width="25%" rowspan="2" align="center" valign="top" class="style1"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" bordercolor="#000000">
            <tr>
              <td width="234" align="center" class="commentlink">FEATURED VIDEO NEWS</td>
            </tr>
            <tr>
              <td align="center" valign="middle"><iframe frameborder="0" width="320" height="180" src="//www.dailymotion.com/embed/video/x2gsis0" allowfullscreen></iframe><br /><a href="http://www.dailymotion.com/video/x2gsis0_the-best-of-the-2015-grammys_lifestyle" target="_blank">The best of the 2015 Grammys</a> <i>by <a href="http://www.dailymotion.com/Mashable" target="_blank">Mashable</a></i></td>
            </tr>
          </table>
            <br />
            
            <div>
               <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- medium_rec_nt -->
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:300px;height:250px"
                         data-ad-client="ca-pub-2732469417891860"
                         data-ad-slot="5546605186"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
               </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="3" class="round_edge">
              <tr>
                <td bgcolor="#FF0000"><span class="style12 style15">Send me Nigerian news daily</span></td>
              </tr>
              <tr>
                <td height="100" align="left" valign="top" bordercolor="#FF0000"><form id="newsletter" name="newsletter" method="post" action="newsletter.php">
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
            <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fnewsng&amp;width=300&amp;height=258&amp;colorscheme=dark&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=327904692139" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:258px; width:300px;" allowTransparency="true"></iframe>
            <br /><br />
            <a href="http://www.iwfionline.org/" target="_blank"><img src="adverts/iwfi.jpg" alt="Institute for Work and Family Integration" style="border:1px #003 solid" width="300" height="300" border="0" /></a><br />
            <br />
            <a href="http://www.radioglobalng.com/" target="_blank"><img src="adverts/radioglobal.jpg" alt="Radio Global Nigeria" style="border:1px #CCC solid" width="300" height="122" border="0" /></a><br />
<br />
<iframe src="http://gbege.com/widget/?bc=&hc=Red&f=Tahoma&n=10&mh=off" frameborder="0" height="300" width="300" scrolling="auto"></iframe><br /><br />
            <iframe src="http://nigeriatraffic.com/widget/?bc=&hc=&f=Tahoma&n=10&mh=off" frameborder="0" height="300" width="300" scrolling="auto"></iframe>
            <br /><br />
            <table width="100%" border="0" cellspacing="0" cellpadding="3" class="round_edge">
            <tr>
              <td align="center" bgcolor="#0000FF"><span class="style18">TOP STORIES</span></td>
              </tr>
            <tr>
              <td align="left" class="topstories">
                <?php
                topstories ($link,$pubdate);
                ?>              </td>
              </tr>
            
            
          </table><br />
            
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="JobbermanJobs"></div>   
			<script type='text/javascript' src="http://widget.jobberman.com/widget.js"></script>
            <script type='text/javascript'>
            var JobberWidgetOptions = {
              "specialization":"50,72,53,83,54,84,85,82,76,56,79,66,59,60,61,67,101,58,51,81,68,74,105,70,103,71,106,77,104",
              "header_text":"Jobs in Nigeria by Jobberman.com",
              "height":"400",
              "width":"300",
              "count":"25",
              "show_search":"true",
              "container_bgcolor":"#2E52A1",
              "container_text_color":"#182137",
              "link_color":"#000088",
              "search_fields":"specialization,industry,experience,keywords"
            };
            JobberWidget('JobbermanJobs', JobberWidgetOptions);
			</script>    
           </td>
      </tr>
    </table>

<br />
<div></div>
<br />
            <table width="100%" border="0" cellspacing="0" cellpadding="5" class="round_edge">
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
            </table><br />
            <table width="100%" border="0" cellspacing="0" cellpadding="5" class="round_edge">
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
              <div class="round_edge">
                  <div class="style14" style="background-color:#CF9; padding:10px;"><a href="newspapers.php">Nigerian Newspapers</a> Currently Covered</div>
                  <div class="style14"><a href="newspapers.php?p=punch&amp;txt=the_punch">The Punch</a></div>
                  <div class="style14"><a href="newspapers.php?p=thisday&amp;txt=thisday">Thisday</a></div>
                  <div class="style14"><a href="newspapers.php?p=guardian&amp;txt=the_guardian">Guardian</a></div>
                  <div class="style14"><a href="newspapers.php?p=vanguard&amp;txt=vanguard">Vanguard</a></div>
                  <div class="style14"><a href="newspapers.php?p=independent&amp;txt=daily_independent">Daily Independent</a></div>
                  <div class="style14"><a href="newspapers.php?p=sunnews&amp;txt=daily_sun">Daily Sun</a></div>
                  <div class="style14"><a href="newspapers.php?p=tribune&amp;txt=nigerian_tribune">Nigerian Tribune</a></div>
                  <div class="style14"><a href="newspapers.php?p=businessday&amp;txt=business_day">Business Day</a></div>
                  <div class="style14"><a href="newspapers.php?p=thenation&amp;txt=the_nation">The Nation</a></div>
                  <div class="style14"><a href="newspapers.php?p=dailytrust&amp;txt=daily_trust">Daily Trust</a></div>
                  </div>
              <br />
              <div>
              
              <h3><a name="comments" id="comments"></a>Thank you for Visiting NewsNG.com, kindly tell us what features you would want to see on NewsNG, and  what you want removed. Thank you.</h3>
              <div><img src="assets/opinions.png" width="325" height="211" alt="Share your opinions" /></div>
              <div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'nigerianewspapers';
    
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript></div>
              <br />
              <div><a href="http://sitetrail.com/newsng.com"><img src="http://sitetrail.com/widgets/value/newsng.com" border="0" /></a></div></td>
        </tr>
        
        <tr>
          <td width="75%" align="left" valign="top">
                <div><script type="text/javascript"><!--
            google_ad_client = "pub-2732469417891860";
            /* 728x15, created 10/5/09 */
            google_ad_slot = "3415098669";
            google_ad_width = 728;
            google_ad_height = 15;
            //-->
            </script>
                    <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>                </div><br />
              
            <div class="bdydivs" id="bdivone">
              <div class="catdiv">
                <div><img src="assets/newsbar.gif" width="150" height="31" alt="News" /></div>
                <div><?php 
				$new_news = new get_news("News",$pubdate);
				echo $new_news->html;
				?></div>
                <div class="catdivbottom more">more News stories:<br />
                          <?php 
							echo $new_news->more;
							?></div>
              </div>
              
              <div style="padding-left:20px;">
				  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- medium_rec_nt -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:250px"
                     data-ad-client="ca-pub-2732469417891860"
                     data-ad-slot="5546605186"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
              </div>
              
              <div class="catdiv">
                <div><img src="assets/politicsbar.gif" width="150" height="31" alt="Politics" /></div>
                <div><?php 
			  $new_politics = new get_news("Politics",$pubdate);
			  echo $new_politics->html;
			  ?></div>
                <div class="catdivbottom more">more Politics stories:<br />
                            <?php 
			  echo $new_politics->more;
			  ?></div>
              </div>
              
              <div class="catdiv">
                <div><img src="assets/technologybar.gif" width="150" height="31" alt="Technology" /></div>
                <div><?php 
			  $new_technology = new get_news("Technology",$pubdate);
			  echo $new_technology->html;
			  ?></div>
                <div class="catdivbottom more">more Technology stories:<br />
                          <?php 
			  echo $new_technology->more;
			  ?></div>
              </div>
              
              <div class="catdiv">
                <div><img src="assets/fashionbar.gif" width="150" height="31" alt="Fashion" /></div>
                <div><?php 
			$new_fashion = new get_news("Fashion",$pubdate);
			echo $new_fashion->html;
			?></div>
                <div class="catdivbottom more">more Fashion stories:<br />
                          <?php 
			  echo $new_fashion->more;
			  ?></div>
              </div>
            </div>
            
            <div class="bdydivs" id="bdivtwo">
            <div class="catdiv">
                <div><img src="assets/businessbar.gif" width="150" height="31" alt="Business" /></div>
                <div><?php 
			$new_business = new get_news("Business",$pubdate);
			echo $new_business->html;
			?></div>
                <div class="catdivbottom more">more Business stories:<br />
                          <?php 
							  echo $new_business->more;
							  ?></div>
              </div>
              
              <div class="catdiv">
                <div><img src="assets/sportsbar.gif" width="150" height="31" alt="Sports" /></div>
                <div><?php 
					  $new_sports = new get_news("Sports",$pubdate);
					  echo $new_sports->html;
					  ?></div>
                <div class="catdivbottom more">more Sports stories:<br />
                            <?php 
							  echo $new_sports->more;
							  ?></div>
              </div>
              
              <div class="catdiv">
                <div><img src="assets/healthbar.gif" width="150" height="31" alt="Health" /></div>
                <div><?php 
					  $new_health = new get_news("Health",$pubdate);
					  echo $new_health->html;
					  ?></div>
                <div class="catdivbottom more">more Health stories:<br />
                          <?php 
							  echo $new_health->more;
							  ?></div>
              </div>
              
              
            <div class="catdiv">
                <div><img src="assets/entertainmentbar.gif" width="202" height="31" alt="Entertainment" /></div>
                <div><?php 
					  $new_ent = new get_news("Entertainment",$pubdate);
					  echo $new_ent->html;
					  ?></div>
                <div class="catdivbottom more">more Entertainment stories:<br />
                            <?php 
			  echo $new_ent->more;
			  ?></div>
              </div>
            </div>
            </td>
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
</body>
</html>
