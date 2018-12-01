<?php
require_once 'db.php';
require_once 'common.php';
//////////////////////////
class sess_control{
	private $username;
	private $password;
	private $dblink;
	
	function __construct(){
		global $link;
		$this->dblink = $link;
		if (!empty($_POST['username']) && !empty($_POST['password'])):
			$this->username = addslash ($_POST['username']);
			$this->password = addslash ($_POST['password']);
		else:
			admin_session_page("Please login to proceed ...");
		endif;
		
		//authenticate
		$this->authenticate($this->dblink);
	}
	
	function authenticate ($link){
		$sql = "SELECT * FROM admin WHERE username = '$this->username' AND password = PASSWORD('$this->password') LIMIT 1";
		if (!$result = mysqli_query ($link, $sql)):
			admin_session_page("There was a problem processing your login request, please try again later.");
		else:
			if (mysqli_num_rows ($result) < 1):
				admin_session_page("Please provide valid credentials to proceed");
			else:
				$row = mysqli_fetch_assoc ($result);
				
				// Set session data
				$_SESSION['user_session'] = session_id();
				$_SESSION['username'] = $this->username;
				$_SESSION['type'] = $row['type'];
			endif;
		endif;
	}
}

// If user request log-off //////////////////////////////////////////////////////////////
if (isset ($_REQUEST['logoff'])):
	$_SESSION = array(); 
	session_destroy();
	admin_session_page ("You have Successfully logged off");
endif;

// SEARCH FOR USER SESSION //////////////////////////////////////
if (empty($_SESSION['user_session']) || $_SESSION['user_session'] != session_id()):
	$session = new sess_control();
endif
?>