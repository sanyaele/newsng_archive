<?php
////////////////////////
if (empty($_GET['redirct'])):
	$site_type = "detail";
	require_once 'includes/redirect.php';
endif;
///////////////////////////////////
require_once 'includes/db.php';
require_once 'includes/common.php';
require_once 'includes/functions.php';
///////////////////////////////////
class get_details {
	public $id;
	////////////////
	public $title;
	public $desc;
	public $links="";
	public $comments="";
	public $firstlink="";
	public $firstid;
	public $shortlink;
	public $story_img;
	
	function __construct($id, $type=''){
		global $link;
		////////////////
		$this->id = substr (addslash($id), 0, 15);
		
		if (!empty($type)):
			$this->bul_detail ($link);
		elseif ($this->story_detail ($link)):
			$this->comments = getcomments ($link, $this->id);
			if (empty($_SESSION['rated'][$this->id])):
				rate($link, $this->id);
			endif;
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
				
				$this->story_img = $rows['img'];
				$this->title = $rows['title'];
				
				$pos1 = strrpos($brows['description'], " ");
				if ($pos1 !== false):
					$brows['description'] = substr($brows['description'], 0, $pos1);
				endif;
				$brows['description'] .= '...';
				
				$this->desc = $rows['description'];
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
				$this->story_img = $rows['img'];
				$this->title = $rows['title'];
				$this->desc = $rows['description'];
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name=viewport content="width=device-width, initial-scale=1">
<title><?php echo $story->title; ?></title>
<link rel="alternate" type="application/rss+xml" href="feed.php" title="Today's Hottest Nigerian News" />
<link href='http://fonts.googleapis.com/css?family=Josefin+Sans|Open+Sans' rel='stylesheet' type='text/css'>
<link href="assets/css.css" rel="stylesheet" type="text/css" />
<link href="detailcss.css" rel="stylesheet" type="text/css" />
<link rel="shortlink" type="text/html" href="http://newsng.com/<?php echo $story->shortlink; ?>">
<script type="text/javascript" src="ajax/ajax.js"></script>
<script type="text/javascript" src="js/detail.js"></script>
<style type="text/css">
<!--
.nav {
	font-family: Tahoma, Verdana;
	font-size: 10px;
	font-weight: bold;
}
.nav a{
	color: #006600;	
}
h1 {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 18px;
	color: #060;
}
.comment_box {
	font-family: Tahoma, Verdana;
	font-size: 11px;
	height: 50px;
	width: 200px;
}
.style12 {color: #000000}
-->
</style>
</head>

<body onload="rating('<?php echo $story->firstid;?>')">
<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCC33" class="allborder">
<img src="<?php echo $story->story_img;?>" width="1" height="1" />
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="947" align="right" valign="top"><table width="100%" border="0" align="left" cellpadding="5" cellspacing="0" bordercolor="#009900">
          
          <tr>
            <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr bordercolor="#009900">
                <td width="57%" rowspan="2" align="left"><h1><?php echo $story->title; ?></h1></td>
                <td width="43%" align="right"><span class="nav"><a href="index.php">Home</a> | <a href="category.php?cat=news">News</a> | <a href="category.php?cat=business">Business</a> | <a href="category.php?cat=politics">Politics</a> | <a href="category.php?cat=sports">Sports</a> | <a href="category.php?cat=technology">Tech</a> | <a href="category.php?cat=health">Health</a> | <a href="category.php?cat=entertainment">Entertainment</a> | <a href="contact.php">Contact</a></span></td>
              </tr>
              <tr bordercolor="#009900">
                <td align="right"><form action="http://www.google.com.ng" id="cse-search-box" target="_blank">
                </form>
                  <script type="text/javascript" src="http://www.google.com.ng/coop/cse/brand?form=cse-search-box&amp;lang=en"></script></td>
              </tr>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr bordercolor="#009900">
                <td width="82%" align="left"><script type="text/javascript"><!--
					google_ad_client = "pub-2732469417891860";
					/* 728x90, created 10/5/09 */
					google_ad_slot = "9338416308";
					google_ad_width = 728;
					google_ad_height = 90;
					//-->
					</script>
                  <script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script></td>
                <td width="6%" align="center" valign="middle"><a onclick="Share.facebook('<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>','<?php echo $story->title; ?>','http://newsng.com/assets/new_logo.gif','Share on Facebook')"><img src="assets/fb.gif" width="64" height="64" alt="Share on Facebook" /></a></td>
                <td width="6%" align="center" valign="middle"><a onclick="Share.twitter('<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>','<?php echo $story->title; ?>')"><img src="assets/tw.gif" width="64" height="63" alt="Share on Twitter" /></a></td>
                <td width="6%" align="center" valign="middle"><a onclick="Share.linkedin('<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>','<?php echo $story->title; ?>')"><img src="assets/ln.gif" width="64" height="64" alt="Share on LinkedIn" /></a></td>
                <td width="6%" align="center" valign="middle"><a href="https://plus.google.com/share?url=<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" onclick="javascript:window.open(this.href,
  '<?php echo $story->title; ?>', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img
  src="assets/gplus.gif" alt="Share on Google+"/></a></td>
              </tr>
              </table></td>
            </tr>
          
        </table></td>
        <td width="17" align="right" valign="top">&nbsp;</td>
      </tr>
      
    </table>
      <table width="100%" border="0" cellspacing="2" cellpadding="5">
        <tr>
          <td width="20%" valign="top" bordercolor="#B1C3D9" bgcolor="#F5F8FA" class="allborder"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div class="style9"><?php echo $story->desc; ?></div></td>
            </tr>
          </table>
            <table width="98%" border="0" align="center" cellpadding="3" cellspacing="0" bordercolor="#B1C3D9" class="allborder">
            <tr>
              <td align="center" bordercolor="#CCCC33" bgcolor="#B1C3D9"><span class="style8 style12">ADD  COMMENTS</span></td>
            </tr>
            <tr>
              <td bordercolor="#CCCC33"><form id="comments" name="comments" method="post" action="">
                  <table width="203" border="0" align="center" cellpadding="3" cellspacing="0" bordercolor="#009900">
                    <tr>
                      <td align="right"><span class="style1">Name</span></td>
                      <td align="left"><input name="name" type="text" class="form_box" id="name" value="<?php echo $_SESSION['name'];?>" size="25" /></td>
                    </tr>
                    <tr>
                      <td width="46" align="right"><label><span class="style1">Email</span></label></td>
                      <td width="183" align="left"><input name="email" type="text" class="form_box" id="email" value="<?php echo $_SESSION['email'];?>" size="25" /></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left"><label>
                        <textarea name="comment" class="comment_box" id="comment" onfocus="clear_textbox('comment')" onkeyup="countchars('comment','charscount')" <?php if (!empty($_GET['type'])){echo 'disabled="disabled"';}?>>Your comment here ...</textarea>
                      </label></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" class="style5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="59%" align="left"><span class="style6">Maximum 500 xters</span></td>
                            <td width="26%" align="right"><div id="charscount"></div></td>
                            <td width="15%" align="left"> chars</td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center" bgcolor="#FFFFFF"><label>
                        <input name="news_id" type="hidden" id="news_id" value="<?php echo $_GET['story']; ?>" />
                        <img src="assets/add_comment.gif" alt="Add a comment" width="108" height="24" border="0" style="cursor:pointer" <?php if (empty($_GET['type'])){ echo "onclick=\"put_comment()\"";}?> /></label></td>
                    </tr>
                  </table>
              </form></td>
            </tr>
          </table>
          <div id="see_comments" style="width: 100%; height: 1000px; overflow: auto; scrollbar-arrow-color: blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color: #888888;">
              <p><?php echo $story->comments; ?></p>
          </div></td>
          <td width="80%" valign="top" bordercolor="#66FF02"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="70%">
                       
                        <script type="text/javascript"><!--
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
                      <td width="30%" align="right"><a href="send2email.php?story=<?php echo $_GET['story']; ?>" target="show"><img src="assets/sendfriend.png" alt="Send this story to your friends" width="113" height="23" border="0" /></a></td>
                    </tr>
                </table></td>
            </tr>
          </table>
          <iframe name="show" id="show" title="Show Details" src="<?php echo $story->firstlink;?>" width="100%" frameborder="0" height="1500px"></iframe>
              <br />
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;
                      <script type="text/javascript"><!--
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
          </table></td>
        </tr>
        <tr>
          <td bordercolor="#66FF02">&nbsp;</td>
          <td style="font-size: 10px"><?php
	include_once 'footer.html';
	?></td>
        </tr>
      </table>
    <script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
      </script></td>
  </tr>
</table>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7718160-3");
pageTracker._trackPageview();
} catch(err) {}</script>
<script type="text/javascript">
Share = {
facebook: function(purl, ptitle, pimg, text) {
url = 'http://www.facebook.com/sharer.php?s=100';
url += '&p[title]=' + encodeURIComponent(ptitle);
url += '&p[summary]=' + encodeURIComponent(text);
url += '&p[url]=' + encodeURIComponent(purl);
url += '&p[images][0]=' + encodeURIComponent(pimg);
Share.popup(url);
},
twitter: function(purl, ptitle) {
url = 'http://twitter.com/share?';
url += 'text=' + encodeURIComponent(ptitle);
url += '&url=' + encodeURIComponent(purl);
url += '&counturl=' + encodeURIComponent(purl);
Share.popup(url);
},
linkedin: function(purl, ptitle) {
url = 'http://www.linkedin.com/shareArticle?mini=true';
url += '&url=' + encodeURIComponent(purl);
url += '&title=' + encodeURIComponent(ptitle);
Share.popup(url);
},
popup: function(url) {
window.open(url,'','toolbar=0,status=0,width=626, height=436');
}
};
</script>

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
