<?php // common.inc 
require_once 'adverts.php';
///////////////////////////
session_start();
/////////////////
function error($msg) { 
   echo "
   <html> 
   <head> 
   
   <script language=\"JavaScript\"> 
   <!-- 
       alert(\"$msg\"); 
       history.back(); 
   //--> 
   </script> 
   </head> 
   <body> 
   </body> 
   </html> 
   ";
   exit(); 
} // End of error
#############################################################################
function addslash ($value,$allowed_tags="") { // Add slashes if magic_quotes_gpc is off (i.e. 0)
	/*
	if (!get_magic_quotes_gpc()):
	   return addslashes(htmlspecialchars ($str));
	else:
		if(strpos(str_replace("\'",""," $str"),"'")!=false):
			return addslashes(htmlspecialchars ($str));
		else:
			return $str;
		endif;
	endif;
	*/
	
	
	if(get_magic_quotes_gpc() || strpos(str_replace("\'",""," $value"),"'")==false)
	{
	$value=stripslashes($value);
	}
	$value=strip_tags($value,$allowed_tags);
	//$value=htmlspecialchars($value);
	$value=addslashes($value);
	return $value;
}
// A function that checks to see if
// an email is valid
function validEmail($email)
{
   // Debug: For offline testing purposes
   return true;
   //////////////////////////////////////
   
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}
#############################################################################
function random_str($numchar) {
   $str = bin2hex( md5( time(), TRUE ) );
   $start = mt_rand(1, (strlen($str)-$numchar));
   $suff_str = str_shuffle($str);
   $encr_str = substr($suff_str,$start,$numchar);
   return($encr_str);
}

function ci_rand ($numchar,$repeat=false) {
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$rand_string = "";
	for ($i = 0; ($i < $numchar); $i++){
		$char = substr($chars,mt_rand(0, strlen($chars) - 1), 1);
		$rand_string .= $char;
		if(!$repeat)$chars=str_ireplace($char,'',$chars);
	}
	return $rand_string;
}
#############################################################################
function session_page ($error_mess) {
	if (isset ($_COOKIE['username'])):
		$username = $_COOKIE['username'];
		$password = $_COOKIE['password'];
	elseif (isset ($_POST['username'])):
		$username = $_POST['username'];
		$password = $_POST['password'];
	else:
		$username = '';
		$password = '';
	endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login</title>
<style type="text/css">
<!--
.style1 {
	color: #FFFF00;
	font-weight: bold;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: small;
}
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: small;
}
h1 {
	font-size: large;
}
.style3 {
	color: #009900;
	font-weight: bold;
}
	-->
	</style>
	</head>
	
	<body>
	<h1 align="center">&nbsp;<?php echo $error_mess; ?>	</h1>
	<p align="center"><span class="top_bar"><a href="index.php">Home</a></span></p>
	<table width="300" border="0" align="center" cellpadding="4" cellspacing="0" class="style2">
	  <tr>
		<td align="left" valign="top" bgcolor="#006600"><span class="style1">Login </span></td>
	  </tr>
	  <tr>
		<td align="left" valign="top" bgcolor="#99FF66"><form id="hosts" name="hosts" method="post" action="<?php if (!empty ($_REQUEST['logoff'])){ echo "home.php"; } ?>">
		    
		  <p>
		    Username
			<input name="username" type="text" id="username" value="<?php echo $username; ?>" size="25" />
		  </p>
	  <p>Password
		  <input name="password" type="password" id="password" value="<?php echo $password; ?>" size="25" />
		  </p>
		  <p>
			<input type="submit" name="Submit" value="Submit" />
		  </p>
		  </form></td>
	  </tr>
	</table>
</body>
	</html>
	<?php
	exit ();
}

function admin_session_page ($error_mess) {
	if (isset ($_COOKIE['username'])):
		$username = $_COOKIE['username'];
		$password = $_COOKIE['password'];
	elseif (isset ($_POST['username'])):
		$username = $_POST['username'];
		$password = $_POST['password'];
	else:
		$username = '';
		$password = '';
	endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to the best highway traffic analyzer</title>
<style type="text/css">
<!--
.style1 {
	color: #FFFF00;
	font-weight: bold;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: small;
}
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: small;
}
-->
</style>
</head>

<body>
<h1 align="center">&nbsp;<?php echo $error_mess; ?>	</h1>
<p align="center"><span class="top_bar"><a href="index.php">Home</a></span></p>
<table width="300" border="0" align="center" cellpadding="4" cellspacing="0" class="style2">
  <tr>
	<td align="left" valign="top" bgcolor="#006600"><span class="style1">Login </span></td>
  </tr>
  <tr>
	<td align="left" valign="top" bgcolor="#99FF66"><form id="hosts" name="hosts" method="post" action="<?php if (!empty ($_REQUEST['logoff'])){ echo "home.php"; } ?>">
	  <p>
        Username
        <input name="username" type="text" id="username" value="<?php echo $username; ?>" size="25" />
      </p>
	  <p>Password
		  <input name="password" type="password" id="password" value="<?php echo $password; ?>" size="25" />
		  </p>
	  <p>
		<input type="submit" name="Submit" value="Submit" />
	  </p>
	  </form></td>
  </tr>
</table>
</body>
</html>
<?php
exit ();
}
?>