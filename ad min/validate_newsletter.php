<?php
require_once '../includes/admin_sess.php';
require_once '../includes/smail/class.phpmailer.php';
//////////////////////////////////////////
class sendnews {
	private $dblink;
	public $errors="";
	private $percycle = '10';
	
	
	function __construct (){
		
		//////////////////////////////////////////////////
		global $link;
		$this->dblink = $link;
		
		if (empty($_SESSION['tot_list'])):
			$this->totals('sub',$this->dblink);
		endif;
		
		if (empty($_SESSION['rem'])):
			$_SESSION['rem'] = $_SESSION['tot_list'];
		endif;
		
		///////////////////////
		if (empty($_SESSION['ini_nl'])):
			$this->reset_list ($this->dblink); // indicates in the database that this particular email has not been sent before
		endif;
		
		////////////////////////
		// Retrieve records
		$result = $this->get_list ($this->dblink);
		while ($rows=mysqli_fetch_assoc($result)){
			//replace firstname and lastname
			$mail = new PHPMailer();
			$mail->IsMail();
			$mail->IsHTML(false);
			$mail->From = 'admin@newsng.com';
			$mail->FromName = "Nigerian News";
			$mail->AddAddress("$rows[email]");
			$mail->Subject = 'Verify your subscription on www.NewsNG.com';
$mail->Body  =  "
Hello $rows[firstname],

Thank you for signing up for our weekly news letter on www.NewsNG.com

To verify that you are the owner of this email address, kindly reply this mail.

The details you submitted are: 
Name: $rows[firstname] $rows[lastname]
Email: $rows[email]

You do not need to write any additional message in the reply, just hit the Reply button and send us back this message.

Note: For those who have already verified their account, please ignore this message.

Thank you.

The Administrator,
www.NewsNG.com
";
	
			if ($mail->Send()):
				$success = 1;
			else:
				$this->errors .= "<span style=\"color:#FF0000\">This email was not successfully sent: <strong>$rows[email]</strong></span><br />
				Mail Error: $mail->ErrorInfo";
				$success = 0;
			endif;
		}
		
		if (!empty($success)):
			$_SESSION['rem'] = $_SESSION['rem'] - $this->percycle;
			$this->update_list ($this->dblink); // mark as sent
			$this->errors .= "<span style=\"color:#00FF00; font-size: 14px;\"><strong>This email has been successfully sent to $this->percycle more subscribers, remaining <span style=\"color:#FFFFFF\">".$_SESSION['rem']."</span></strong></span>";
		endif;
	}
	
	function totals ($type,$link){
		if ($type == 'sub'):
			$sql = "SELECT COUNT(email) AS num FROM mailing_list WHERE subscription='1'";
		elseif ($type == 'unsub'):
			$sql = "SELECT COUNT(email) AS num FROM mailing_list WHERE subscription='0'";
		endif;
		$result = mysqli_query ($link, $sql);
		$row = @mysqli_fetch_assoc ($result);
		$_SESSION['tot_list'] = $row['num'];
	}
	
	function reset_list ($link){
		$sql = "UPDATE mailing_list 
		SET sent = '0'";
		if (@mysqli_query($link, $sql)):
			$_SESSION['ini_nl'] = '1'; //makes sure it only resets after session has ended
			return TRUE;
		else:
			return FALSE;
		endif;
	}
	
	function update_list ($link){
		$sql = "UPDATE mailing_list 
		SET sent='1' 
		WHERE sent='0' 
		ORDER BY id ASC
		LIMIT $this->percycle";
		if (@mysqli_query($link, $sql)):
			return TRUE;
		else:
			return FALSE;
		endif;
	}
	
	function get_list ($link){
		$sql = "SELECT id, firstname, lastname, email 
		FROM mailing_list
		WHERE subscription = '1'
		AND sent = '0'
		ORDER BY id ASC
		LIMIT $this->percycle";
		$result = @mysqli_query($link, $sql);
		return $result;
	}
} //end class
//////////////////////////////////////////
if (!empty($_GET['send_letter'])):
	$newsletter = new sendnews;
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if ($_SESSION['rem'] > 0):
?>
<meta http-equiv="refresh" content="60" />
<?php
endif;
?>
<title>Send Newsletter</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style16 {	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
		if (empty($_SESSION['ini_nl'])):
		?>
<table width="300" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center"><form id="newsletter" name="newsletter" method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <label>
        <input name="send_letter" type="hidden" id="send_letter" value="1" />
        <input name="send" type="submit" class="style16" id="send" value="Send Today's Newsletter" />
        </label>
    </form></td>
  </tr>
</table>
<?php
		else:
		?>
<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><span class="style1"><?php echo $newsletter->errors; ?></span></td>
  </tr>
</table>
<?php
		endif;
		?>

</body>
</html>
