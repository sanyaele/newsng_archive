<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Contact Us at Nigerian News</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Contact NewsNG.com">
<meta name="author" content="">
<link href="css/reset.css" rel="stylesheet">
<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" />
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
                	<li class="home-menu-item"><a href="index.php">Home</a></li>
                    <li><a href="category.php?news=news">News</a></li>
                    <li><a href="category.php?news=business">Business</a></li>
                    <li><a href="category.php?news=politics">Politics</a></li>
                    <li><a href="category.php?news=sports">Sports</a></li>
                    <li><a href="category.php?news=technology">Tech</a></li>
                    <li><a href="category.php?news=health">Health</a></li>
                    <li><a href="category.php?news=entertainment">Entertainment</a></li>
                    <li><a href="about-us.html">About Us</a></li>
                    <li class="current-menu-item"><a href="contact.php">Contact</a></li>
                </ul><!--main-menu-->
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
                    <span>You are here:</span>
                    <span class="current-page">Contact Us</span>
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
                	<h5 class="contact-title">Contact Us</h5>
                	<div id="respond" class="kopa-border-2">
                    <h3>Leave a message</h3>
                        <form id="contact-form" class="clearfix" action="processForm.php" method="post">                
                            <p class="textarea-block">                        
                                <label class="required" for="contact_message"><span>Your Message</span></label>
                                <textarea rows="6" cols="80" id="contact_message" name="message"></textarea>
                            </p>
                            <p class="input-block clearfix">
                                <label class="required" for="contact_name"><span>Your Name (required)</span></label>
                                <input class="valid" type="text" name="name" id="contact_name" value="">
                            </p>
                            <p class="input-block">
                                <label class="required" for="contact_email"><span>Your Email (required)</span></label>
                                <input type="email" class="valid" name="email" id="contact_email" value="">
                            </p>
                            <p class="input-block last">
                                <label class="required" for="contact_url"><span>Website</span></label>
                                <input type="url" class="valid" name="url" id="contact_url" value="">
                            </p>
                            <div class="clear"></div>                            
                            <p class="contact-button clearfix">                    
                                <input type="submit" id="submit-contact" value="Submit">
                            </p>                        
                        </form>
                        <div id="response"></div>
                    </div><!--end:respond-->                    
                </div><!--column-b-->
                <div class="column-a"> 
                    <section class="widget">
                        <h4 class="widget-title">3 Thorborn Avenue, Sabo, Yaba</h4>
                        <div class="google-map kopa-border-1">
                            <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><div style="overflow:hidden;height:400px;width:300px;"><div id="gmap_canvas" style="height:400px;width:300px;"><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div></div><script type="text/javascript"> function init_map(){var myOptions = {zoom:16,center:new google.maps.LatLng(6.506789883753431,3.3751331994139946),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(6.506789883753431, 3.3751331994139946)});infowindow = new google.maps.InfoWindow({content:"<b>NewsNG</b><br/>3 thorborn avenue, Sabo, Yaba<br/> Lagos" });google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
                            
                            
                            
                            
                        </div><!--google-map-->
                    </section><!--widget-->                    
                </div><!--column-a-->
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
</div><!--page-bottom-->>
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jflickrfeed.min.js"></script>
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
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
