<?php
include('SimpleImage.php');
//////////////////////////////////////////
class add {
	public $newsid;
	private $title;
	private $description;
	private $categoryId;
	private $photo;
	
	public $success=0;
	
	function __construct(){
		global $link;
		$this->title = addslash($_POST['title']);
		$this->description = addslash($_POST['description']);
		$this->categoryId = substr(addslash($_POST['category']),0,1);
		if (preg_match("/imgurl=(.*(.jpg|.gif|.png){1})/",$_POST['photo'],$photoarray)):
			foreach ($photoarray as $key=>$value){
				if ($key=='1'):
					$this->photo = $value;
				endif;
			}
		else:
			$this->photo = substr(addslash($_POST['photo']),-300);
		endif;
		
		if (!empty($_POST['newsid'])):
			$this->newsid = addslash($_POST['newsid']);
			$this->editnews($link);
		else:
			$this->newsid = random_str(10); // create news id
			$this->addnews($link);
			$this->addshortcode($link);
		endif;
	}
	
	function process_img (){
		// Process photo
		$image = new SimpleImage();
		
		/////////////////////////////////////////////
		
		$image->path("../img/");
		$imgtype = substr($this->photo,-4,4);
		$image->load($this->photo,$imgtype);
		
		$fullname = $_SESSION['filename'] = $_SESSION['imgid'].$image->ext;
		
		// Resize and Save for main image
		$image->resizeToWidth(400);
		$image->save($fullname,$image->image_type);
		
		//Resize and Save for Thumbnail
		//$image->path("thumbnails/");
		//$image->resizeToWidth(100);
		//$image->save($fullname,$image->image_type);
		
		////////////////////////////////
		$fullpath = 'photos/'.$fullname;
		if (file_exists ($fullpath)):
			$_SESSION['fullpath'] = $fullpath;
		else:
			unset ($_SESSION['fullpath']);
			return "assets/nophoto.gif";
		endif;
	}
	
	function addnews($link){
		$sql = "INSERT INTO articles SET
		id='$this->newsid',
		title='$this->title',
		description='$this->description',
		catId='$this->categoryId',
		img='$this->photo',
		article_date='$_SESSION[date]'";
		if (@mysqli_query($link, $sql)):
			$this->success = 1;
		endif;
	}
	
	function editnews($link){
		$sql = "UPDATE articles SET
		title='$this->title',
		description='$this->description',
		catId='$this->categoryId',
		img='$this->photo'
		WHERE id='$this->newsid'";
		if (@mysqli_query($link, $sql)):
			$this->success = 1;
		endif;
	}
	
	function get_id ($link){
		$sql = "SELECT id FROM articles 
		WHERE title='$this->title'
		AND description='$this->description'
		AND catId='$this->categoryId'
		AND article_date='$_SESSION[date]'
		LIMIT 1";
		$result = @mysqli_query($link, $sql);
		$row = @mysqli_fetch_assoc($result);
		return $row['id'];
	}
	
	function addshortcode ($link){
		$i = 0;
		while ($i < 20){ //create a loop that ensures that the code is created
			$code = ci_rand (5);
			$sql = "INSERT INTO shortcode SET
			code = '$code',
			newsId = '$this->newsid',
			legend = 'general'";
			if (@mysqli_query($link,$sql)):
				break;
			endif;
		}
	}
}
//////////////////////////////////////////
?>