<?php
require_once '../includes/db.php';
require_once '../includes/common.php';
///////////////////////////////////
class addcomment {
	private $id;
	private $name;
	private $email;
	private $comment;
	private $comments;
	
	function __construct(){
		$this->id = addslash ($_GET['news_id']);
	}
	
	function clean (){
		$this->name = $_SESSION['name'] = addslash ($_GET['name']);
		$this->email = $_SESSION['email'] = addslash ($_GET['email']);
		$this->comment = addslash ($_GET['comment']);
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
	
	function get ($link){
		$sql = "SELECT * FROM comments WHERE newsId = '$this->id' ORDER BY `timestamp` DESC";
		$result = @mysqli_query($link, $sql);
		while ($rows = @mysqli_fetch_assoc($result)){
			$formated_date = date ("D jS F, Y",strtotime($rows['timestamp']));
			$this->comments .= "<div class=\"ind_comment\">
		<span style='font-size: 10px; color: #000099;'><strong>$rows[name]</strong> &nbsp;&nbsp;&nbsp;&nbsp; </span><span style='font-size: 10px; color: #666666; font-family: Tahoma, Verdana;'>[ $formated_date ]</span>
		<p>$rows[comment]</p>
		</div>";
		
		}
		echo $this->comments;
	}
}
/////////////////////////////////////////////////////////////////////////////////
$addcomm = new addcomment;

// Add to comment if fields not empty
if (!empty($_GET['name']) && !empty($_GET['email']) && !empty($_GET['comment'])):
	$addcomm->clean();
	$addcomm->add($link);
endif;

// echo comments
$addcomm->get($link);
?>