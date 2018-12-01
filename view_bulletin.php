<?php
require_once 'includes/db.php';
require_once 'includes/common.php';
///////////////////////////////////
function get_details ($link){
	$newsid = addslash ($_GET['id']);
	$sql = "SELECT * FROM bulletin WHERE id='$newsid' LIMIT 1";
	$result = @mysqli_query($link, $sql);
	$row = @mysqli_fetch_assoc($result);
	return ($row);
}
/////////////////////////
if(!empty($_GET['id'])):
	$news_det = get_details($link);
else:
	exit();
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Bulletin</title>
<style type="text/css">
.titleformat {
	font-size: 24px;
	font-family: Tahoma, Geneva, sans-serif;
	color: #069;
}
.sourceformat {
	font-size: 11px;
	color: #999;
}
.bodyformat {
	color: #000;
	font-size: 12px;
	font-family: Tahoma, Geneva, sans-serif;
	font-style: normal;
	line-height: 28px;
	text-align: justify;
}
body {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	color: #000;
	background-color: #FFF;
	margin: 5px;
}
</style>

</head>

<body>
<table width="700" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="left" class="titleformat"><?php echo $news_det['title'];?></td>
  </tr>
  <tr>
    <td align="left" class="bodyformat"><?php 
	if (!empty($news_det['img'])):
		echo "<img src=\"$news_det[img]\" height=\"150\" alt=\"$news_det[title]\" align=\"left\" hspace=\"8\" vspace=\"8\" />";
	endif;
	echo nl2br($news_det['description']);
	?></td>
  </tr>
  <tr>
    <td height="50" align="left" valign="bottom" class="sourceformat"><strong>Source:</strong> NewsNG.com Bulletin</td>
  </tr>
</table>
</body>
</html>