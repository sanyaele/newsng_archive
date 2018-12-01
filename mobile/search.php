<?php
exit();
////////////////////////
// OBSOLETTE SEARCH, Use google search instead
////////////////////////
$site_type = "mini";
require_once '../includes/redirect.php';
///////////////////////////////////
require_once '../includes/db.php';
require_once '../includes/common.php';
require_once '../includes/class.stemmer.inc';
require_once '../includes/cleansearch.php';
///////////////////////////////////
class search {
	private $dblink;
	private $result;
	private $searchstring;
	public $f_result;
	private $s_array;
	
	function __construct (){
		global $link;
		$this->dblink = $link;
	}	
	
	function fulltext ($string, $link){ // Do the default fulltext search on the database
		$this->searchstring = $string;
		$this->s_array = split (" ",$this->searchstring);
		//////////////////////////////////////////
		$this->searchstring = $this->searchstring;
		$sql = "SELECT DISTINCT MATCH(title, description) Against ('$this->searchstring' IN BOOLEAN MODE) as score, id, title, description, article_date FROM articles WHERE MATCH(title, description) Against ('$this->searchstring' IN BOOLEAN MODE) ORDER BY article_date DESC";
		$this->result = @mysqli_query($link, $sql);
		
		if (@mysqli_num_rows($this->result) > 0):
			$this->f_result = $this->fresult ();
			return TRUE;
		else:
			$this->f_result = "<tr><td><p style=\"color:#FF0000\"><strong>There are no results to display</strong></p></td></tr>";
			return FALSE;
		endif;
	}
	
	/////////////////////////////////////////////////////
	function altsearch ($string, $link){
		$this->searchstring = $string;
		$this->s_array = split (" ",$this->searchstring);
		$this->searchstring = $this->s_array;
		
		// compile sql query ///////////////////////////////////////////
		$sql = "SELECT DISTINCT COUNT(*) As score, id, title, description, article_date FROM articles WHERE (";
		while(list($key,$val)=each($this->searchstring)){
		  if($val<>" " and strlen($val) > 0){
		  $sql .= "(title LIKE '%$val%' OR description LIKE '%$val%') OR";
		  }
		}
		$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
		$sql .= ") GROUP BY id ORDER BY storyDate DESC";
		////////////////////////////////////////////////////////////////
		$this->result = @mysqli_query($link, $sql);
		if (@mysqli_num_rows($this->result) > 0):
			$this->f_result = $this->fresult ();
			return TRUE;
		else:
			$this->f_result = "<tr><td><p style=\"color:#FF0000\"><strong>There are no results to display</strong></p></td></tr>";
			return FALSE;
		endif;
	}
	
	/////////////////////////////////////////////////////
	// Format Result ////////////////////////////////////
	function fresult (){
		while ($rows=@mysqli_fetch_assoc($this->result)){
			$formated_date = date ("D jS F, Y",strtotime($rows['article_date']));
			$dresult .= "<tr><td class=\"newslist\"><h3><a href=\"story-detail.php?story=$rows[id]\">".ucwords(strtolower($rows['title']))."</a></h3>
					  <p class=\"description\">$rows[description]</p>
					<p><span class=\"datef\"><strong>Story Date:</strong> $formated_date </span> 
					<br />
					<strong class=\"sources\">Show Source</strong></p></td>
				  </tr><tr>";
		}
		
		// highlight searched terms
		while(list($key,$keyword)=each($this->s_array)){
			// format exactly as is
			$dresult = str_replace($keyword, "<b>$keyword</b>", $dresult);
			
			// format first cap words
			$c_keyword = ucwords(strtolower($keyword));
			$dresult = str_replace($c_keyword, "<b>$c_keyword</b>", $dresult);
			
			// format all cap words
			$c_keyword = strtoupper($keyword);
			$dresult = str_replace($c_keyword, "<b>$c_keyword</b>", $dresult);
			
			// format small cap words
			$c_keyword = strtolower($keyword);
			$dresult = str_replace($c_keyword, "<b>$c_keyword</b>", $dresult);
		}
		
		return ($dresult);
	}
}

