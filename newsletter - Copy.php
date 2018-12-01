<?php

////////////////////////
$site_type = "html";
require_once 'includes/redirect.php';
///////////////////////////////////
require_once 'includes/db.php';

require_once 'includes/common.php';
require_once 'includes/smail/class.phpmailer.php';
///////////////////////////////////
class subscr {
	private $firstname;
	private $lastname;
	private $email;
	private $subid;
	private $reason;
	
	private $dblink;
	
	public $mess;
	
	function __construct ($type){
		global $link;
		$this->dblink = $link;
		
		if ($type == 'sub'):
			if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email'])):
				//cleans code
				$this->firstname = substr (addslash($_POST['firstname']),0,30);
				$this->lastname = substr (addslash($_POST['lastname']),0,30);
				$this->email = substr (addslash($_POST['email']),0,50);
				
				if ($this->subscribe ($this->dblink)):
					$this->sendfirstmail();
				endif;
			else:
				$this->mess = "Please fill all required fields, and try again.<br />
				You can use the form to the right of this page, <br />
				or navigate to the previous page to resubmit the subscription form.";
			endif;
		elseif($type == 'unsub'):
			if (!empty($_POST['unsub']) && !empty($_POST['email']) && !empty($_POST['reason'])):
				//cleans code
				$this->subid = substr (addslash($_POST['unsub']),0,15);
				$this->email = substr (addslash($_POST['email']),0,50);
				$this->reason = substr (addslash($_POST['reason']),0,200);
				
				$this->unsubscribe ($this->dblink);
			else:
				$this->mess = "Sorry, could not unsubscribe you from our mailing list,<br />
				Please use the unsubscribe link provided at the end of every newsletter that is sent to you, and kindly fill out the reason for your unsubscription.";
			endif;
		else:
			$this->mess = "Invalid Action";
		endif;
	}
	
	function subscribe ($link){
		$sql = "INSERT INTO mailing_list SET
		firstname = '$this->firstname',
		lastname = '$this->lastname',
		email = '$this->email'
		ON DUPLICATE KEY UPDATE subscription='1'";
		
		if (@mysqli_query($link, $sql)):
			$this->subid = mysqli_insert_id($link);
			$this->mess = "<strong style=\"font-size: 14\">Thank you</strong>,<br />
			We have successfully added you to our mailing list. <br />
			The details you submitted are: <br />
			Name: <strong>$this->firstname $this->lastname</strong><br />
			Email: <strong>$this->email</strong><br /><br />
			You will be sent your first issue soon.";
			return TRUE;
		else:
			$this->mess = "Sorry, there was a problem adding you to our mailing list, please try again.";
			return FALSE;
		endif;
	}
	
	function sendfirstmail (){
		// Send mail
		$mail = new PHPMailer();
		$mail->IsMail();
		$mail->IsHTML(false);
		$mail->From = 'admin@newsng.com';
		$mail->FromName = 'The Administrator';
		$mail->AddAddress("$this->email");
		$mail->Subject = 'Verify your subscription on www.NewsNG.com';
$mail->Body  = "
Hello $this->firstname,

Thank you for signing up for our weekly news letter on www.NewsNG.com

To verify that you are the owner of this email address, click the link below:
http://newsng.com/newsletter.php?email=".$this->email."&verify=".$this->subid."

Thank you.

The Administrator,
www.NewsNG.com
";
		
		if ($mail->Send()):
			$this->mess = "<strong style=\"font-size: 14\">Thank you</strong>,<br />
			We have successfully added you to our mailing list. <br />
			The details you submitted are: <br />
			Name: <strong>$this->firstname $this->lastname</strong><br />
			Email: <strong>$this->email</strong><br /><br />
			An email has been sent to you, kindly reply the email to verify your subscription.";
		else:
			$this->mess .= "<br /><span style=\"color:#FF0000\">There was a problem sending your verification email. To verify your subscription, send a blank mail to admin@newsng.com, with subject 'Verification of newsletter subscription'. Thank you. </span>";
		endif;
	}
	
