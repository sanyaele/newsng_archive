<?php
class shortcode {
	public $dblink;
	private $code;
	private $userid;
	private $artid;
	private $arttitle;
	private $cat;
	
	function __construct(){
		global $link;
		$this->dblink = $link;
		
		//print_r ($_GET);
		foreach ($_GET as $key => $value){
			if ($key != "utm_source" && $key != "utm_medium"){
				$code_parts = explode("_", $key); 
				$this->code = $code_parts[0];
				$this->userid = $code_parts[1];
			}
		}
		
		//echo "The Code: ".$this->code." <br />";
		
		if (strlen($this->code) == 5 && ctype_alnum($this->code)){
			//echo "One <br />";
			$this->countlink ($this->dblink);
			if ($this->redir ($this->dblink)){
				//echo "Two <br />";
				$this->userpref($this->dblink);
				$this->arttitle = stripslashes (htmlspecialchars(str_replace (" ", "-", $this->arttitle)));
				header ("Location: story-detail.php?title=".$this->arttitle."&story=".$this->artid,TRUE,301);
				echo "www.newsng.com/story-detail.php?title=".$this->arttitle."&story=".$this->artid;
				exit();
			}
			
		} else {
			return FALSE;
		}
		
	}
	
	function countlink ($link){
		$sql = "UPDATE shortcode SET
		traffic = traffic + 1
		WHERE code = '$this->code'";
		@mysqli_query($link, $sql);
	}
	
	function redir ($link){
		$sql = "SELECT articles.id, articles.title, articles.catId FROM shortcode, articles WHERE shortcode.code = '$this->code' AND shortcode.newsId = articles.id LIMIT 1";
		$result = @mysqli_query($link,$sql);
		$row = @mysqli_fetch_assoc($result);
		
		if (@mysqli_num_rows($result) > 0){
			$this->artid = $row['id'];
			$this->arttitle = $row['title'];
			$this->cat = $row['catId'];
			return TRUE;
		} else {
			return FALSE;
		}
		
	}
	
	function userpref ($link){
		$sql = "INSERT INTO `userpref` SET
		`category` = '$this->cat',
		`userId` = '$this->userid',
		`clickCount` = '1'
		ON DUPLICATE KEY UPDATE `clickCount` = `clickCount` + 1";
		@mysqli_query($link, $sql);
	}
}


$sc = new shortcode;
//exit();
?>