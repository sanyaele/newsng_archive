<?php
///////////////////////////////////
require_once 'includes/db.php';
require_once 'includes/common.php';
require_once 'includes/functions.php';
///////////////////////////////////
function get_articles ($link, $paper){
	$link1 = $link;
	///////////////
	$paper = addslash($paper);
	$sql = "SELECT articles.id, articles.title, articles.description, articles.img, articles.url, articles.article_date, articles.social_score, sources.source
		FROM articles, sources
		WHERE sources.source LIKE '%$paper%' 
		AND articles.sourceId = sources.id
		ORDER BY article_date DESC, 
		social_score DESC
		LIMIT 100";
	
	$result = @mysqli_query($link, $sql);
	while ($rows = @mysqli_fetch_assoc($result)){
		echo "<tr><td>";
		
		if (empty($show_ad)):
			echo '<div class="showad"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- medium_rec_nt -->
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:300px;height:250px"
                         data-ad-client="ca-pub-2732469417891860"
                         data-ad-slot="5546605186"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script></div>';
			$show_ad = 1;
		endif;
		
		echo "<h3 class=\"title_inner\" style=\"font-size: 22px; font-family: 'Josefin Sans', sans-serif;\"><a href=\"".$rows['url']."\" rel=\"nofollow\">".ucfirst($rows['title'])."</a></h3>
	  <p class=\"description\">$rows[description]<br />
	  <span class=\"sscore\">Buzz: <span style=\"color: #990000;\">$rows[social_score]</span></span><br />
		<strong class=\"sources\">Source: ".ucfirst($rows['source'])."</strong> | 
		<strong class=\"comment\"> ".get_comm_no ($link1, $rows['id'])." Comments</strong><br />
</p></td>
	  </tr>";
	}
}



if (!empty($_GET['txt'])):
	$tx = ucwords(str_replace("_", " ", $_GET['txt']));
elseif (!empty($_GET['p'])):
	$tx = ucfirst($_GET['p']);
else:
	header ("Location: newspaper_articles.php?p=punch");
endif;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name=viewport content="width=device-width, initial-scale=1">
<link href='http://fonts.googleapis.com/css?family=Josefin+Sans|Open+Sans' rel='stylesheet' type='text/css'>
<link href="assets/css.css" rel="stylesheet" type="text/css" />
<title><?php echo $tx;?> Newspaper in Nigeria</title>
<style type="text/css">
<!--
body {
	background-image: url(assets/1x1.gif);
	background-repeat: no-repeat;
	background-color: #FFFFFF;
}
.showad {
	padding: 2px;
	float: right;
	height: 260px;
	width: 310px;
	position: relative;
	visibility: visible;
	top: 30px;
	margin-top: 5px;
	margin-right: 0px;
	margin-bottom: 5px;
	margin-left: 5px;
}
h1 a{
	color: #030;
	font-size: 26px;
	font-weight: lighter;
	text-decoration: none;
}
-->
</style>
</head>

<body>
<h1><a href="index.php" target="_top"><?php echo $tx;?> Nigeria Newspaper Top Stories</a></h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- 728x90, created 10/5/09 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:728px;height:90px"
                 data-ad-client="ca-pub-2732469417891860"
                 data-ad-slot="9338416308"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script></td>
  </tr>
  <?php
  if (!empty($_GET['p'])):
	  get_articles ($link, $_GET['p']);
  endif;
  ?>
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
