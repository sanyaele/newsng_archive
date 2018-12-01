<?php
require_once 'includes/db.php';
require_once 'includes/common.php';
/////////////////////////////////

function subscribe ($link, $email){
	$sql = "INSERT INTO mailing_list SET
	email = '$email'
	ON DUPLICATE KEY UPDATE subscription='1'";
	//echo $sql;
	if (@mysqli_query($link, $sql)):
		if ($subid = mysqli_insert_id($link)){
			return $subid;
		} else{
			return 'reactivate';
		}
		
	else:
		return FALSE;
	endif;
}
//////////////////////////////////

$mess = '<div style="font-size:28px;">Subscribe to our Newsletter</div>';
//////////////////////////////////
// Clean up the input values
foreach($_POST as $key => $value) {
	if(ini_get('magic_quotes_gpc'))
		$_POST[$key] = stripslashes($_POST[$key]);
	
	$_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
}

// Assign the input values to variables for easy reference
$email = $_POST["email"];

// Test input values for errors
$errors = array();
if(!$email) {
	$errors[] = "You must enter an email.";
} else if(!validEmail($email)) {
	$errors[] = "You must enter a valid email.";
}

// Store in db
if (!($subid = subscribe ($link, $email))){
	$errors[] = "Sorry, there was a problem adding you to our mailing list, please try again later.";
}

if($errors) {
	// Output errors and die with a failure message
	$errortext = "";
	foreach($errors as $error) {
		$errortext .= "<li>".$error."</li>";
	}
	$mess = "<span class='failure'>The following errors occured:<ul>". $errortext ."</ul></span>";
	
	
	
} else {
	if ($subid == 'reactivate'){
		$mess = "<span class='success'>Success! Your email address has been reactivated.</span>";
	} else {
		// Send the email
		$to = $email;
		$headers = "From: admin@newsng.com";
		$email = "
		Hello,
		
		Thank you for signing up for our weekly news letter on www.NewsNG.com
		
		To verify that you are the owner of this email address, click the link below:
		http://newsng.com/newsletter.php?email=".$email."&verify=".$subid."
		
		Thank you.
		
		The Administrator,
		www.NewsNG.com
		";
		
		mail($to, $headers, $email);
		
		// Die with a success message
		$mess = "<span class='success'>Success! Your email address has been sent.</span>";
	}
	
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Subscribe to our newsletter</title>
<link rel="alternate" type="application/rss+xml" href="feed.php" title="Today's Nigerian News" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link href="css/reset.css" rel="stylesheet">
<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/adipoli.css" type="text/css" media="screen" />
<link href="style.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">

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
<link rel="shortcut icon" href="img/favicon.ico">
<link rel="apple-touch-icon" href="img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">


</head>
<body class="sub-page v-divider">		
<header id="header">
	<div id="header-top">
    	<div class="wrapper">
        	<nav id="main-nav" class="clearfix">
        	  <ul id="main-menu" class="clearfix">
                	<li class="home-menu-item current-menu-item"><a href="index.php">Home</a></li>
                    <li><a href="category.php?news=news">News</a></li>
                    <li><a href="category.php?news=business">Business</a></li>
                    <li><a href="category.php?news=politics">Politics</a></li>
                    <li><a href="category.php?news=sports">Sports</a></li>
                    <li><a href="category.php?news=technology">Tech</a></li>
                    <li><a href="category.php?news=health">Health</a></li>
                    <li><a href="category.php?news=entertainment">Entertainment</a></li>
                    <li><a href="about-us.html">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
        	  <!--main-menu-->
            </nav><!--main-nav-->
        </div><!--wrapper-->
    </div><!--header-top-->
    <div id="header-bottom">
    	<div class="wrapper clearfix">
        	<div id="logo-image">
            	<a href="index.php"><img src="assets/logo.png" width="238" height="74"></a>
          </div><!--logo-image-->
            <div id="top-banner">
            	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- 728x90, created 10/5/09 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:728px;height:90px"
                 data-ad-client="ca-pub-2732469417891860"
                 data-ad-slot="9338416308"></ins>
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
                    <a href="index.html">Home</a>
                    <span class="current-page">&nbsp;&raquo;&nbsp;&nbsp;Newsletter</span>
                </div><!--breadcrumb-->
                <div id="search-social" class="clearfix">
                  <ul class="social-links clearfix">
                    <li class="twitter-icon"> <a target="_blank" title="Twitter" class="twitter" href="http://twitter.com/newsng"></a> </li>
                    <li class="facebook-icon"> <a target="_blank" title="Facebook" class="facebook" href="http://facebook.com/newsng"></a> </li>
                    <li class="linkedin-icon"> <a target="_blank" title="LinkedIn" class="linkedin" href="#"></a> </li>
                    <li class="tumblr-icon"> <a target="_blank" title="Tumblr" class="tumblr" href="#"></a> </li>
                  </ul>
                  <!--end:social-links-->
                  <div class="search-box clearfix">
                    <form action="http://www.google.com.ng" id="cse-search-box" target="_blank">
                      <input type="text" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" value="Search" name="q" class="search-text">
                      <input type="hidden" name="cx" value="partner-pub-2732469417891860:6010882360" />
                      <input type="hidden" name="ie" value="UTF-8" />
                      <input type="submit" value="" name="sa" class="search-submit">
                    </form>
                    <!-- search-form -->
                  </div>
                  <!--end:search-box-->
                </div>
                <!--search-social-->
            </div><!--main-content-top-->
            <div class="main-content-bottom clearfix">
                <div class="column-b">
                	<section class="widget">
                    	<div class="column-b-inner">   
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><span class="style10"><?php if (!empty($mess)){ echo $mess;} ?></span></td>
                </tr>
                
            </table>                    
                        <div class="clear"></div>
                            <div class="divider"></div>                        
                    	</div><!--column-b-inner-->
                        
                    </section><!--widget-->                    
                </div><!--column-b-->
                <div class="column-a">
                  <div class="news-letter clearfix">
                    <h4>Newsletter</h4>
                    <form class="newsletter-form" method="post" action="processNewsletterForm.php">
                      <p class="input-email clearfix">
                        <input type="text" size="40" class="email" value="Your email..." name="email" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';">
                        <input type="submit" class="submit" value="Submit">
                      </p>
                    </form>
                    <div id="newsletter-response"></div>
                  </div>
                  <!--news-letter-->
                  
                  
                  <?php echo custom_adverts (1); ?>
                  
                  <?php echo custom_adverts (2); ?>
                  
                  <?php echo custom_adverts (3); ?>
                  
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
	        <script type="text/javascript" src="https://widget.cheki.com.ng/v2/1.js?source=newsng"></script>
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
                    <p><a href="contact.php">Contact Us via email</a></p>
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
	        <li><a href="about-us.html">About</a></li>
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
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jquery.tweet.js"></script>
<script type="text/javascript" src="js/jflickrfeed.min.js"></script>
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="js/jquery.flexslider.js"></script>
<script type="text/javascript" src="js/modernizr.js"></script>
<script type="text/javascript" src="js/jquery.carouFredSel-5.6.4.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/jquery.adipoli.js"></script>
<script src="js/custom.js" charset="utf-8"></script>



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
