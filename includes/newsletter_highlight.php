<?php
///////////////////////////////////
// get news for different sections
require_once 'functions.php';
///////////////////////////////////
class get_news {
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
	public $section2;
	public $more;
	public $more2;
	public $html;
	public $nonhtml;
	//////////////////////
	public $title1;
	private $campaign;
	
	function __construct ($cat,$campaign=''){
		global $link;
		$this->cat = $cat;
		
		$this->dblink = $link;
		
		$this->campaign = $campaign;
		
		// load news
		$this->get_articles ();
		
		// Arrange news
		$start = "<div><h2> $this->cat </h2>";
		$start2 = "$this->cat
		
		";
		
		
		$end = "</div>";
		$end2 = "";
		// Concatenate the various parts ////
		$this->html = $start.$this->section."\n <div style=\"font-size: small;\">".$this->more."</div>".$end;
		$this->nonhtml = $start2.$this->section2.$end2;
	}
	
	
	function get_articles (){
		if (!empty($this->campaign)):
			$tlink = "&utm_source=MailingList&utm_medium=email&utm_campaign=$this->campaign";
		else:
			$tlink = "";
		endif;
		
		if ($result = get_arts ($this->dblink, $this->cat)):
			$i=1; // counter for ad display
			while ($rows = @mysqli_fetch_assoc($result)){
				if ($i <= 3):
					if ($rows['img'] != ''):
						$img_src = '<img src="'.$rows[img].'" width="100px" height="auto" align="left" hspace="3" vspace="3" />';
					else:
						$img_src = '';
					endif;
					
					//Make first title variable
					if (empty($this->title1)):
						$this->title1 = substr(ucfirst($rows['title']),0,100);
					endif;
					
					$this->section .= "<div>
					
					<h3 class=\"title\"><a href=\"http://www.newsng.com/story-detail.php?title=".str_replace (" ", "-", $rows['title'])."&story=$rows[id]".$tlink."\">".ucfirst($rows['title'])."</a></h3>
					$img_src
					<p class=\"description\">$rows[description]<br />
					<span class=\"sscore\">Buzz: <span style=\"color: #990000;\">$rows[social_score]</span></span><br />
					<strong class=\"sources\">".ucfirst($rows['source'])."</strong>
					</p><br /><br />
					</div>";
				  
				  $this->section2 .= ucfirst($rows['title'])."[ www.newsng.com/story-detail.php?title=".str_replace (" ", "-", $rows['title'])."&story=$rows[id]".$tlink." ] \n\n
				  
				  $rows[description] \n
				  Buzz: $rows[social_score] \n
				  Source: ".ucfirst($rows['source'])."\n";
			  else:
			  		$this->more .= "<a href=\"http://www.newsng.com/story-detail.php?title=".str_replace (" ", "-", $rows['title'])."&story=$rows[id]".$tlink."\">".ucfirst($rows['title'])."</a><br />";
					$this->more2 = ucfirst($rows['title'])."[ www.newsng.com/story-detail.php?story=$rows[id]&title=".str_replace (" ", "-", $rows['title']).$tlink." ] \n";
			  endif;
			  
			  //don't add more if number of articles is sufficient
			  if ($i > 8){
				  break;
			  }
			  
			  /*/ Add Advert
			  
			  if (!($i % 3) && ($i <= 5) && ($this->cat == 'News')):
			  	$this->section .= "
				<tr><td align=\"left\">
				<script type=\"text/javascript\"><!--
				google_ad_client = \"pub-2732469417891860\";
				// 234x60, created 3/27/10 
				google_ad_slot = \"3984235449\";
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
			  
			  //////// End Advert //*/
			  
			  $i++;
			}
		endif;
	}
	
} // end class
?>