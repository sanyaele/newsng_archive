<?php
////////////////////////
require_once '../includes/db.php';
require_once '../includes/common.php';
require_once '../includes/functions.php';
require_once '../includes/popular.php';
///////////////////////////////////
class get_details {
	public $id;
	public $title;
	public $desc;
	public $links="";
	public $comments="";
	public $firstlink="";
	public $firstid;
	public $shortlink;
	public $story_img;
	public $social;
	public $source;
	public $cat;
	public $dat;
	public $pageurl;
	public $shortcode;
	
	function __construct($id, $type=''){
		global $link;
		////////////////
		$this->id = substr (addslash($id), 0, 15);
		
		if (!empty($type)):
			$this->bul_detail ($link);
		elseif ($this->story_detail ($link)):
			$this->comments = getcomments ($link, $this->id); 
		else:
			header ("Location: index.php");
		endif;
	}
	
	function bul_detail ($link){
		$result = get_bul ($link, $this->id);
		if (@mysqli_num_rows($result) > 0):
			while ($rows = @mysqli_fetch_assoc($result)){
				if (empty($this->firstlink)):
					$this->firstlink = 'view_bulletin.php?id='.$rows['id'];
					$this->firstid = $rows['id'];
				endif;
				
				if(!empty($rows['img'])){
					$this->story_img = $rows['img'];
				} else {
					$this->story_img = "placeholders/351x192/351x192-1.jpg";
				}
				
				$this->title = $rows['title'];
				
				$pos1 = strrpos($rows['description'], " ");
				if ($pos1 !== false):
					$rows['description'] = substr($rows['description'], 0, $pos1);
				endif;
				$rows['description'] .= '...';
				
				$this->desc = $rows['description'];
				$this->social = "N/A";
				$this->source = "NewsNG";
				$this->cat = "Sponsored";
				$this->dat = $rows['storyDate'];
				$this->pageurl = 'story-detail.php?title='.urlencode(str_replace (" ", "-", $rows['title'])).'&story='.$rows['id'];
			}
			
			/*/ SEO friendly URL //////////////////////////////////////////////////////////////////////////
			$url_title = stripslashes (urlencode(str_replace (" ", "-", $this->title)));// replace spaces in title
			$title =  urlencode($_GET['title']);
			
			if ($title != $url_title):
				//echo $title."<br />".$url_title;
				//exit();
				
				header ("Location: story-detail.php?title=$url_title&story=$this->id&type=b");
			endif;
			/////////////////////////////////////////////////////////////////////////////////////////////*/
			
			return TRUE;
		else:
			return FALSE;
		endif;
		
	}
	
	function story_detail ($link){
		$result = get_art ($link, $this->id);
		if (@mysqli_num_rows($result) > 0):
			while ($rows = @mysqli_fetch_assoc($result)){
				if (empty($this->firstlink)):
					$this->firstlink = $rows['url'];
					$this->firstid = $rows['id'];
				endif;
				
				$this->shortlink = $rows['code'];
				
				
				if(!empty($rows['img'])){
					$this->story_img = $rows['img'];
				} else {
					$this->story_img = "placeholders/351x192/351x192-1.jpg";
				}
				
				$this->title = $rows['title'];
				$this->desc = $rows['description'];
				$this->social = $rows['social_score'];
				$this->source = $rows['source'];
				$this->cat = $rows['category'];
				$this->dat = $rows['article_date'];
				$this->pageurl = 'story-detail.php?title='.urlencode(str_replace (" ", "-", $rows['title'])).'&story='.$rows['id'];
			}
			
			/*/ SEO friendly URL //////////////////////////////////////////////////////////////////////////
			$url_title = stripslashes (urlencode(str_replace (" ", "-", $this->title)));// replace spaces in title
			$title =  urlencode($_GET['title']);
			
			if ($title != $url_title):
				//echo $title."<br />".$url_title;
				//exit();
				
				header ("Location: story-detail.php?title=$url_title&story=$this->id");
			endif;
			/////////////////////////////////////////////////////////////////////////////////////////////*/
			
			return TRUE;
		else:
			return FALSE;
		endif;
		
	}
}
///////////////////////////////////
///////////////////////////////////

