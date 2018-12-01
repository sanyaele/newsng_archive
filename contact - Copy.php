<?php

////////////////////////
$site_type = "html";
require_once 'includes/redirect.php';
///////////////////////////////////
require_once 'includes/db.php';

require_once 'includes/common.php';
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



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contact Us at Nigerian News</title>
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
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCC33" class="allborder">
  <tr>
    <td bgcolor="#FFFFFF">
    <?php
	include_once 'header.html';
	?>
    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="5">
        <tr>
          <td align="left" valign="top"><h1>Contact Us</h1></td>
          <td align="left" valign="top" bordercolor="#66FF02" class="style1">&nbsp;</td>
        </tr>
        <tr>
          <td width="75%" align="left" valign="top" bordercolor="#00FF00"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><script type="text/javascript"><!--
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
            </table>
              <table width="400" border="0" align="center" cellpadding="5" cellspacing="0">
                <tr>
                  <td width="133" align="right" valign="middle" class="style34"><span class="style38">Office Address: </span></td>
                  <td width="268" align="left"><span class="style39">3 Thorborn Avenue, Sabo, Yaba</span></td>
                </tr>
                <tr>
                  <td align="right" valign="middle" class="style34"><span class="style38">Telephones: </span></td>
                  <td align="left"><span class="style39">018129187, 08033954301</span></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><?php if (!empty($mess)) {echo $mess;}?></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" bordercolor="#009900"><form action="contact.php" method="post" name="contact" id="contact" onsubmit="MM_validateForm('name','','R','email','','RisEmail');return document.MM_returnValue">
                      <table width="409" cellpadding="5" cellspacing="0">
                        <tr>
                          <td width="124" height="29" align="right" valign="top" class="style38"><span class="style34">Name</span></td>
                          <td width="263" align="left" valign="top"><input name="name" type="text" class="formbox" id="name" /></td>
                        </tr>
                        <tr>
                          <td height="27" align="right" valign="top" class="style38"><span class="style34">Email Address</span></td>
                          <td align="left" valign="top"><input name="email2" type="text" class="formbox" id="email2" /></td>
                        </tr>
                        <tr>
                          <td align="right" valign="top" class="style38"><span class="style28"></span></td>
                          <td align="left" valign="top"><select name="what" class="formbox" id="what">
                              <option value="">How Can We Help?</option>
                              <option value="ask_question">Ask A Question</option>
                              <option value="suggest_improvements">Suggest Improvements</option>
                              <option value="report_problem">Report A Problem</option>
                              <option value="request_advert" selected="selected">Request Advert Info</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td height="86" align="right" valign="top" class="style38"><span class="style34">Details</span></td>
                          <td align="left" valign="top"><textarea name="details" cols="20" rows="5" class="formbox" id="details"></textarea>
                          </td>
                        </tr>
                        <tr align="right">
                          <td align="center">&nbsp;</td>
                          <td align="left"><span class="style30">
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
          <td width="25%" align="left" valign="top" bordercolor="#006600"><table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td bgcolor="#FF0000"><span class="style12 style15">Send me Nigerian news daily</span></td>
              </tr>
              <tr>
                <td height="100" align="left" valign="top" bordercolor="#FF0000" class="allborder"><form id="newsletter" name="newsletter" method="post" action="newsletter.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="36%" align="right"><span class="archive">Firstname</span></td>
                        <td width="64%"><label>
                          <input name="firstname" type="text" class="archive" id="firstname" size="20" maxlength="30" />
                        </label></td>
                      </tr>
                      <tr>
                        <td align="right"><span class="archive">Lastname</span></td>
                        <td><label>
                          <input name="lastname" type="text" class="archive" id="lastname" size="20" maxlength="30" />
                        </label></td>
                      </tr>
                      <tr>
                        <td align="right"><span class="archive">Email</span></td>
                        <td><label>
                          <input name="email" type="text" class="archive" id="email" size="20" maxlength="50" />
                        </label></td>
                      </tr>
                      <tr>
                        <td colspan="2"><?php
						  require_once('includes/recaptchalib.php');
						  $publickey = "6LfTFPcSAAAAAFBIf7HqNkfYk9FjPMdCRDhdP9JG"; // you got this from the signup page
						  echo recaptcha_get_html($publickey);
						?></td>
                      </tr>
                      <tr>
                        <td><input name="sub" type="hidden" id="sub" value="1" /></td>
                        <td><label>
                          <input name="subscribe" type="submit" class="style9" id="subscribe" value="Subscribe" />
                        </label></td>
                      </tr>
                    </table>
                </form></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <?php
	include_once 'footer.html';
	?>
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
</body>
</html>