///////////////////////////////////
function archives (){
	// print for today
	echo "<br /><a href=\"index.php\" class=\"archive\"><strong>Today</strong></a> <br />";
	
	$i=1;
	while ($i < 10){
		$pageday = date("l dS F, Y", strtotime("-$i day"));
		$urlday = date("Y_m_d", strtotime("-$i day"));
		echo "<br /><a href=\"index.php?archive=$urlday\" class=\"archive\">$pageday</a> <br />";
		$i++;
	}
}
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////

if (!empty($_GET['searchterm'])):
	$srch_str = addslash ($_GET['searchterm']);
	//////////////////////////////////////////////////////////////
	$stemmer = new Stemmer;
	//////////////////////////////////////////////////////////////
	$clean_string = new cleaner();
	
	// Search with full text search //////////////////////////////
	$search_news = new search();
	//////////////////////////////////////////////////////////////
	if (!$showr = $search_news->fulltext($srch_str, $link)):
		// If full text fails, proceed to the next level
		$split = split(" ",$srch_str);
		  foreach ($split as $array => $value) {
			  if (strlen($value) < 3) {
				  continue;
			  }
			  $stemmed_string = $clean_string->parseString($value);
			  $stemmed_string = $stemmer->stem($stemmed_string);
			  
			  $new_string .= ''.$stemmed_string.' ';
		  }
		$new_string=substr($new_string,0,(strLen($new_string)-1));
		//Search with alternative text search ////////////////////
		$showr = $search_news->altsearch($new_string, $link);
	endif;
	//////////////////////////////////////////////////////////////
	
	
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_GET['searchterm'];?> - Search News Nigeria</title>
<link rel="alternate" type="application/rss+xml" href="feed.php?cat=" title="Today's Hottest Nigerian News" />
<link href="assets/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: 12px;
}
.style5 {
	color: #0066FF;
	line-height: 20px;
}
.style6 {font-size: 13px}
.style8 {color: #006699; font-weight: bold; }
.style9 {
	color: #FF0000;
	font-weight: bold;
}
.style11 {	font-size: 9px;
	color: #0000FF;
}
.style12 {	font-size: 10px;
	font-weight: bold;
}
.style28 {color: #009900}
.style30 {color: #FF0000;
	font-size: 10px;
}
.style31 {color: #FFFFFF}
.style33 {font-size: 10px; font-weight: bold; color: #FFFF00; }
.style34 {color: #009900; font-weight: bold; }
.style35 {font-size: 9px}
.style38 {font-family: Tahoma, Verdana;
	font-weight: bold;
}
.style39 {font-size: 14px}
-->
</style>
</head>

<body>
<table width="240" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="left"><img src="assets/logo.gif" alt="Nigerian News" width="236" height="35" /></td>
  </tr>
  <tr>
    <td align="center"><h1>Search Hottest Nigerian News</h1></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><a href="index.php">Home</a> | <a href="contact.php">Contact</a></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><script type="text/javascript"><!--
		google_ad_client = "ca-pub-2732469417891860";
		/* mobile half banner */
		google_ad_slot = "2507257902";
		google_ad_width = 234;
		google_ad_height = 60;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script></td>
  </tr>
  <tr>
    <td align="center"><form id="search" name="search" method="get" action="search.php">
      <label>
      <input name="searchterm" type="text" class="style1" id="searchterm" size="20" />
      </label>
      <label>
      <input type="submit" value="S e a r c h" />
      </label>
    </form></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
              </tr>
              <?php
      echo $search_news->f_result;
	  ?>
          </table></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#006600"><span class="style33">Send feedback to <a href="mailto:contact@newsng.com" class="style31">contact@newsng.com</a></span></td>
  </tr>
  <tr>
    <td align="center"><span class="style35">&copy;Copyright2009-2011 <a href="http://www.goldensteps.com.ng">GoldenSteps Enterprises</a>.All Rights Reserved</span></td>
  </tr>
</table>
<?php 
//////////////////////////////
/// google analytics /////////
//////////////////////////////
include_once 'g_analytics.php';
?>
</body>
</html>
