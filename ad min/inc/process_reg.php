<?php

class process {
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
		$this->redirect ($_GET['paper']);
	}
	
	function redirect ($paper){
		if ($paper == 'The Punch'):
			$this->punch_p();
		elseif($paper == 'This Day'):
			$this->thisday_p();
		elseif($paper == 'Next'):
			$this->next_p();
		elseif($paper == 'Guardian'):
			$this->guardian_p();
		elseif($paper == 'Vanguard'):
			$this->vanguard_p();
		elseif($paper == 'Daily Independent'):
			$this->independent_p();
		elseif($paper == 'Daily Sun'):
			$this->sun_p();
		elseif($paper == 'Nigerian Tribune'):
			$this->tribune_p();
		elseif($paper == 'Business Day'):
			$this->bday_p();
		elseif($paper == 'The Nation'):
			$this->nation_p();
		elseif($paper == 'Daily Trust'):
			$this->dtrust_p();
		else:
			return false;
		endif;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////
	
	function punch_p (){
		$page_cont = $this->get_pg_cont('http://www.punchontheweb.com/'); //get page contents
		
		// Arrange article headers and links
		if (preg_match_all("/<<a href=\"Articl.aspx\?theartic=(Art\d+)\"( class=\"toc\"| class=\"header\" style=\"font-size:17px;\"| title=\"[^\"]+\"){0,1}>\s*([^<]+?)\s*</",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						/*echo "$key=>$one=>$two <br />";
						*/
						if ($key == 2):
							$this->headings[$i]['link']=$two;
						elseif($key == 5):
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							$this->headings[$i]['title']=$two;
						endif;
						
						$i++;
						
						
				}
			}
			
			//get date of publication
			if(preg_match("/<SPAN id=\"datetime\">\w+, (\d{1,2} [A-Z]{1}\w+ 20\d{2})<BR><\/SPAN>/",$page_cont,$dates)):
				$this->pub_date = date("Y-m-d",strtotime($dates[1]));
			else:
				$this->pub_date = date("Y-m-d");
			endif;
			
			if ($this->add_db($this->dblink,'http://www.punchng.com/Articl.aspx?theartic=%art%')):
				$this->mess = "Articles added to Library for <strong>$_GET[paper]</strong>";
				$this->color = "#00FF00";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	
	function thisday_p (){
		$page_cont = $this->get_pg_cont('http://www.thisdayonline.com/'); //get page contents
		
		// Arrange article headers and links
		if (preg_match_all("/<a href=\"\/nview.php\?id=(\d+?)\"( class=\"hline\"){0,1}>([^<]+?)<\/a>/",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						//echo "$key=>$one=>$two <br />\n";
						/**/
						if ($key == 1): //article distinct id
							$this->headings[$i]['link']=$two;
						elseif($key == 3): //article header text
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							if ($two != 'More...'):
								$this->headings[$i]['title']=$two;
							else:
								unset($this->headings[$i]);
							endif;
						endif;
						$i++;
						
						
				}
				
			}
			//exit(); // in conjuction with ///echo "$key=>$one=>$two <br />\n";/// above, to test output
			
			//get date of publication
			$this->pub_date = date("Y-m-d");
			
			if ($this->add_db($this->dblink,'http://www.thisdayonline.com/nview.php?id=%art%')):
				$this->mess = "Articles added to Library for <strong>$_GET[paper]</strong>";
				$this->color = "#00FF00";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	
	function next_p (){
		$page_cont = $this->get_pg_cont('http://www.234next.com/'); //get page contents
		
		// Arrange article headers and links
		if (preg_match_all("/<a href=\"\/(\S+?\/\d+?-\d+?\/\w+?).csp\"( class=\"\"| class=\"gray\"| title=\"\"){0,1} >\s*(<!-- If there is web headline, use it -->){0,1}\s*([^<]+?)\s*(<!-- Display Web Headline -->){0,1}\s*<\/a>/",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						//echo "$key=>$one=>$two <br />\n";
						/**/
						if ($key == 1): //article distinct id
							$this->headings[$i]['link']=$two;
						elseif($key == 4): //article header text
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							if (!preg_match("/^Comments \d+$/",$two)):
								$this->headings[$i]['title']=$two;
							else:
								unset($this->headings[$i]);
							endif;
						endif;
						$i++;
						
				}
			}
			//exit(); // in conjuction with ///echo "$key=>$one=>$two <br />\n";/// above, to test output
			
			//get date of publication
			if(preg_match("/<div id=\"current-date\">\s*\w+?,&nbsp;(\w+? \d{1,2}, 20\d{2}) \d{2}:\d{2}/",$page_cont,$dates)):
				$this->pub_date = date("Y-m-d",strtotime($dates[1]));
			else:
				$this->pub_date = date("Y-m-d");
			endif;
			
			if ($this->add_db($this->dblink,'http://www.234next.com/%art%.csp')):
				$this->mess = "Articles added to Library for <strong>$_GET[paper]</strong>";
				$this->color = "#00FF00";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	
	function guardian_p (){
		$page_cont = $this->get_pg_cont('http://www.ngrguardiannews.com/'); //get page contents
		
		// Arrange article headers and links
		if (preg_match_all("/<a href=\"([^\"]+)\"( class=heading0| class=\"heading\"| class=textlink2| class=heading|  class=heading){0,1} ( ){0,1}>\s*([^<]+?)\s*<\/a>/",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						//echo "$key=>$one=>$two <br />\n";
						/**/
						if ($key == 1): //article distinct id
							$this->headings[$i]['link']=$two;
						elseif($key == 4): //article header text
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							$this->headings[$i]['title']=$two;
						endif;
						$i++;
						
						
				}
				
			}
			//exit(); // in conjuction with ///echo "$key=>$one=>$two <br />\n";/// above, to test output
			
			//get date of publication
			if(preg_match("/<font class=\"date\">\s*\w+?, (\w+? \d{1,2}, 20\d{2})/",$page_cont,$dates)):
				$this->pub_date = date("Y-m-d",strtotime($dates[1]));
			else:
				$this->pub_date = date("Y-m-d");
			endif;
			
			if ($this->add_db($this->dblink,'%art%')):
				$this->mess = "Articles added to Library for <strong>$_GET[paper]</strong>";
				$this->color = "#00FF00";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	
	function vanguard_p (){
		$page_cont = $this->get_pg_cont('http://www.vanguardngr.com/'); //get page contents
		
		// Arrange article headers and links
		if (preg_match_all("/(<h2 class=\"\w+?\">|<h3 class=\"bigPostTitle\">)<a href=\"([^\"]+)\"( rel=\"bookmark\"){0,1}>\s*([^<]+?)\s*<\/a>/",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						//echo "$key=>$one=>$two <br />\n";
						/**/
						if ($key == 2): //article distinct id
							$this->headings[$i]['link']=$two;
						elseif($key == 4): //article header text
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							$this->headings[$i]['title']=$two;
						endif;
						$i++;
						
						
				}
				
			}
			//exit(); // in conjuction with ///echo "$key=>$one=>$two <br />\n";/// above, to test output
			
			//get date of publication
			if(preg_match("/ \/ \s*(\w+? \d{1,2}, 20\d{2})/",$page_cont,$dates)):
				/*
				foreach ($dates as $key=>$value) {
					echo "$key=>$value <br />\n";
				}
				*/
				$this->pub_date = date("Y-m-d",strtotime($dates[1]));
				//echo $this->pub_date;
				//exit();
			else:
				$this->pub_date = date("Y-m-d");
			endif;
			
			if ($this->add_db($this->dblink,'%art%')):
				$this->mess = "Articles from <strong>$_GET[paper]</strong> added to Library";
				$this->color = "#00FF00";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	
	function independent_p (){
		$page_cont = $this->get_pg_cont('http://www.independentngonline.com/'); //get page contents
		
		// Arrange article headers and links
		if (preg_match_all("/<a href=\"([^\"]+)\"( class=\"links_title\"| class=\"links_lead\"| class=\"links1\"){0,1}>\s*([^<]+?)\s*<\/a>/",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						//echo "$key=>$one=>$two <br />\n";
						/**/
						if ($key == 1): //article distinct id
							$this->headings[$i]['link']=$two;
						elseif($key == 3): //article header text
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							if ($two != ' '):
								$this->headings[$i]['title']=$two;
							else:
								unset($this->headings[$i]);
							endif;
						endif;
						$i++;
						
						
				}
				
			}
			//exit(); // in conjuction with ///echo "$key=>$one=>$two <br />\n";/// above, to test output
			
			//get date of publication
			if(preg_match("/\s*\w+?, (\d{1,2} \w+? 20\d{2})/",$page_cont,$dates)):
				/*
				foreach ($dates as $key=>$value) {
					echo "$key=>$value <br />\n";
				}
				*/
				$this->pub_date = date("Y-m-d",strtotime($dates[1]));
				//echo $this->pub_date;
				//exit();
			else:
				$this->pub_date = date("Y-m-d");
			endif;
			
			if ($this->add_db($this->dblink,'%art%')):
				$this->mess = "Articles added to Library for <strong>$_GET[paper]</strong>";
				$this->color = "#00FF00";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	
	function sun_p (){
		$page_cont = $this->get_pg_cont('http://www.sunnewsonline.com'); //get page contents
		
		// Arrange article headers and links
		if (preg_match_all("/<a href=\"(webpages[^\"]+)\">\s*([^<]+?)\s*<\/a>/",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						//echo "$key=>$one=>$two <br />\n";
						/**/
						if ($key == 1): //article distinct id
							$this->headings[$i]['link']=$two;
						elseif($key == 2): //article header text
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							$this->headings[$i]['title']=$two;
						endif;
						$i++;
						
						
				}
				
			}
			
			/*
			if (preg_match_all("/<a href=\"([^\"]+)\">\s*([^<]+?)\s*(<\/a>\s*\.\.\.|\.\.\.\s*<\/a>){1}/",$page_cont,$heads2)):
			foreach ($heads2 as $key=>$value) {
				$i2=i;
				foreach ($value as $one=>$two){
						//echo "$key=>$one=>$two <br />\n";
						if ($key == 1): //article distinct id
							$this->headings[$i2]['link']=$two;
						elseif($key == 2): //article header text
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							$this->headings[$i2]['title']=$two;
						endif;
						$i2++;
						
						
				}
				
			}
			endif;
			*/
			
			//exit(); // in conjuction with ///echo "$key=>$one=>$two <br />\n";/// above, to test output
			
			//get date of publication 19-03-2010
			$this->pub_date = date("Y-m-d");
			if(preg_match("/(\d{1,2}-\d{1,2}-20\d{2})/",$page_cont,$dates)):
				/*
				foreach ($dates as $key=>$value) {
					echo "$key=>$value <br />\n";
				}
				*/
				
				$this->pub_date = date("Y-m-d",strtotime($dates[1]));
				//echo $this->pub_date;
				//exit();
			else:
				$this->pub_date = date("Y-m-d");
			endif;
			
			if ($this->add_db($this->dblink,'http://www.sunnewsonline.com/%art%')):
				$this->mess = "Articles added to Library for <strong>$_GET[paper]</strong>";
				$this->color = "#00FF00";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	
	function tribune_p (){
		$page_cont = $this->get_pg_cont('http://www.tribune.com.ng/'); //get page contents
		// Arrange article headers and links
		if (preg_match_all("/<a href=\"([^\"]+)\"( class=\"latestnews\"| class=\"contentpagetitle\"| class=\"roknewspager-title\"){0,1}>\s*([^<]+?)\s*<\/a>/",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						//echo "$key=>$one=>$two <br />\n";
						/**/
						if ($key == 1): //article distinct id
							$this->headings[$i]['link']=$two;
						elseif($key == 3): //article header text
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							$this->headings[$i]['title']=$two;
						endif;
						
						$i++;
						
						
				}
				
			}
			
			
			//exit(); // in conjuction with ///echo "$key=>$one=>$two <br />\n";/// above, to test output
			
			//get date of publication
			if(preg_match_all("/<span class=\"date\d{1}\">([^<]+?)<\/span>/",$page_cont,$dates)):
				/*
				foreach ($dates as $key=>$value) {
					foreach ($value as $one=>$two){
						echo "$key=>$one=>$two <br />\n";
					}
				}
				*/
				$datestr = $dates[1][2]." ".$dates[1][1]." ".$dates[1][3];
				$this->pub_date = date("Y-m-d",strtotime($datestr));
				//echo $this->pub_date;
				//exit();
			else:
				$this->pub_date = date("Y-m-d");
			endif;
			
			if ($this->add_db($this->dblink,'http://www.tribune.com.ng%art%')):
				$this->mess = "Articles added to Library for <strong>$_GET[paper]</strong>";
				$this->color = "#00FF00";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	
	
	function bday_p (){
		$page_cont = $this->get_pg_cont('http://www.businessdayonline.com/'); //get page contents
		// Arrange article headers and links
		if (preg_match_all("/<a( title=\"([^\"]+)\"){0,1} href=\"(\/index[^\"]+)\"( title=\"([^\"]+)\"| class=\"latestnews\"){0,1}>\s*([^<]+?)\s*<\/a>/",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						//echo "$key=>$one=>$two <br />\n";
						/**/
						if ($key == 3): //article distinct id
							$this->headings[$i]['link']=$two;
						elseif($key == 6): //article header text
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							$this->headings[$i]['title']=$two;
						endif;
						
						$i++;
						
						
				}
				
			}
			
			
			//exit(); // in conjuction with ///echo "$key=>$one=>$two <br />\n";/// above, to test output
			
			//get date of publication
			if(preg_match("/\s*\w+?, (\d{1,2} \w+? 20\d{2})/",$page_cont,$dates)):
				/*
				foreach ($dates as $key=>$value) {
					echo "$key=>$value <br />\n";
				}
				*/
				
				$this->pub_date = date("Y-m-d",strtotime($dates[1]));
				//echo $this->pub_date;
				//exit();
			else:
				$this->pub_date = date("Y-m-d");
			endif;
			
			if ($this->add_db($this->dblink,'http://www.businessdayonline.com%art%')):
				$this->mess = "Articles added to Library for <strong>$_GET[paper]</strong>";
				$this->color = "#00FF00";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	
	
	function nation_p (){ 
		$page_cont = $this->get_pg_cont('http://www.thenationonlineng.net'); //get page contents
		// Arrange article headers and links
		if (preg_match_all("/<a href=\"(http:\/\/thenationonlineng.net\/web2\/articles\/[^\"]+)\"( target='_top'){0,1}>\s*([^<]+?)\s*<\/a>/",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						//echo "$key=>$one=>$two <br />\n";
						/**/
						if ($key == 1): //article distinct id
							$this->headings[$i]['link']=$two;
						elseif($key == 3): //article header text
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							$this->headings[$i]['title']=$two;
						endif;
						
						$i++;
						
				}
				
			}
			
			
			//exit(); // in conjuction with ///echo "$key=>$one=>$two <br />\n";/// above, to test output
			
			//get date of publication
			$this->pub_date = date("Y-m-d");
			
			if ($this->add_db($this->dblink,'%art%')):
				$this->mess = "Articles added to Library for <strong>$_GET[paper]</strong>";
				$this->color = "#00FF00";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	
	function dtrust_p (){ 
		$page_cont = $this->get_pg_cont('http://www.news.dailytrust.com/'); //get page contents
		// Arrange article headers and links
		if (preg_match_all("/<a href=\"(\/index.php\?option=com_content&amp;view=article&amp;[^\"]+)\"( title=\"([^\"]+)\"| class=\"latestnews\"){0,1}>\s*([^<]+?)\s*<\/a>/",$page_cont,$heads)):
			foreach ($heads as $key=>$value) {
				$i=0;
				foreach ($value as $one=>$two){
						//echo "$key=>$one=>$two <br />\n";
						/**/
						if ($key == 1): //article distinct id
							$this->headings[$i]['link']=$two;
						elseif($key == 4): //article header text
							$two = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $two);
							$this->headings[$i]['title']=$two;
						endif;
						
						$i++;
						
				}
				
			}
			
			
			//exit(); // in conjuction with ///echo "$key=>$one=>$two <br />\n";/// above, to test output
			
			//get date of publication
			$this->pub_date = date("Y-m-d");
			
			if ($this->add_db($this->dblink,'http://www.news.dailytrust.com%art%')):
				$this->mess = "Articles added to Library for <strong>$_GET[paper]</strong>";
				$this->color = "#00FF00";
			else:
				$this->mess = "Could not add the articles to the library for <strong>$_GET[paper]</strong>";
			endif;
		else:
			$this->mess = "No match found";
		endif;
	}
	/////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////
	
	function get_pg_cont($pg_url){
		return file_get_contents($pg_url);
	}
	
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
///////////////////////////////////////
?>