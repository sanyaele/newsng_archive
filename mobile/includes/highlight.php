<?php
///////////////////////////////////
// get news for different sections
class get_news {
	public $pubdate;
	private $dblink;
	/////////////////
	public $news;
	public $business;
	public $politics;
	public $sports;
	public $entertainment;
	public $technology;
	//////////////////////
	public $section;
	public $more;
	public $html;
	public $nav;
	
	function __construct ($cat,$pubdate){
		global $link;
		$this->cat = $cat;
		
		$this->dblink = $link;
		
		// Get publication date
		$this->pubdate = $pubdate;
		
		// load news
		$this->get_news ($this->dblink);
		
		// Arrange news
		$start = "<div><div class='h2div'><h2> $this->cat </h2></div>";
		
		$end = "</div>";
		// Concatenate the various parts ////
		$this->html = $start.$this->section.$end;
	}
	
	
	function get_news ($link){
		global $navbar;
		if ($result = get_arts ($this->dblink, $this->cat, $this->pubdate)):
			$i=1; // counter for ad display
			while ($rows = @mysqli_fetch_assoc($result)){
				//insert in navigation
				$navbar[] = $rows['id'];
				if ($i <= 3):
					$this->section .= "
					<h3><a href=\"story-detail.php?story=$rows[id]\">".strtoupper($rows['title'])."</a></h3>
					<p class=\"description\">$rows[description]<br />
					<span class=\"sscore\">Buzz: <span style=\"color: #990000;\">$rows[social_score]</span></span><br />
					<strong class=\"sources\">".ucfirst($rows['source'])."</strong><br />
					<div id=\"commentpack_$rows[id]\">
					<div class=\"commentlink\"> <strong>Comments: ".get_comm_no ($this->dblink,$rows['id'])." </strong>
							</div>
							
							
						<div><a href=\"story-detail.php?story=$rows[id]\"> Add/View Comments</a></div>
						
					</div>
					
					</p>";
			  else:
			  	$this->more .= "&#9658;<a href=\"story-detail.php?story=$rows[id]\">".ucfirst($rows['title'])."</a><br />";
			  endif;
			  
			  /*
			  if (!($i % 3) && ($i <= 5) && ($this->cat == 'News')):
			  	$this->section .= "
				<tr><td align=\"left\">
				<script type=\"text/javascript\"><!--
				google_ad_client = \"pub-2732469417891860\";
				/* 234x60, created 3/27/10 */
				/*google_ad_slot = \"3984235449\";
				google_ad_width = 234;
				google_ad_height = 60;
				//-->
				</script>
				<script type=\"text/javascript\"
				src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
				</script>
				</td></tr>
				";
			  endif;
			  */
			  
			  $i++;
			}
		endif;
	}
} // end class
?>