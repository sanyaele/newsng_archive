<?php
class addcomment {
	private $id;
	private $name;
	private $email;
	private $comment;
	private $comments;
	
	function __construct(){
		$this->id = addslash ($_POST['news_id']);
	}
	
	function clean (){
		$this->name = $_SESSION['name'] = addslash ($_POST['name']);
		$this->email = $_SESSION['email'] = addslash ($_POST['email']);
		$this->comment = addslash ($_POST['comment']);
	}
	
	function add ($link){
		$sql = "INSERT INTO comments SET
		name = '$this->name',
		email = '$this->email',
		comment = '$this->comment',
		newsId = '$this->id'";
		
		if (@mysqli_query($link, $sql)):
			return TRUE;
		else:
			return FALSE;
		endif;
	}
}
/////////////////////////////////////////////////////////////////////////////////

?>