<?php
exit();
////////////////////////
$site_type = "html";
require_once 'includes/redirect.php';
///////////////////////////////////
require_once 'includes/db.php';

require_once 'includes/common.php';
require_once 'includes/class.stemmer.inc';
require_once 'includes/cleansearch.php';
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
			$dresult .= "<tr><td class=\"newslist\"><h3><a href=\"story-detail.php?title=$rows[title]&story=$rows[id]\">".ucwords(strtolower($rows['title']))."</a></h3>
					  <p class=\"style2\">$rows[description]</p>
					<p class=\"style1\"><span class=\"datef\"><strong>Story Date:</strong> $rows[storyDate]</span> 
					| <strong>Source</strong></p></td>
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
-->
</style>
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCC33" class="allborder">
  <tr>
    <td bgcolor="#FFFFFF"><?php
	include_once 'header.html';
	?>
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="5">
        <tr>
          <td align="left" valign="top"><h1>Search Hottest Nigerian News</h1></td>
          <td align="left" valign="top" bordercolor="#66FF02" class="style1">&nbsp;</td>
        </tr>
        <tr>
          <td width="75%" align="left" valign="top" bordercolor="#00FF00"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><form id="search" name="search" method="get" action="search.php">
                    <label>
                    <input name="searchterm" type="text" class="style1" id="searchterm" size="30" />
                    </label>
                    <label>
                    <input type="submit" value="S e a r c h" />
                    </label>
                </form></td>
              </tr>
              <?php
      echo $search_news->f_result;
	  ?>
          </table></td>
          <td width="25%" align="left" valign="top" bordercolor="#006600"><table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td><span class="style8 style12">Archives</span> </td>
              </tr>
              <tr>
                <td height="200" align="left" valign="top" bordercolor="#B4C6DB" class="allborder"><?php archives();?>
                  &nbsp;
                  <form id="archives" name="archives" method="get" action="">
                    <span class="style11">
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
                </form></td>
              </tr>
            </table>
              <br />
              <table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td><span class="style8">Subscribe to our RSS Feed</span></td>
                </tr>
                <tr>
                  <td height="100" align="center" valign="middle" bordercolor="#B4C6DB" class="allborder"><a href="feed.php?cat="><img src="assets/rss.jpg" alt="RSS Feeds" width="124" height="123" border="0" /></a></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td><?php
	include_once 'footer.html';
	?></td>
          <td>&nbsp;</td>
        </tr>
      </table>
    <script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
      </script></td>
  </tr>
</table>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7718160-3");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>