///////////////////////////////////
if (empty($_GET['story'])):
	header ("Location: index.php");
else:
	// get story details
	if (!empty($_GET['type'])):
		$story = new get_details($_GET['story'], 'b');
	else:
		$story = new get_details($_GET['story']);
	endif;
	
endif;

//header ("Link: <http://newsng.com/$story->shortlink>; rel='shortlink'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $story->title; ?></title>
<link rel="alternate" type="application/rss+xml" href="../feed.php" title="Today's Hottest Nigerian News" />
<link rel="shortlink" type="text/html" href="http://newsng.com/<?php echo $story->shortlink; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="stylesheet" href="../colorbox/colorbox.css" />
<link href="../css/reset.css" rel="stylesheet">
<link href="../style.css" rel="stylesheet">
<link href="../css/responsive.css" rel="stylesheet">

<link href='http://fonts.googleapis.com/css?family=Coda:400,800' rel='stylesheet' type='text/css'>

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if IE 7]><link rel="stylesheet" href="css/ie7.css" type="text/css" media="all" /><![endif]-->
<!--[if IE 8]><link rel="stylesheet" href="css/ie8.css" type="text/css" media="all" /><![endif]-->
<!--[if IE ]><link rel="stylesheet" href="css/ie.css" type="text/css" media="all" /><![endif]-->
<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="../img/favicon.ico">
<link rel="apple-touch-icon" href="../img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="../img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="../img/apple-touch-icon-114x114.png">
<script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
<script src="../colorbox/jquery.colorbox.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	//Examples of how to assign the Colorbox event to elements
	$(".ajax").colorbox();
	$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	$(".inline").colorbox({inline:true, width:"50%"});
	
	//Example of preserving a JavaScript event for inline calls.
	$("#click").click(function(){ 
		$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
		return false;
	});
});

