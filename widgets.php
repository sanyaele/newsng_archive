<?php
////////////////////////
require_once 'includes/db.php';
require_once 'includes/common.php';
require_once 'includes/functions.php';
///////////////////////////////////
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Latest Curated Nigerian News Widget</title>
<link rel="alternate" type="application/rss+xml" href="feed.php" title="Nigerian road traffic information on PC and Mobile" />
<link href="assets/css.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style27 {
	color: #000000;
	font-size: 11px;
	font-family: Tahoma, Verdana;
	font-weight: bold;
}
.style39 {color: #990000; font-size: 11px; font-family: Tahoma, Verdana; font-weight: bold; }
.contri_formbox {
	font-family: Tahoma, Verdana;
	font-size: 16px;
	background-color: #EEEDE5;
	padding: 5px;
	height: 30px;
	width: 270px;
	font-weight: bold;
	color: #990000;
	border: 1px solid #CCCCCC;
}
.style40 {
	font-size: 14px;
	font-family: Tahoma, Verdana;
	font-weight: bold;
	color: #FFFFFF;
}
.textboxes {
	font-family: Tahoma, Verdana;
	font-size: 11px;
	color: #003300;
	padding: 1px;
	border: 1px solid #003300;
	background-color: #FFFFFF;
}
.style49 {
	font-size: 10px;
	font-family: Tahoma, Verdana;
	white-space: nowrap;
	font-weight: bold;
}
.style51 {font-size: 11px}
.style14 {font-size: 10px; font-weight: bold; }
-->
</style>
<!-- Place this tag in your head or just before your close body tag -->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
</head>
<body>
<script type="text/javascript" src="wz_tooltip.js"></script>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCC33" class="allborder">
  <tr>
    <td bgcolor="#FFFFFF"><?php
	include_once 'header.html';
	?>
<br />
<table width="700" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td height="25" align="left"><h1 style="color:#060;">&nbsp;Customize and add a News widget to your website</h1></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#EBFFDD" style="font-family: Tahoma, Geneva, sans-serif; font-size: 12px; padding: 10px;">Display the most socially active Nigerian News on your website today. Customize the widget below and copy and past the generated code to automatically start displaying Current Currated News on your website.</td>
  </tr>
  <tr>
    <td height="25" bgcolor="#EBFFDD"><form action="w/widget_frame.php" method="post" name="adjustwidget" target="widgetmain" id="adjustwidget">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td align="right"><span class="style49">Width:</span></td>
          <td align="left"><label>
            <select name="width" class="textboxes" id="width">
              <option value="200">200px</option>
              <option value="250" selected="selected">250px</option>
              <option value="300">300px</option>
              <option value="350">350px</option>
              <option value="400">400px</option>
              <option value="450">450px</option>
              <option value="500">500px</option>
            </select>
          </label></td>
          <td align="right" class="style49">Header Color:</td>
          <td align="left" class="style49"><select name="header_color" class="textboxes" id="header_color">
            <option value="" selected="selected">Default</option>
            <option value="Black" style="background-color:black;">Black</option>
            <option value="Red" style="background-color:red;">Red</option>
            <option value="Green" style="background-color:green;">Green</option>
            <option value="Blue" style="background-color:blue;">Blue</option>
            <option value="Yellow" style="background-color:yellow;">Yellow</option>
            <option value="White" style="background-color:white;">White</option>
          </select></td>
          <td align="right" class="style49">Font:</td>
          <td align="left" class="style49"><span class="style51">
            <label>
              <select name="font" class="textboxes" id="font">
                <option value="Arial">Arial</option>
                <option value="Tahoma" selected="selected">Tahoma</option>
                <option value="Verdana">Verdana</option>
              </select>
            </label>
          </span></td>
          <td align="left" class="style49">Category:</td>
          <td colspan="2" align="left" class="style49"><select name="cat" class="textboxes" id="cat">
            <option value="All">All</option>
			<?php get_cat($link); ?>
          </select></td>
          </tr>
        <tr>
          <td width="9%" align="right"><span class="style49">Height:</span></td>
          <td width="10%" align="left" class="style49"><select name="height" class="textboxes" id="height">
            <option value="200">200px</option>
              <option value="250" selected="selected">250px</option>
              <option value="300">300px</option>
              <option value="350">350px</option>
              <option value="400">400px</option>
              <option value="450">450px</option>
              <option value="500">500px</option>
          </select></td>
          <td width="11%" align="right" class="style49">Border Color:</td>
          <td width="11%" align="left" class="style49"><label>
            <select name="border_color" class="textboxes" id="border_color">
              <option value="" selected="selected">Default</option>
              <option value="Black" style="background-color:black;">Black</option>
              <option value="Red" style="background-color:red;">Red</option>
              <option value="Green" style="background-color:green;">Green</option>
              <option value="Blue" style="background-color:blue;">Blue</option>
              <option value="Yellow" style="background-color:yellow;">Yellow</option>
              <option value="White" style="background-color:white;">White</option>
            </select>
          </label></td>
          <td width="7%" align="right" class="style49">Number:</td>
          <td width="12%" align="left" class="style49"><label>
            <select name="number" class="textboxes" id="number">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10" selected="selected">10</option>
            </select>
          </label></td>
          <td width="10%" align="left" class="style49">Hide Header:</td>
          <td width="6%" align="left" class="style49"><input type="checkbox" name="show_head" id="show_head" /></td>
          <td width="24%" align="right" class="style49"><label>
            <input name="preview" type="submit" class="textboxes" id="preview" style="padding-left:10px; padding-right:10px;" value="Preview &amp; Generate Code" />
          </label></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td height="500" align="center" valign="top" bordercolor="#E1EDFF" bgcolor="#006600"><iframe src="w/widget_frame.php" frameborder="0" height="700" width="100%" id="widgetmain" name="widgetmain"></iframe></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="5" cellspacing="5" bgcolor="#FFFFFF">
        <tr>
          <td><?php
	include_once 'footer.html';
	?></td>
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