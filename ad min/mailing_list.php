<?php
require_once '../includes/admin_sess.php';
//////////////////////////////////////////
class import {
	private $host;
	private $h_user;
	private $h_pass;
	private $db_name;
	private $tblname;
	private $fn_field;
	private $ln_field;
	private $e_field;
	
	private $dblink;
	
	private $extlink;
	private $extdata;
	
	/////////////
	public $mess;
	
	function __construct(){
		global $link;
		$this->dblink = $link;
		
		if ($this->validate()):
			$this->extdbconx();
			if ($this->get_list()):
				$this->put_list($this->dblink);
			endif;
		endif;
	}
	
	function validate (){
		if (!empty($_POST['host']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['tblname']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['dbname'])):
			$this->host = addslash($_POST['host']);
			$this->h_user = addslash($_POST['username']);
			$this->h_pass = addslash($_POST['password']);
			$this->db_name = addslash($_POST['dbname']);
			$this->tblname = addslash($_POST['tblname']);
			$this->fn_field = addslash($_POST['firstname']);
			$this->ln_field = addslash($_POST['lastname']);
			$this->e_field = addslash($_POST['email']);
			
			return TRUE;
		else:
			$this->mess = "Please All Fields in form are required, complete the form and try again";
			return FALSE;
		endif;
	}
	
	function extdbconx (){
		$this->extlink = mysqli_connect ($this->host, $this->h_user, $this->h_pass, $this->db_name) or die ("Connection Error: " . mysqli_connect_error());
	}
	
	function get_list (){
		$sql = "SELECT $this->fn_field AS fn, $this->ln_field AS ln, $this->e_field AS e FROM $this->tblname";
		
		if (!$result = mysqli_query ($this->extlink, $sql)):
			$this->mess = "There was a problem retrieving data from $this->tblname. Error Message: ".mysqli_error($this->extlink);
			return FALSE;
		else:
			while ($rows=mysqli_fetch_assoc($result)){
				$this->extdata .= "('".mysql_escape_string($rows['fn'])."','".mysql_escape_string($rows['ln'])."','".mysql_escape_string($rows['e'])."'),";
			}
			$this->extdata = substr($this->extdata,0,-1); //remove last ',', in query
			
			return TRUE;
		endif;
	}
	
	function put_list ($link){
		$sql = "INSERT IGNORE INTO mailing_list (firstname,lastname,email)
		VALUES
		$this->extdata";
		if(@mysqli_query($link, $sql)):
			$this->mess = "You have successfully imported ".@mysqli_affected_rows($link)." new emails into the mailing list";
			return TRUE;
		else:
			$this->mess = "There was a problem adding imported data. Error message: ".mysqli_error($link);
			return FALSE;
		endif;
	}
} // End Class 'import'
///////////////////////////////////////////////
function totals ($type,$link){
	if ($type == 'sub'):
		$sql = "SELECT COUNT(email) AS num FROM mailing_list WHERE subscription='1'";
	elseif ($type == 'unsub'):
		$sql = "SELECT COUNT(email) AS num FROM mailing_list WHERE subscription='0'";
	endif;
	$result = mysqli_query ($link, $sql);
	$row = @mysqli_fetch_assoc ($result);
	return $row['num'];
}
///////////////////////////////////////////////

if (!empty($_POST['dbname'])):
	$n_ml = new import;
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mailing List</title>
<style type="text/css">
<!--
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	margin: 1px;
	background-color: #FFFFFF;
}
.style1 {
	font-size: 12px;
	font-weight: bold;
}
.field {
	font-size: 11px;
}
.style2 {color: #FF0000}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td bgcolor="#CCCCCC"><span class="style1">Mailing List Statistics</span></td>
  </tr>
  <tr>
    <td>Number of active subscribers: <strong><?php 
	$_SESSION['tot_list'] = totals('sub',$link); 
	echo $_SESSION['tot_list'];
	?></strong></td>
  </tr>
  <tr>
    <td>Number of unsubscribed: <strong><?php echo totals('unsub',$link); ?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form id="import" name="import" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC" class="style1">Import List From Database</td>
    </tr>
    <tr>
      <td colspan="3" align="left"><span class="style2"><?php echo $n_ml->mess; ?>&nbsp;</span></td>
    </tr>
    <tr>
      <td width="120" align="right"><strong>Database details: </strong></td>
      <td width="90" align="right">Host</td>
      <td><label>
        <input name="host" type="text" class="field" id="host" size="20" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right">Username</td>
      <td><label>
        <input name="username" type="text" class="field" id="username" size="20" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right">Password</td>
      <td><label>
        <input name="password" type="password" class="field" id="password" size="20" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right">DB Name</td>
      <td><label>
        <input name="dbname" type="text" class="field" id="dbname" size="20" />
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#ECE9D8">&nbsp;</td>
      <td align="right" bgcolor="#ECE9D8">&nbsp;</td>
      <td bgcolor="#ECE9D8">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><strong>Table Details:</strong></td>
      <td align="right">Table Name</td>
      <td><label>
        <input name="tblname" type="text" class="field" id="tblname" size="20" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right">FirstName Field</td>
      <td><label>
        <input name="firstname" type="text" class="field" id="firstname" size="20" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right">LastName Field</td>
      <td><label>
        <input name="lastname" type="text" class="field" id="lastname" size="20" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right">Email Field</td>
      <td><label>
        <input name="email" type="text" class="field" id="email" size="20" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td><label>
        <input name="submit" type="submit" class="field" id="submit" value="Import" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
