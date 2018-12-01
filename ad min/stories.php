<?php
require_once '../includes/admin_sess.php';
require_once '../includes/functions.php';
//////////////////////////////////////////
// get news for different sections
class get_news {
	public $pubdate;
	private $dblink;
	/////////////////
	public $news;
	public $politics;
	public $business;
	public $sports;
	public $fashion;
	public $entertainment;
	//////////////////////
	public $section;
	
	function __construct (){
		global $link;
		$this->dblink = $link;
		// Set date if use is viewing an older article
		if (!empty($_GET['archive']) && strlen($_GET['archive']) == 10):
			$this->pubdate = str_replace ("_", "-", addslash (substr ($_GET['archive'],0,11)));
		elseif (!empty($_GET['day']) && !empty($_GET['month']) && !empty($_GET['year'])):
			$this->pubdate = substr (addslash ($_GET['year']."-".$_GET['month']."-".$_GET['day']), 0, 10);
		elseif (!empty($_SESSION['date'])):
			$this->pubdate = $_SESSION['date'];
		else:
			$this->pubdate = date ("Y-m-d", time());
		endif;
		
		// load news
		$this->getnews ($this->dblink);
	}
	
	function getnews ($link){
		$sql = "SELECT articles.id, articles.title, articles.description, articles.img, articles.social_score, articles.rate, category.category,  sources.source
		FROM articles, category, sources
		WHERE articles.article_date = '$this->pubdate'
		AND articles.catId = category.id
		AND articles.sourceId = sources.id";
		//echo $sql;
		if ($result = @mysqli_query($link, $sql)):
			while ($rows = @mysqli_fetch_assoc($result)){
				if (empty($this->section[$rows['category']])):
					$this->section[$rows['category']] = '';
				endif;
				
				
				if ($rows['img'] == ''):
					$img_src = '../assets/default_news_img.gif';
				else:
					$img_src = $rows['img'];
				endif;
				
				$this->section[$rows['category']] .= "<tr><td class=\"newslist\">
				
				<strong class=\"style2\">" .ucwords(strtolower($rows['title'])). "</strong> 
				
				<p class=\"style2\">$rows[description]</p>
				
				<span class=\"style1\">
				[ <strong><a href=\"news.php?edit=$rows[id]\" target=\"addedit\">Edit Story</a></strong> | <strong><a href=\"#\" onclick=\"confirmation('$rows[id]','$this->pubdate')\">Delete Story</a></strong> ]<br />
				<strong><a href=\"mod_comments.php?newsid=$rows[id]\" target=\"addedit\">Moderate ".get_comm_no($this->dblink, $rows['id'])." Comments</a></strong><br />
				<strong>Source:</strong>".$rows['source']."  | <strong>$rows[rate] Views</strong></span><hr /></td>
			  </tr>";
			  //<img src=\"$img_src\" width=\"100\" height=\"100\" align=\"left\" />
			  //echo "[<a href=\"links.php?newsid=$rows[id]\" target=\"addedit\">Create Related Links</a>]";
			}
		endif;
	}
	/////////////////////////////////////////////////
	function build_sections ($section){
		$start = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
        <tr>
          <td><h2 class=\"style3\"> ".ucwords(strtolower($section))." <a name=\"$section\" id=\"$section\"></a></h2></td>
        </tr>";
		
		$end = "</table>";
		// Concatenate the various parts ////
		if (!empty($this->section[$section])):
			$all = $start.$this->section[$section].$end;
			return ($all);
		else:
			return FALSE;
		endif;
	}	
} // end class
////////////////////////////////////////////////////
////////////////////////////////////////////////////
function del_story ($link,$del_id){
	$n_link = $link;
	$del_id = addslash($del_id);
	
	$sql = "DELETE FROM news WHERE news.id = '$del_id'";
	
	if (@mysqli_query($n_link, $sql)):
		del_link($link,$del_id);
		del_comments($link,$del_id);
		return TRUE;
	else:
		return FALSE;
	endif;
}

function del_link ($link,$del_id){
	$sql = "DELETE FROM links WHERE newsId = '$del_id'";
	@mysqli_query($link, $sql);
}

function del_comments ($link,$del_id){
	$sql = "DELETE FROM comments WHERE newsId = '$del_id'";
	@mysqli_query($link, $sql);
}
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
function archives (){
	// print for today
	echo "<br /><a href=\"stories.php\"><strong>Refresh Today</strong></a> <br />";
	
	$i=1;
	while ($i < 10){
		$pageday = date("l dS F Y", strtotime("-$i day"));
		$urlday = date("Y_m_d", strtotime("-$i day"));
		echo "<br /><a href=\"stories.php?archive=$urlday\">$pageday</a> <br />";
		$i++;
	}
}
/////////////////////////////////////////////////////
// if admin deletes article
if (!empty($_GET['del'])):
	if (del_story ($link,$_GET['del'])):
		$mess = "You have successfully deleted article <strong>$_GET[del]</strong>";
	endif;
endif;
/////////////////////////////////////////////////////

$new_news = new get_news;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css.css" rel="stylesheet" type="text/css" />
<title>News Nigeria</title>
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: 10px;
}
.style8 {color: #006699; font-weight: bold; }
.style9 {
	color: #FF0000;
	font-weight: bold;
}
.style12 {font-size: 10px}
.style13 {color: #0000FF}
.style14 {color: #FF0000}
-->
</style>

<script type="text/javascript">
<!--
function confirmation(story,archive) {
	var answer = confirm("Are you sure you want to delete this Article?")
	if (answer){
		window.location = "stories.php?del="+story+"&amp;archive="+archive;
	}
}
//-->
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="5" bgcolor="#FFFFFF">
  
  <tr>
    <td rowspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        
        <tr>
          <td><a href="news.php" target="addedit"><img src="../assets/addstory.gif" alt="Add New Story" width="77" height="21" border="0" /></a> <a href="add_video.php" target="addedit"><img src="../assets/addvideo.gif" alt="Add New Video" width="77" height="21" border="0" /></a></td>
        </tr>
        <tr>
          <td><span class="style14"><?php if (!empty($mess)){ echo $mess; }?></span></td>
        </tr>
        <tr>
          <td>
          <?php
	  echo $new_news->build_sections("News");
	  ?></td>
      </tr>
        
        <tr>
          <td><?php
	  echo $new_news->build_sections("Politics");
	  ?></td>
      </tr>
        <tr>
          <td><?php
	  echo $new_news->build_sections("Business");
	  ?></td>
      </tr>
        <tr>
          <td><?php
	  echo $new_news->build_sections("Sports");
	  ?></td>
      </tr>
        <tr>
          <td><?php
	  echo $new_news->build_sections("Technology");
	  ?></td>
      </tr>
        <tr>
          <td><?php
	  echo $new_news->build_sections("Health");
	  ?></td>
      </tr>
        <tr>
          <td><?php
	  echo $new_news->build_sections("Fashion");
	  ?></td>
      </tr>
        <tr>
          <td><?php
	  echo $new_news->build_sections("Entertainment");
	  ?></td>
      </tr>
        
    </table>      
    <h2>&nbsp;</h2></td>
    <td align="left" valign="top" bordercolor="#66FF02" class="style1"><span class="style9">Story Date: <?php echo $new_news->pubdate;?></span></td>
  </tr>
  <tr>
    <td width="200" align="left" valign="top" bordercolor="#006600"><br />
      <table width="100%" border="0" cellspacing="0" cellpadding="5">
      
      <tr>
        <td bgcolor="#B4C6DB"><span class="style8">Refresh For Current Stories</span> </td>
      </tr>
      <tr>
        <td height="200" align="left" valign="top" bordercolor="#B4C6DB" class="allborder style12"><?php archives();?>&nbsp;
          <form id="archives" name="archives" method="get" action="">
            <span class="style13">
            <select name="day" class="style1" id="day">
              <option selected="selected">dd</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
            </select>
            <select name="month" class="style1" id="month">
              <option selected="selected">mm</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>
            <label>
            <select name="year" class="style1" id="year">
              <option>Year</option>
              <option value="2009">2009</option>
                        <option value="2010">2010</option>
                        <option value="2011">2011</option>
            </select>
            </label>
            <label>
            <input name="go" type="submit" class="style1" id="go" value="Find" />
            </label>
            </span>
          </form>          </td>
      </tr>
    </table>
      </td>
  </tr>
</table>
</body>
</html>