	function unsubscribe ($link){
		$sql = "UPDATE mailing_list SET 
		subscription='0',
		unsub_reason='$this->reason' 
		WHERE id='$this->subid' 
		AND email='$this->email'
		LIMIT 1";
		
		if (@mysqli_query($link, $sql)):
			$this->mess = "<strong style=\"font-size: 14\">We regret to inform you that...</strong>,<br />
			You have successfully unsubscribed from our mailing list, we wish you the very best and hope you will consider re-subscribing in the near future.";
		else:
			$this->mess = "Sorry, could not unsubscribe you from our mailing list,<br />
				Please use the unsubscribe link provided at the end of every newsletter that is sent to you.";
		endif;
	}
} //end class subscr

function verify ($link, $em, $i){
	$em = addslash($em);
	$i = addslash($i);
	
	$sql = "UPDATE `mailing_list` SET 
	`subscription` = '1',
	`active` = '1'
	WHERE `email` = '$em'
	AND `id` = '$i'
	LIMIT 1";
	
	if (@mysqli_query($link, $sql)):
		return TRUE;
	else:
		return FALSE;
	endif;
}

///////////////////////////////////
// if new subscription is received / there is an unsubscription request
if (!empty($_POST['sub'])):
	require_once('includes/recaptchalib.php');
	$privatekey = "6LfTFPcSAAAAALB3sY65IjT890jO_HHr6Ny9dJCU";
	$resp = recaptcha_check_answer ($privatekey,
								$_SERVER["REMOTE_ADDR"],
								$_POST["recaptcha_challenge_field"],
								$_POST["recaptcha_response_field"]);
	
	if (!$resp->is_valid) {
	// What happens when the CAPTCHA was entered incorrectly
	$mess = "The reCAPTCHA wasn't entered correctly. Please try it again.";
	/*
	die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
		 "(reCAPTCHA said: " . $resp->error . ")");
	*/
	} else {
		$subscription = new subscr("sub");
	}
	
elseif (!empty($_POST['unsub'])):
	$subscription = new subscr("unsub");
endif;

// if user verifies subscription
if (!empty($_GET['verify']) && !empty($_GET['email'])):
	if (verify($link, $_GET['email'], $_GET['verify'])):
		$mess = "You have successfully Verified your Newsletter subscription. Thank you.";
	else:
		$mess = "There was a problem Verifying your Newsletter subscription. Please reapply, thank you";
	endif;
endif;
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
-->
</style>
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCC33" class="allborder">
  <tr>
    <td bgcolor="#FFFFFF"><?php
	include_once 'header.html';
	?>
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="5">
        <tr>
          <td align="left" valign="top"><h1>Hottest Nigerian News</h1></td>
          <td align="left" valign="top" bordercolor="#66FF02" class="style1"></td>
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
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><span class="style10"><?php if (!empty($subscription->mess)){ echo $subscription->mess;} ?> <?php if (!empty($mess)){ echo $mess;} ?></span></td>
                </tr>
                <tr>
                  <td><?php
	  if (!empty($_GET['unsub']) && !empty($_GET['email'])):
	  ?>
                      <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><form id="unsubscribe" name="unsubscribe" method="post" action="newsletter.php">
                              <p class="style5">Hi <?php echo $_GET['name']; ?>,</p>
                            <p align="justify" class="style5">Since it is obvious that there is a part of our <strong>content</strong> or <strong>service</strong> that you do not like, kindly tell us what it is, so that we can enhance our services to benefit more people.</p>
                            <p align="center">
                                <label>
                                <textarea name="reason" id="reason" cols="45" rows="5"></textarea>
                                </label>
                            </p>
                            <p align="center" class="style12">Please do not exceed <strong>200</strong> characters</p>
                            <p align="center">
                                <input name="unsub" type="hidden" id="unsub" value="<?php echo $_GET['unsub']; ?>" />
                                <input name="email" type="hidden" id="email" value="<?php echo $_GET['email']; ?>" />
                                <input name="submit" type="submit" class="style8" id="submit" value="Unsubscribe" />
                            </p>
                          </form></td>
                        </tr>
                      </table>
                    <?php
	  endif;
	  ?></td>
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
        <tr>
          <td><?php
	include_once 'footer.html';
	?></td>
          <td>&nbsp;</td>
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
</body>
</html>
