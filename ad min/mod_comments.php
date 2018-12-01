<?php
require_once '../includes/admin_sess.php';
///////////////////////////////////
function del_comm($link){
	$commId = addslash($_GET['del']);
	$sql = "DELETE FROM comments WHERE id='$commId'";
	@mysqli_query($link, $sql);
}
/////////////////////////////////////////////
if (!empty($_GET['del'])):
	del_comm($link);
endif;
/////////////////////////////////////////////
/////////////////////////////////////////////
class dcomments {
	public $list_comments;
	private $newsid;
	public $title;
	
	function __construct (){
		global $link;
		$this->newsid = addslash($_GET['newsid']);
		/////////////////////////////////
		$this->comments($link);
	}
	
	function comments ($link){
		$sql = "SELECT comments.id, comments.name, comments.comment, comments.timestamp, news.title 
		FROM comments, news 
		WHERE newsId = '$this->newsid' 
		AND comments.newsId = news.id 
		ORDER BY `timestamp` DESC";
		$result = @mysqli_query($link, $sql);
		while ($rows = @mysqli_fetch_assoc($result)){
			$this->list_comments .= "<span class='comment'>$rows[comment]</span><br />
			<span style='font-size: 10px; color: #FFFFFF;'><strong>$rows[name]</strong>  | $rows[timestamp] 
			<a href=\"mod_comments.php?del=$rows[id]&newsid=$this->newsid\"><strong>[X]</strong></a></span><hr />";
			
			$this->title = $rows['title'];
		}
	}
} // End class thelinks
//////////////////////////////////////////////
$get = new dcomments;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add and Remove News Links</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	color: #FFFF00;
}
.style2 {color: #FFFF00}
.style13 {color: #00FF00; font-size: 10px; }
.style14 {font-size: 10px}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#009900">
  <tr>
    <td width="323" align="left"><span class="style1"><strong>Moderate Comments for:</strong> <br />
    <?php echo $get->title;?></span></td>
  </tr>
  
  <tr>
    <td align="left"><span class="style14">
      <?php echo $get->list_comments;?>
    &nbsp;</span></td>
  </tr>
</table>
</body>
</html>
