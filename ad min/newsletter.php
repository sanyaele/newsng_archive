<?php
require_once '../includes/admin_sess.php';
//////////////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Console</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style16 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="../assets/new_logo2_back.gif"><img src="../assets/new_logo2.gif" alt="News In Nigeria" width="158" height="73" /></td>
  </tr>
  <tr>
    <td align="right" valign="top" bgcolor="#FFFFFF"><a href="home.php">News Dashboard</a> | <a href="?logoff=1">Sign-out</a></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="5" cellspacing="0">
      
      <tr>
        <td width="613" align="left" valign="top"><iframe frameborder="0" width="100%" height="250" src="send_newsletter.php"></iframe></td>
        <td width="345" align="left" valign="top"><iframe name="list" id="list" width="100%" height="500" frameborder="0" src="mailing_list.php"></iframe></td>
        </tr>
      <tr>
        <td align="left" valign="top"><span class="style1">&copy;Copyright 2009 - 2012 <a href="http://www.goldensteps.com.ng">GoldenSteps Enterprises</a>. All Rights Reserved.</span></td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
