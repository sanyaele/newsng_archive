<?php
/////////////////////////////////////
require_once 'includes/db.php';    //
require_once 'includes/common.php';//
/////////////////////////////////////
//Remove mail address from newsletter
function remove_email ($link, $email){
	$email = addslash($email);
	$sql = "DELETE FROM `mailing_list` WHERE `email` = '$email' LIMIT 1";
	if (@mysqli_query($link, $sql)):
		return "You have successfully deleted one email address";
	else:
		return "There was a problem deleting specified email";
	endif;
}

if (!empty($_REQUEST['email'])):
	$mess = remove_email ($link, $_REQUEST['email']);
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
.notes {
	font-family: Tahoma, Geneva, sans-serif;
	font-weight: bold;
	color: #F00;
}
</style>
</head>

<body>
<span class="notes">
<?php
if (!empty($mess)):
	echo $mess;
endif;
?>
</span><br />
<form id="form1" name="form1" method="post" action="">
  <label for="email"></label>
  <input type="text" name="email" id="email" />
  <input type="submit" name="sendbut" id="sendbut" value="X Remove" />
</form>
</body>
</html>