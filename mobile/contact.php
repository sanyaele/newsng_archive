<?php

////////////////////////
$site_type = "mini";
require_once '../includes/redirect.php';
///////////////////////////////////
require_once '../includes/db.php';

require_once '../includes/common.php';
///////////////////////////////////
######################################
if (isset($_POST['sendcontact'])):
	// Make sure no field is empty
	if ($_POST['name'] == '' || $_POST['email'] == '' || $_POST['what'] == '' || $_POST['details'] == ''):
		error ('One or more fields are empty');
		exit();
	else:
		// Validate and clean code
		$name = addslash ($_POST['name']);
		$what = addslash ($_POST['what']);
		$details = addslash ($_POST['details']);
		
		if (!$email = validate_email ($_POST['email'])):
			error ('Please fill a valid email address');
			exit();
		endif;
		
		// Send contribution to admin's email
		$emailmessage = "A user has sent in a contribution, below are the details submitted: <br />
		<br />
		<strong>Name:</strong> $name <br />
		
		<strong>Email:</strong> $email <br />
		
		<strong>Purpose:</strong> $what <br />
		
		<strong>Details:</strong> <br />
		$details <br />
		
		";
		
		if (!mail("contact@newsng.com", $what, $emailmessage, "From: $email")):
			error ('Could not send email, make sure email address is correct.'.
			'If problem persist, contact the administrator');
		else:
			$mess = "Your message has been successfully delivered to us, please we shall contact you soon. Thank you.";
		endif;
	endif;
endif; // if (!empty($_POST['sendcontact'])):


/////// Google Analytics ////////////
/////////////////////////////////////
// Copyright 2010 Google Inc. All Rights Reserved.

$GA_ACCOUNT = "MO-7718160-3";
$GA_PIXEL = "/ga.php";

function googleAnalyticsGetImageUrl() {
global $GA_ACCOUNT, $GA_PIXEL;
$url = "";
$url .= $GA_PIXEL . "?";
$url .= "utmac=" . $GA_ACCOUNT;
$url .= "&utmn=" . rand(0, 0x7fffffff);
$referer = $_SERVER["HTTP_REFERER"];
$query = $_SERVER["QUERY_STRING"];
$path = $_SERVER["REQUEST_URI"];
if (empty($referer)) {
  $referer = "-";
}
$url .= "&utmr=" . urlencode($referer);
if (!empty($path)) {
  $url .= "&utmp=" . urlencode($path);
}
$url .= "&guid=ON";
return str_replace("&", "&amp;", $url);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subscribe to our daily newsletter</title>
<link rel="alternate" type="application/rss+xml" href="feed.php?cat=Politics" title="Today's Hottest Nigerian News" />
<link href="assets/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: 12px;
}
.style5 {
	color: #0066FF;
	line-height: 20px;
}
.style8 {color: #006699; font-weight: bold; }
.style9 {
	color: #FF0000;
	font-weight: bold;
}
.style12 {font-size: 10px}
.style15 {	color: #FFFFFF;
	font-weight: bold;
}
.style10 {color: #FF0000}
.style28 {color: #009900}
.style30 {	color: #FF0000;
	font-size: 10px;
}
.style34 {color: #009900; font-weight: bold; }
.style38 {	font-family: Tahoma, Verdana;
	font-weight: bold;
}
.style39 {font-size: 14px}
.style31 {color: #FFFFFF}
.style33 {font-size: 10px; font-weight: bold; color: #FFFF00; }
.style35 {font-size: 9px}
-->
</style>
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
//-->
</script>
</head>

<body>
<table width="240" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="left"><img src="assets/logo.gif" alt="Nigerian News" width="236" height="35" /></td>
  </tr>
  <tr>
    <td align="center"><h1>Today's Hottest Nigerian News</h1></td>
  </tr>
  
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><a href="index.php">Home</a></td>
        <td align="right"><form action="http://www.google.com.ng" id="cse-search-box" target="_blank">
		  <div>
			<input type="hidden" name="cx" value="partner-pub-2732469417891860:6010882360" />
			<input type="hidden" name="ie" value="UTF-8" />
			<input type="text" name="q" size="10" />
			<input type="submit" name="sa" value="Search" />
		  </div>
		</form>
		
		<script type="text/javascript" src="http://www.google.com.ng/coop/cse/brand?form=cse-search-box&amp;lang=en"></script></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><hr />
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="133" align="right" valign="middle" class="style34"><span class="style38"> Address: </span></td>
        <td width="268" align="left"><span class="style39">3 Thorborn Avenue, Sabo, Yaba</span></td>
      </tr>
      <tr>
        <td align="right" valign="middle" class="style34"><span class="style38">Telephones: </span></td>
        <td align="left"><span class="style39">08033954301</span></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><hr />
          <?php echo $mess;?></td>
      </tr>
      <tr>
        <td colspan="2" align="center" bordercolor="#009900"><form action="contact.php" method="post" name="contact" id="contact" onsubmit="MM_validateForm('name','','R','email','','RisEmail');return document.MM_returnValue">
            <table width="100%" cellpadding="5" cellspacing="0">
              <tr>
                <td width="48" height="29" align="right" valign="top" class="style38"><span class="style34">Name</span></td>
                <td width="156" align="left" valign="top"><input name="name" type="text" class="formbox" id="name" /></td>
              </tr>
              <tr>
                <td height="27" align="right" valign="top" class="style38"><span class="style34">Email </span></td>
                <td align="left" valign="top"><input name="email2" type="text" class="formbox" id="email2" /></td>
              </tr>
              <tr>
                <td align="right" valign="top" class="style38"><span class="style28"></span></td>
                <td align="left" valign="top"><select name="what" class="style12" id="what">
                    <option value="">How Can We Help?</option>
                    <option value="ask_question">Ask A Question</option>
                    <option value="suggest_improvements">Suggest Improvements</option>
                    <option value="report_problem">Report A Problem</option>
                  </select>                </td>
              </tr>
              <tr>
                <td height="86" align="right" valign="top" class="style38"><span class="style34">Details</span></td>
                <td align="left" valign="top"><textarea name="details" cols="20" rows="5" class="style12" id="details"></textarea>                </td>
              </tr>
              <tr align="right">
                <td colspan="2" align="center"><span class="style30">
                  <input name="sendcontact" type="hidden" id="sendcontact" value="1" />
                  Please note, all fields are required </span></td>
                </tr>
              <tr align="right">
                <td>&nbsp;</td>
                <td align="left"><input name="Submit" type="submit" class="formbutton" value="Contact Us" /></td>
              </tr>
            </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#006600"><span class="style33">Send feedback to <a href="mailto:contact@newsng.com" class="style31">contact@newsng.com</a></span></td>
  </tr>
  <tr>
    <td align="center"><span class="style35">&copy;Copyright2009-2011 <a href="http://www.goldensteps.com.ng">GoldenSteps Enterprises</a>.All Rights Reserved</span></td>
  </tr>
</table>
<?php 
//////////////////////////////
/// google analytics /////////
//////////////////////////////
//////////////////////////////
/// google analytics /////////
//////////////////////////////
$googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
echo '<img src="' . $googleAnalyticsImageUrl . '" />';
?>
</body>
</html>
