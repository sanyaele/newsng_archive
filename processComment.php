<?php

require_once 'includes/db.php';
require_once 'includes/common.php';
require_once 'includes/functions.php';
///////////////////////////////////
function add ($link, $id, $name, $email, $comment, $cid){
	$sql = "INSERT INTO comments SET
	name = '$name',
	email = '$email',
	comment = '$comment',
	newsId = '$id',
	replyId = '$cid'";
	
	if (@mysqli_query($link, $sql)):
		return TRUE;
	else:
		return FALSE;
	endif;
}

function notcaptcha (){
	require_once('includes/recaptchalib.php');
	$privatekey = "6LfTFPcSAAAAALB3sY65IjT890jO_HHr6Ny9dJCU";
	$resp = recaptcha_check_answer ($privatekey,
								$_SERVER["REMOTE_ADDR"],
								$_POST["recaptcha_challenge_field"],
								$_POST["recaptcha_response_field"]);
	
	if (!$resp->is_valid) {
	// What happens when the CAPTCHA was entered incorrectly
		return TRUE;
	/*
	die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
		 "(reCAPTCHA said: " . $resp->error . ")");
	*/
	} else {
		return FALSE;
	}
}

///////////////////////////////////
// Clean up the input values
foreach($_POST as $key => $value) {
	if(ini_get('magic_quotes_gpc'))
		$_POST[$key] = stripslashes($_POST[$key]);
	
	$_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
}

// Assign the input values to variables for easy reference
$name = $_POST["name"];
$email = $_POST["email"];
$artid = $_POST["artid"];
$replyid = $_POST["replyid"];
$comment = $_POST["message"];

// Test input values for errors
$errors = array();
if(strlen($name) < 2) {
	if(!$name) {
		$errors[] = "You must enter a name.";
	} else {
		$errors[] = "Name must be at least 2 characters.";
	}
}
if(!$email) {
	$errors[] = "You must enter an email.";
} else if(!validEmail($email)) {
	$errors[] = "You must enter a valid email.";
}
if(strlen($comment) < 10) {
	if(!$comment) {
		$errors[] = "You must enter a message.";
	} else {
		$errors[] = "Message must be at least 10 characters.";
	}
}

// Test Captcha
if (notcaptcha()){
	$errors[] = "The reCAPTCHA wasn't entered correctly. Please try it again.";
}
	
if($errors) {
	// Output errors and die with a failure message
	$errortext = "";
	foreach($errors as $error) {
		$errortext .= "<li>".$error."</li>";
	}
	die("<span class='failure'>The following errors occured:<ul>". $errortext ."</ul></span>");
}

// Add to db
add ($link, $artid, $name, $email, $comment, $replyid);

// Show comments with a success message
echo "<span class='success'>Success! Your comment has been added.</span><br />".getcomments ($link, $artid); 

// Die
die();


?>