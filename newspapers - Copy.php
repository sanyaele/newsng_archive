<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nigerian Newspapers and current Nigerian News here</title>
<link href="assets/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {	font-family: Tahoma;
	font-size: 12px;
}
.style14 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCC33" class="allborder">
  <tr>
    <td bgcolor="#FFFFFF"><?php
	include_once 'header.html';
	?>
      <table width="100%" border="0" cellpadding="3" cellspacing="2" bordercolor="#CCCCCC">
        
        
        <tr>
          <td align="center" class="style14"><script type="text/javascript"><!--
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
        </tr>
        <tr>
          <td align="center" bgcolor="#ECE9D8" class="style14"><h1>Nigerian Newspapers  below</h1>
          <p><a href="newspaper_articles.php?p=punch" target="newsframe">The Punch</a> | <a href="newspaper_articles.php?p=thisday" target="newsframe">Thisday</a> | <a href="newspaper_articles.php?p=guardian" target="newsframe">Guardian</a> | <a href="newspaper_articles.php?p=vanguard" target="newsframe">Vanguard</a> | <a href="newspaper_articles.php?p=independent&amp;txt=daily_independent" target="newsframe">Daily Independent</a> | <a href="newspaper_articles.php?p=sunnews&amp;txt=daily_sun" target="newsframe">Daily Sun</a> | <a href="newspaper_articles.php?p=tribune&amp;txt=nigerian_tribune" target="newsframe">Nigerian Tribune</a> | <a href="newspaper_articles.php?p=businessday&amp;txt=business_day" target="newsframe">Business Day</a> | <a href="newspaper_articles.php?p=thenation&amp;txt=the_nation" target="newsframe">The Nation</a> | <a href="newspaper_articles.php?p=dailytrust&amp;txt=daily_trust" target="newsframe">Daily Trust</a></p></td>
        </tr>
      </table>
    <iframe width="100%" height="500" frameborder="0" id="newsframe" name="newsframe" scrolling="Auto" src="newspaper_articles.php?p=<?php echo $_GET['p'];?>&amp;txt=<?php echo $_GET['txt'];?>"></iframe><br />

    <table width="100%" border="0" cellpadding="5" cellspacing="5" bgcolor="#FFFFFF">
      <tr>
        <td><?php
	include_once 'footer.html';
	?></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
