<?php

class process_reg {
	private $dblink;
	private $headings;
	private $pub_date;
	private $sourceid;
	//////////////////
	public $mess;
	public $color = "#FF0000";
	//////////////////
	
	function __construct(){
		global $link;
		$this->dblink = $link;
		
		//clean code
		$this->sourceid = substr(addslash($_GET['source']),0,2);
	}
	
	/////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////
	
	function process_feed (){
		
		$this->headings[$i]['link']=$two;
		$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
		$this->headings[$i]['title']=$two;
		$this->pub_date = date("Y-m-d");
		if ($this->add_db($this->dblink,'http://www.punchng.com/Articl.aspx?theartic=%art%')):
			$this->mess = "Articles added to Library for <strong>$_GET[paper]</strong>";
			$this->color = "#00FF00";
		else:
			$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
		endif;
	}
	/////////////////////////////////////////////////////////////////////////////////////
	
	function add_db ($link,$url){
		//make query from array
		$query_det = "";
		foreach ($this->headings as $articles){
			//echo "$articles[link]=>$articles[title] <br />";//for debugging purposes
			/**/
			$url_t = str_replace("%art%",$articles['link'],$url);
			$query_det .= "('$this->sourceid','".str_replace('\r\n','',mysql_escape_string ($articles['title']))."','".mysql_escape_string($url_t)."','$this->pub_date'),";
			
		}
		//echo $query_det; // Add this line
		//exit(); //for debugging purposes
		
		$query_det = substr($query_det,0,-1); //remove last ',', in query
		
		$sql = "INSERT IGNORE INTO headings (sourceId,heading,url,article_date)
		VALUES
		$query_det";
		
		if(@mysqli_query($link, $sql)):
			return 1;
		else:
			return 0;
		endif;
	}
}
?>