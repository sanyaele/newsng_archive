<?php
require_once '../includes/admin_sess.php';
//////////////////////////////////////////

class extraction {
	private $dblink;
	private $headings;
	private $pub_date;
	private $sourceid;
	//////////////////
	public $mess;
	//////////////////
	
	function __construct(){
		global $link;
		$this->dblink = $link;
		
		$this->punch_top();
		$this->punch_best();
	}
	/////////////////////////////////////////////////////////////////////////////////////
	function punch_top (){
		$page_cont = $this->get_pg_cont('punchtopbest/top.htm'); //get page contents
		
		// Arrange article headers and links
		if (preg_match_all("/Articl.aspx\?theartic=(Art\d+)\" target=\"_parent\" title=\"\s*([^\"]+?)\s*\">\s*([^<]+?)\s*</",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						/*echo "$key=>$one=>$two <br />";
						*/
						if ($key == 1):
							$this->headings[$i]['link']=$two;
						elseif($key == 2):
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							$this->headings[$i]['title']=$two;
						endif;
						
						$i++;
						
						
				}
			}
			//get date of publication
			$this->pub_date = date("Y-m-d");
			
			if ($this->add_db($this->dblink)):
				$this->mess = "Articles added to Library";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	
	function punch_best (){
		$page_cont = $this->get_pg_cont('punchtopbest/best.htm'); //get page contents
		
		// Arrange article headers and links
		if (preg_match_all("/color=\"navy\">\s*<\s*([^>]+?)\s*>\s*([^<]+?)\s*</",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						/*echo "$key=>$one=>$two <br />";
						*/
						if ($key == 1):
							$this->headings[$i]['link']=$two;
						elseif($key == 2):
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							$this->headings[$i]['title']=$two;
						endif;
						
						$i++;
						
						
				}
			}
			//get date of publication
			$this->pub_date = date("Y-m-d");
			
			if ($this->add_db($this->dblink)):
				$this->mess = "Articles added to Library";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	//////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////
	
	function get_pg_cont($pg_url){
		return file_get_contents($pg_url);
	}
	
	function add_db ($link){
		//make query from array
		$query_det = "";
		foreach ($this->headings as $articles){
			//echo "$articles[link]=>$articles[title] <br />";//for debugging purposes
			/**/
			$query_det .= "('".str_replace('\r\n','',mysql_escape_string ($articles['title']))."','$this->pub_date'),";
			
		}
		//echo $query_det; // Add this line
		//exit(); //for debugging purposes
		
		$query_det = substr($query_det,0,-1); //remove last ',', in query
		
		$sql = "INSERT IGNORE INTO topstories (heading,article_date)
		VALUES
		$query_det";
		
		if(@mysqli_query($link, $sql)):
			return 1;
		else:
			return 0;
		endif;
	}
} // end class extracts

function todaytop ($link){
	$sql = "SELECT heading FROM topstories WHERE article_date='".date("Y-m-d")."' AND used = '0' ORDER BY id ASC";
	$result = @mysqli_query($link, $sql);
	while ($rows = @mysqli_fetch_assoc($result)){
		echo "<a href='top-assign.php?topic=$rows[heading]'>$rows[heading]</a><br />";
	}
}

function uploadfiles (){
	if ($_FILES['punchtop']['tmp_name'] != "" && $_FILES['punchbest']['tmp_name'] != ""):
		$top = "punchtopbest/top.htm";
		$best = "punchtopbest/best.htm";
		
		// Delete files if already exists
		if (file_exists ($top)):
		  unlink ($top);
		endif;
		if (file_exists ($best)):
		  unlink ($best);
		endif;
		
		// add files to directory
		if(move_uploaded_file($_FILES['punchtop']['tmp_name'], $top)):
			$mess = "The file \"".  basename( $_FILES['punchtop']['name']). 
			"\" has been uploaded <br />";
		else:
			$mess = "There was an ERROR uploading the file (".  basename( $_FILES['punchtop']['name'])."), please try again! and <br />";
		endif;
		
		if(move_uploaded_file($_FILES['punchbest']['tmp_name'], $best)):
			$mess .= "The file \"".  basename( $_FILES['punchbest']['name']). 
			"\" has been uploaded.";
		else:
			$mess .= "There was an ERROR uploading the file (".  basename( $_FILES['punchbest']['name'])."), please try again!";
		endif;
		
	else:
		$mess = "Include both Punch best and Punch top files, and try again";
	endif;
	
	return $mess;
}
//////////////////////////////
//////////////////////////////
if (!empty($_GET['extract'])):
	$extracted = new extraction;
endif;

if (!empty($_POST['uploadfiles'])):
	$up_mess = uploadfiles();
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Extract Top Stories</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
}
.style4 {
	font-family: Tahoma, Verdana;
	font-size: 11px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td><form action="" method="post" enctype="multipart/form-data" name="topfiles" id="topfiles">
      <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#ECE9D8">
        
        <tr>
          <td colspan="2" align="center" valign="middle"><span class="style1"><?php echo $up_mess;?></span></td>
          </tr>
        <tr>
          <td align="right" valign="middle"><span class="style4">Top Ten: (<a href="http://www.punchng.com/topt10.aspx" target="_blank">Open Punch Top Ten</a>)</span></td>
          <td align="left" valign="middle"><label>
          <input name="punchtop" type="file" class="style4" id="punchtop" size="30" />
          </label></td>
          </tr>
        <tr>
          <td width="50%" align="right" valign="middle"><span class="style4">Best of Punch: (<a href="http://www.punchng.com/PunchBest.aspx" target="_blank">Open Punch Best</a>)           
              <label></label>
          </span></td>
          <td width="50%" align="left" valign="middle">            <input name="punchbest" type="file" class="style4" id="punchbest" size="30" />          </td>
          </tr>
        <tr>
          <td align="right" valign="middle">&nbsp;</td>
          <td align="left" valign="middle"><input name="uploadfiles" type="hidden" id="uploadfiles" value="1" />
            <input name="send" type="submit" class="style4" id="send" value="Upload" /></td>
          </tr>
      </table>
                </form>
    </td>
  </tr>
  <tr>
    <td><strong><a href="<?php echo $_SERVER['PHP_SELF'];?>?extract=1">Extract Top Stories</a></strong></td>
  </tr>
  
  <tr>
    <td><span class="style1"><?php echo $extracted->mess;?></span></td>
  </tr>
  <tr>
    <td><?php todaytop ($link);?></td>
  </tr>
</table>
</body>
</html>
