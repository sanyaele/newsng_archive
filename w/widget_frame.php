<?php
//If the widget adjustment form was not submitted
if (empty($_POST['cat'])):
	exit();
endif;

// Set Frame Width
if (!empty($_POST['width'])):
	$framewidth = $_POST['width'];
else:
	$framewidth = 300;
endif;

// Set Frame Height
if (!empty($_POST['height'])):
	$frameheight = $_POST['height'];
else:
	$frameheight = 300;
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Widget</title>
<link href="widget.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.codebox {
	font-family: Tahoma, Verdana;
	font-size: 12px;
	height: 40px;
	width: 100%;
	padding: 5px;
	background-color: #E8EEF9;
}
.style1 {
	font-size: 11px;
	font-weight: bold;
	color: #FFFFFF;
}
.style2 {
	color: #FF0000;
	font-weight: bold;
}
body {
	background-image: url(../assets/preview.gif);
	margin: 0px;
}
.style3 {color: #FFFFFF}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td align="center"><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="250" height="25" align="center" bgcolor="#000000"><span class="style1">Copy the code Below into your website</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><textarea name="iframecode" cols="45" rows="3" class="codebox" id="iframecode"><iframe src="http://newsng.com/w/i.php?bc=<?php if (isset($_POST['border_color'])){echo $_POST['border_color'];}?>&amp;hc=<?php if (isset($_POST['header_color'])){echo $_POST['header_color'];}?>&amp;f=<?php if (isset($_POST['font'])){echo $_POST['font'];}?>&amp;n=<?php if (isset($_POST['number'])){echo $_POST['number'];}?>&amp;m=<?php if (isset($_POST['show_head'])){echo $_POST['show_head'];}?>&amp;c=<?php if (isset($_POST['cat'])){echo $_POST['cat'];}?>&amp;h=<?php echo $frameheight;?>&amp;w=<?php echo $framewidth;?>" frameborder="0" height="<?php echo $frameheight;?>" width="<?php echo $framewidth;?>" scrolling="no"></iframe></textarea></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="580" border="0" align="center" cellpadding="5" cellspacing="0">
  
  
  
  <tr>
    <td height="40" align="center" bordercolor="#FF0000">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bordercolor="#FF0000"><iframe src="i.php?bc=<?php if (isset($_POST['border_color'])){echo $_POST['border_color'];}?>&amp;hc=<?php if (isset($_POST['header_color'])){echo $_POST['header_color'];}?>&amp;f=<?php if (isset($_POST['font'])){echo $_POST['font'];}?>&amp;n=<?php if (isset($_POST['number'])){echo $_POST['number'];}?>&amp;m=<?php if (isset($_POST['show_head'])){echo $_POST['show_head'];}?>&amp;c=<?php if (isset($_POST['cat'])){echo $_POST['cat'];}?>&amp;h=<?php echo $frameheight;?>&amp;w=<?php echo $framewidth;?>" frameborder="0" height="<?php echo $frameheight;?>" width="<?php echo $framewidth;?>" scrolling="no"></iframe>      </td>
  </tr>
</table>
</body>
</html>
