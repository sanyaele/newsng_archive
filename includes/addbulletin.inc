<?php
//////////////////////////////////////////
class add {
	public $newsid;
	private $title;
	private $description;
	private $category;
	private $photo;
	
	public $success=0;
	
	function __construct(){
		global $link;
		$this->title = addslash($_POST['title']);
		$this->description = addslash($_POST['description']);
		$this->category = substr(addslash($_POST['category']), 0, 4);
		
		
		
		if (!empty($_POST['newsid'])):
			$this->newsid = addslash($_POST['newsid']);
			
			if (!empty($_FILES['image']['size'])):
				$this->process_img ();
			endif;
			
			$this->editnews($link);
		else:
			$this->newsid = random_str(10); // create news id
			
			if (!empty($_FILES['image']['size'])):
				$this->process_img ();
			endif;
			
			$this->addnews($link);
		endif;
	}
	
	function process_img (){
		include('SimpleImage.php');
		// Process photo
		$image = new SimpleImage();
		
		/////////////////////////////////////////////
		//Get file type from $_FILES array
		$imgtype = (!empty($_FILES['image']['type']))? $_FILES['image']['type']:null;
		
		$image->path("../img/");
		$image->load($_FILES['image']['tmp_name'],$imgtype);
		
		$photo = strtolower($this->newsid).$image->ext;
		
		// Resize and Save for main image
		$image->resizeToWidth(300);
		$image->save($photo,$image->image_type);
		
		$this->photo = "http://".$_SERVER["HTTP_HOST"]."/img/".$photo;
	}
	
	function addnews($link){
		$sql = "INSERT INTO bulletin SET
		id='$this->newsid',
		title='$this->title',
		description='$this->description',
		category='$this->category',
		img='$this->photo',
		storyDate='$_SESSION[date]'";
		if (@mysqli_query($link, $sql)):
			$this->success = 1;
		endif;
	}
	
	function editnews($link){
		$sql = "UPDATE bulletin SET
		title='$this->title',
		description='$this->description',
		category='$this->category',
		img='$this->photo'
		WHERE id='$this->newsid'";
		if (@mysqli_query($link, $sql)):
			$this->success = 1;
		endif;
	}
	
	function get_id ($link){
		$sql = "SELECT id FROM bulletin 
		WHERE title='$this->title'
		AND description='$this->description'
		AND category='$this->category'
		LIMIT 1";
		$result = @mysqli_query($link, $sql);
		$row = @mysqli_fetch_assoc($result);
		return $row['id'];
	}
}
//////////////////////////////////////////
?>