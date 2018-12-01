<?php
require_once '../includes/admin_sess.php';
require_once '../includes/get_video.php';
//////////////////////////////////////////

function addvideo ($link, $video){
	if (preg_match("/\?v=(.*)&/",$video,$vidarray)):
		foreach ($vidarray as $key=>$value){
			if ($key=='1'):
				$video = addslash(substr($value,0,15));
			endif;
		}
	else:
		$video = addslash(substr($video,0,15));
	endif;
	
	$sql = "INSERT INTO videos SET
	video = '$video'";
	if (@mysqli_query($link, $sql)):
		return "A new video has been added";
	else:
		return "There was a problem adding this video";
	endif;
}

if (!empty($_POST['newvideo'])):
	$mess = addvideo ($link, $_POST['newvideo']);
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Video</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style14 {font-size: 10px; font-weight: bold; }
.style15 {
	color: #FFFFFF;
	font-family: Tahoma, Verdana;
	font-size: 11px;
}
.style16 {
	color: #000000;
	font-family: Tahoma, Verdana;
	font-size: 11px;
}
-->
</style>
</head>

<body>
<table width="300" border="0" align="center" cellpadding="2" cellspacing="0" bordercolor="#000000" class="allborder">
  <tr>
    <td align="center" class="style14">FEATURED VIDEO NEWS</td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style15"><?php echo $mess;?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><form id="addvideo" name="addvideo" method="post" action="">
      <label>
        <input name="newvideo" type="text" class="style16" id="newvideo" />
        </label>
      <label>
      <input name="add" type="submit" class="style16" id="add" value="Add Video" />
      </label>
    </form>    </td>
  </tr>
  <tr>
    <td align="center" valign="middle"><iframe title="YouTube video player" width="100%" height="300" src="http://www.youtube.com/embed/<?php echo get_video ($link);?>" frameborder="0" allowfullscreen="allowfullscreen"></iframe></td>
  </tr>
</table>
</body>
</html>