/* =========================================================
Scroll to top
============================================================ */
jQuery(document).ready(function(){

	// hide #back-top first
	jQuery("#back-top").hide();
	
	// fade in #back-top
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 200) {
				jQuery('#back-top').fadeIn();
			} else {
				jQuery('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		jQuery('#back-top a').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});
</script>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-2732469417891860",
    enable_page_level_ads: true
  });
</script>
</head>
<body class="sub-page v-divider">		
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '361222975195',
      xfbml      : true,
      version    : 'v2.7'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

<header id="header">
	<div id="header-top">
    	<div class="wrapper">
        	<nav id="main-nav" class="clearfix">
            	<ul id="main-menu" class="clearfix">
                	<li class="home-menu-item"><a href="../index.php">Home</a></li>
                    <li><a href="../category.php?news=news">News</a></li>
                    <li><a href="../category.php?news=business">Business</a></li>
                    <li><a href="../category.php?news=politics">Politics</a></li>
                    <li><a href="../category.php?news=sports">Sports</a></li>
                    <li><a href="../category.php?news=technology">Tech</a></li>
                    <li><a href="../category.php?news=health">Health</a></li>
                    <li><a href="../category.php?news=entertainment">Entertainment</a></li>
                    <li><a href="../about-us.html">About Us</a></li>
                    <li><a href="../contact.php">Contact</a></li>
                </ul><!--main-menu-->
            </nav><!--main-nav-->
        </div><!--wrapper-->
    </div><!--header-top-->
    <div id="header-bottom">
    	<div class="wrapper clearfix">
        	<div id="logo-image">
            	<a href="../index.php"><img src="../assets/logo.png" width="238" height="74"></a>
          </div><!--logo-image-->
            <div id="top-banner">
            	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- mobBanner -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:320px;height:100px"
                 data-ad-client="ca-pub-2732469417891860"
                 data-ad-slot="1601837472"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
            </div><!--top-banner-->
        </div><!--wrapper-->
    </div><!--header-bottom-->
</header><!--header-->
<div class="wrapper clearfix">
	<div id="main-content">
    	<div id="main-content-inner">
            <div class="main-content-top clearfix">
                <div class="breadcrumb clearfix">
                    <span>You are here:&nbsp;</span>
                    <a href="../index.html">Home</a>
                    <span class="current-page">&nbsp;&raquo;&nbsp;&nbsp;<a href="../category.php?news=<?php echo strtolower($story->cat); ?>"><?php echo $story->cat; ?></a></span>
                    <span class="current-page">&nbsp;&raquo;&nbsp;&nbsp;<?php echo $story->title; ?></span>
                </div><!--breadcrumb-->
                <div id="search-social" class="clearfix">				 
                    <ul class="social-links clearfix">                        
                        <li class="twitter-icon">
                            <a target="_blank" title="Twitter" class="twitter" href="http://twitter.com/newsng"></a>
                        </li>
                        <li class="facebook-icon">
                            <a target="_blank" title="Facebook" class="facebook" href="http://facebook.com/newsng"></a>
                        </li>
                        <li class="linkedin-icon">
                            <a target="_blank" title="LinkedIn" class="linkedin" href="#"></a>
                        </li>
                        <li class="tumblr-icon">
                            <a target="_blank" title="Tumblr" class="tumblr" href="#"></a>
                        </li>                                       
                    </ul><!--end:social-links-->
                    <div class="search-box clearfix">
                        <form action="http://www.google.com.ng" id="cse-search-box" target="_blank">
                            <input type="text" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" value="Search" name="q" class="search-text">
                            <input type="hidden" name="cx" value="partner-pub-2732469417891860:6010882360" />
        					<input type="hidden" name="ie" value="UTF-8" />
                            <input type="submit" value="" name="sa" class="search-submit">
                        </form><!-- search-form -->
                    </div><!--end:search-box-->	
                </div><!--search-social-->
            </div><!--main-content-top-->
            <div class="main-content-bottom clearfix">
                <div class="column-b">
                	<section class="entry-box">
                    	<header class="clearfix">
                        	<span class="entry-meta">Update:&nbsp;</span>
                            <span class="entry-date"><?php echo date("F d, Y", strtotime($story->dat)); ?></span>
                            <span class="entry-meta">&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Source:&nbsp;</span>
                            <a class="entry-author" href="#"><?php echo $story->source; ?></a>
                            <a class="entry-comments" href="#"><?php echo $story->social; ?><span>&nbsp;</span></a>
                        </header>
                        <div class="entry-content clearfix">
                        	<h3 class="entry-title"><?php echo $story->title; ?></h3>
                            <img src="<?php echo $story->story_img;?>" alt="" class="kopa-border-1" />
                            <?php echo $story->desc; ?>
                            <a class='iframe readbut' href="<?php echo $story->firstlink;?>" target="show">Read Full Story</a>
                        </div><!--entry-content-->
                        <div class="kopa-tag-box">
                        	<a class="kopa-tag" href="#"><?php echo $story->cat; ?></a>
                        </div><!--kopa-tag-->
                  <div
                      class="fb-like"
                      data-share="true"
                      data-width="450"
                      data-show-faces="true">
                    </div>
                    </section><!--entry-box-->
                   <?php
				  /*//////////////////////
                   <a href="send2email.php?story=<?php echo $story->id; ?>" target="show"><img src="assets/sendfriend.png" alt="Send this story to your friends" width="113" height="23" border="0" /></a>
				  <iframe name="show" id="show" title="Show Details" src="<?php echo $story->firstlink;?>" width="100%" frameborder="1" height="700px"></iframe>
                  
                 <div class="clearfix">
                    <section class="related-widget">
                    	<h3><span>Related article</span></h3>
                        <ul class="clearfix">
                        <?php
						$related = get_related ($link, $story->id);
						while ($rows = @mysqli_fetch_assoc($related)){
							if (empty($rows['img'])){
								$rows['img'] = 'placeholders/50x50/50x50-1.jpg';
							}
							echo '<li>
                            	<article class="clearfix">
                                	<a class="entry-thumb kopa-border-1" href="story-detail.php?title='.urlencode(str_replace (" ", "-", $rows['title'])).'&story='.$rows['id'].'"><img src="'.$rows['img'].'" alt="" width="50" height="50" /></a>
                                    <div class="entry-content">
										<a href="story-detail.php?title='.urlencode(str_replace (" ", "-", $rows['title'])).'&story='.$rows['id'].'">'.$rows['title'].'</a>
                                        <span class="entry-date">'.date("d", strtotime($rows['article_date'])).' /</strong><span>'.date("F", strtotime($rows['article_date'])).' '.date("Y", strtotime($rows['article_date'])).'</span>
                                        <span class="entry-meta">&nbsp;&nbsp;-&nbsp;&nbsp;</span>
										<span class="entry-comments">'.$rows['social_score'].' Buzz <span>'.get_comm_no ($link, $rows['id']).' Comments</span></span
                                    </div><!--entry-content-->
                                </article>
                            </li>';
						}
						?>
                        </ul>
                    </section><!--related-widget-->
                    </div>
                    //////////////*/
                    ?>
                  <div class="clearfix">
                  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- NewsngMatch -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-2732469417891860"
                         data-ad-slot="9264705077"
                         data-ad-format="autorelaxed"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    </div>
                 <?php
				 // Our Legacy Comment system
				 /*//////////////////////////////////////////////////
				 ?>
                 <div id="comments">
                        <h3><?php echo get_comm_no ($link, $story->id);?> Comments</h3>
                        <ol class="comments-list clearfix" id="artcomments">
                            <?php echo $story->comments; ?>                       
                        </ol><!--end:comments-list-->
                        <div class="comment-pagination clearfix">
                            <a href="#" class="prev page-numbers"> More </a>
                        </div>
                    <div class="clear"></div> </div><!--end:comments-->
					<div id="respond" class="kopa-border-2">
                        <h3>Leave a reply</h3>
                        <form id="comments-form" class="clearfix" action="processComment.php" method="post">                
                            <p class="textarea-block">                        
                                <label class="required" for="comment_message"><span>Your Message</span></label>
                                <textarea rows="6" cols="80" id="comment_message" name="message"></textarea>
                            </p>
                            <p class="input-block clearfix">
                                <label class="required" for="comment_name"><span>Your Name (required)</span></label>
                                <input class="valid" type="text" name="name" id="comment_name" value="">
                            </p>
                            <p class="input-block">
                                <label class="required" for="comment_email"><span>Your Email (required)</span></label>
                                <input type="email" class="valid" name="email" id="comment_email" value="">
                            </p>
                        <div class="clear"></div>                            <?php
						  require_once('../includes/recaptchalib.php');
						  $publickey = "6LfTFPcSAAAAAFBIf7HqNkfYk9FjPMdCRDhdP9JG"; // you got this from the signup page
						  echo recaptcha_get_html($publickey);
						?>
                            <p class="comment-button clearfix">                    
                                <input type="submit" id="submit-comment" value="Submit">
                              <input name="artid" type="hidden" id="artid" value="<?php echo $story->id; ?>"> <input name="replyid" type="hidden" id="replyid" value="">
                            </p>                        
                        </form>
                        <div id="response"></div>
                    </div><!--end:respond--> 
                    
                    <?php 
					/////////////////////////*/
					?>
                    
                  <div class="clearfix">
                    <div class="fb-comments" data-href="http://newsng.com/<?php echo $story->shortlink; ?>" data-width="100%" data-numposts="6"></div>
                    </div>
                </div><!--column-b-->
                <div class="column-a">
                  <div class="news-letter clearfix">
                    <h4>Newsletter</h4>
                    <form class="newsletter-form" method="post" action="../processNewsletterForm.php">
                      <p class="input-email clearfix">
                        <input type="text" size="40" class="email" value="Your email..." name="email" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';">
                        <input type="submit" class="submit" value="Submit">
                      </p>
                    </form>
                    <div id="newsletter-response"></div>
                  </div>
                  <!--news-letter-->
                  
                  
                  
                  <?php echo custom_adverts (4); ?>
                  
                  <?php echo custom_adverts (1); ?>
                  
                  <?php //echo custom_adverts (3); ?>
                  
                  
                  <section class="widget">
                    <h4 class="widget-title">All Time Most Popular Stories</h4>
                    <?php alltime($link);?>
                    <ul class="other-categories clearfix">
                    </ul>
                    <!--other-categories-->
                  </section>
                  <!--widget-->
                  <!--Google Ad-->
                  <section class="widget">
                    <script type="text/javascript"><!--
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
                  </section>
                  <!--Google Ad-->
                  <!--Facebook-->
                  <section class="widget">
                    <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fnewsng&amp;width=300&amp;height=258&amp;colorscheme=dark&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=327904692139" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:258px; width:300px;" allowTransparency="true"></iframe>
                  </section>
                  <!--Facebook-->
                  <!--widget-->
                </div>
                <!--column-a-->
                <div class="clear"></div>
            </div><!--main-content-bottom-->            
        </div><!--main-content-inner-->
    </div><!--main-content-->
</div><!--wrapper-->
<div class="page-bottom">
	<div class="wrapper">
	  <section class="bottom-sidebar">
	    <div class="one-forth">
	      <aside class="widget">
	        <h3 class="widget-title">About us</h3>
	        <div class="text-widget"> <span class="kp-dropcap dark">N</span>
	          <p>NewsNG.com provides the latest and most interesting Nigerian News.</p>
	          <p>Collecting Nigerian news from various sources across the Internet, comparing how the news is being shared and liked on the different Social Media platforms, to determine which stories people found most interesting.</p>
            </div>
	        <!--text-widget-->
          </aside>
	      <!--widget-->
        </div>
	    <!--one-forth-->
	    <div class="one-forth">
	      <aside class="widget">
          </aside>
	      <!--widget-->
        </div>
	    <!--one-forth-->
	    <div class="one-forth">
	      <aside class="widget">
	        <h3 class="widget-title">Tags</h3>
	        <a class="kp-tag" href="#"><span>Business</span></a> <a class="kp-tag" href="#"><span>Politics</span></a> <a class="kp-tag" href="#"><span>Health</span></a> <a class="kp-tag" href="#"><span>Sports</span></a> <a class="kp-tag" href="#"><span>Technology</span></a> <a class="kp-tag" href="#"><span>Fashion</span></a> <a class="kp-tag" href="#"><span>Entertainment</span></a> <a class="kp-tag" href="#"><span>What is</span></a> <a class="kp-tag" href="#"><span>TagCrowd</span></a> <a class="kp-tag" href="#"><span>Blog</span></a> <a class="kp-tag" href="#"><span>Help</span></a> </aside>
	      <!--widget-->
        </div>
	    <!--one-forth-->
	    <div class="one-forth last">
	      <aside class="widget">
	        <h3 class="widget-title">Contact Us</h3>
                    <div class="text-widget">
                    <p>NewsNG.com</p>
                    <p>3 Thorborn Avenue, Sabo, Yaba</p>
                    <p><a href="../contact.php">Contact Us via email</a></p>
                    </div>
          </aside>
	      <!--widget-->
        </div>
	    <!--one-forth-->
	    <div class="clear"></div>
      </section>
	  <!--bottom-sidebar-->
	  <footer id="footer" class="clearfix">
	    <p id="copyrights">Copyright &copy; 2016 NewsNG. All Rights Reserved</p>
	    <nav id="bottom-nav">
	      <ul class="bottom-menu clearfix">
	        <li><a href="../about-us.html">About</a></li>
	        <li><a href="#">Contact </a></li>
          </ul>
        </nav>
	    <!--bottom-nav-->
      </footer>
	  <!--footer-->
    </div><!--wrapper-->
    <p id="back-top">
        <a href="#top">Back to Top</a>
    </p>
</div><!--page-bottom-->









<script type="text/javascript" src="../js/jquery.cookiebar.js"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.7&appId=144403398969866";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

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
