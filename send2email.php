<?php

////////////////////////
$site_type = "html";
require_once 'includes/redirect.php';
///////////////////////////////////
require_once 'includes/db.php';

require_once 'includes/common.php';
require_once 'includes/smail/class.phpmailer.php';
///////////////////////////////////
class sendstory {
	private $dblink;
	private $friend;
	public $errors;
	private $bcc;
	private $sendername;
	private $mailbody;
	private $id;
	
	function __construct ($newsid){
		global $link;
		$this->dblink = $link;
		$this->id = addslash ($newsid);
		$this->sendername = htmlspecialchars(strip_tags($_POST['myname']));
		$this->mailbody = file_get_contents("includes/mailhtml.html");
		$this->prep_body($this->dblink);
		///////////////////////
		$i=1;
		while ($i <= 5 && !empty($_POST["friend".$i])){
			$this->friend = addslash ($_POST["friend".$i]);
			if ($this->is_email($this->friend)):
				// Send mail
				$mail = new PHPMailer();
				$mail->IsMail();
				$mail->IsHTML(true);
				$mail->From = 'admin@newsng.com';
				$mail->FromName = $this->sendername;
				$mail->AddAddress("$this->friend");
				$mail->Subject = $this->sendername.' sent you a NewsNG.com article';
				$mail->Body  = $this->mailbody;
		
				if ($mail->Send()){ 
					$this->errors .= "This news article has been successfully sent to <strong>$this->friend</strong><br />";
				}else{
					$this->errors .= "<span style=\"color:#FF0000\">This email was not successfully sent: <strong>$this->friend</strong></span><br />
				Mail Error: $mail->ErrorInfo";
				}
			else:
				$this->errors .= "<span style=\"color:#660000\">This email is not correct: <strong>$this->friend</strong></span><br />";
			endif;
			
			$i++;
		}
		
	}
	
	function is_email($param){
		if (preg_match("/^([a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9]{2,3}\.*[a-zA-Z0-9]*)$/", $param)):
			return true;
		else:
			return false;
		endif;
	}
	
	function prep_body ($link){
		$sql = "SELECT title, description FROM articles WHERE id = '$this->id' LIMIT 1";
		$result = @mysqli_query ($link, $sql);
		$row = @mysqli_fetch_assoc($result);
		$row['title'] = stripslashes (htmlspecialchars(str_replace (" ", "-", $row['title'])));
		
		//replace title, description, and link
		$storylink = "http://www.newsng.com/story-detail.php?title=$row[title]&story=$this->id";
		
		$this_story_title = str_replace (" ", "-", $rows['title']);
		
		$this->mailbody = str_replace ("{title}", $this_story_title, $this->mailbody);
		$this->mailbody = str_replace ("{description}", $row['description'], $this->mailbody);
		$this->mailbody = str_replace ("{link}", $storylink, $this->mailbody);
	}
}
// get story to send
if (!empty($_POST['newsid'])):
	$sendnew = new sendstory($_POST['newsid']);
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Send to emails</title>

<style type="text/css">
<!--
.style2 {color: #FF0000}
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
<script type="text/javascript">
function removechars ($box){
		var txtbox = document.getElementById($box).value;
		txtbox = txtbox.replace(" ", "");
		txtbox = txtbox.replace(",", "");
		txtbox = txtbox.replace(";", "");
		document.getElementById($box).value = txtbox;
	}
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
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCC33" class="allborder">
  <tr>
    <td bgcolor="#FFFFFF"><?php
if (!empty($_POST['newsid'])):
?>
      <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" bgcolor="#FFFF99"><span class="style2"><?php echo $sendnew->errors; ?>&nbsp;</span></td>
        </tr>
        <tr>
          <td height="50" align="center"><a href="send2email.php?story=<?php echo $_POST['newsid']; ?>&amp;name=<?php echo $_POST['myname']; ?>">Send to more friends</a></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
      </table>
      <?php
else:
?>
      <form id="sendemail" name="sendemail" method="post" action="send2email.php">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td bgcolor="#FFFF99">What is your name?
              <input name="myname" type="text" id="myname" value="<?php if (!empty($_GET['name'])){echo $_GET['name'];}?>" size="30" maxlength="50" /></td>
          </tr>
          <tr>
            <td>Send this link to the following emails:</td>
          </tr>
          <tr>
            <td><table width="300" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td width="70">Friend 1</td>
                  <td width="210"><label>
                    <input name="friend1" type="text" id="friend1" size="25" onkeyup="removechars('friend1')" />
                  </label></td>
                </tr>
                <tr>
                  <td>Friend 2</td>
                  <td><input name="friend2" type="text" id="friend2" size="25" onkeyup="removechars('friend2')" /></td>
                </tr>
                <tr>
                  <td>Friend 3</td>
                  <td><input name="friend3" type="text" id="friend3" size="25" onkeyup="removechars('friend3')" /></td>
                </tr>
                <tr>
                  <td>Friend 4</td>
                  <td><input name="friend4" type="text" id="friend4" size="25" onkeyup="removechars('friend4')" /></td>
                </tr>
                <tr>
                  <td><span>Friend 5</span></td>
                  <td><input name="friend5" type="text" id="friend5" size="25" onkeyup="removechars('friend5')" /></td>
                </tr>
                <tr>
                  <td><input name="newsid" type="hidden" id="newsid" value="<?php echo $_GET['story'];?>" /></td>
                  <td><label>
                    <input name="send" type="submit" id="send" onclick="MM_validateForm('friend1','','RisEmail','friend2','','NisEmail','friend3','','NisEmail','friend4','','NisEmail','friend5','','NisEmail');return document.MM_returnValue" value="Send To Emails" />
                  </label></td>
                </tr>
            </table></td>
          </tr>
        </table>
      </form>
      <?php
endif;
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
