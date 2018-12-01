<?php
require_once 'functions.php';
///////////////////////////////////
class get_news {
	public $pubdate;
	private $dblink;
	/////////////////
	public $cat;
	//////////////////////
	public $section;
	
	function __construct ($cat){
		global $link;
		$this->cat = $cat;
		
		$this->dblink = $link;
		// Set date if use is viewing an older article
		if (!empty($_GET['archive']) && strlen($_GET['archive']) == 10):
			$this->pubdate = str_replace ("_", "-", addslash (substr ($_GET['archive'],0,11)));
		elseif (!empty($_GET['day']) && !empty($_GET['month']) && !empty($_GET['year'])):
			$this->pubdate = substr (addslash ($_GET['year']."-".$_GET['month']."-".$_GET['day']), 0, 10);
		else: // Set a default date
			$this->pubdate = default_date($this->dblink);
		endif;
		
		// load news
		$this->get_articles ();
	}
	
	function get_articles (){
		if ($result = get_arts ($this->dblink, $this->cat, $this->pubdate)):
			$i=1; // counter for ad display
			while ($rows = @mysqli_fetch_assoc($result)){
				if ($rows['img'] != ''):
					$img_src = '<img src="'.$rows[img].'" width="100" align="left" hspace="3" vspace="3" />';
				endif;
				
				$this->section .= "<tr><td>
				
				<h3 class=\"title_inner\" style=\"font-size: 22px;\"><a href=\"story-detail.php?title=".str_replace (" ", "-", $rows['title'])."&story=$rows[id]\">".ucfirst($rows['title'])."</a></h3>
			  <p class=\"description\">$rows[description]<br />
			  <span class=\"sscore\">Buzz: <span style=\"color: #990000;\">$rows[social_score]</span></span><br />
							<strong class=\"sources\">Source: ".ucfirst($rows['source'])."</strong> | 
							<strong class=\"comment\"> ".get_comm_no ($this->dblink, $rows['id'])." Comments</strong><br />
</p></td>
			  </tr>";
			  
			  	if ($i % 3):
					$this->section .= "";
				else:
					$this->section .= "
					<tr><td align=\"left\">
					<script type=\"text/javascript\"><!--
					google_ad_client = \"pub-2732469417891860\";
					/* 728x90, created 10/5/09 */
					google_ad_slot = \"9338416308\";
					google_ad_width = 728;
					google_ad_height = 90;
					//-->
					</script>
					  <script type=\"text/javascript\"
					src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
					</script>
					</td></tr>
					";
				endif;
			  $i++;
			}
		endif;
	}
	
	/////////////////////////////////////////////////
	function build_sections (){
		$start = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
        <tr>
          <td><h2 class=\"style3\"> $this->cat <a name=\"$this->cat\" id=\"$this->cat\"></a></h2></td>
        </tr>";
		
		$end = "</table>";
		// Concatenate the various parts ////
		$all = $start.$this->section.$end;
		return ($all);
	}	
} // end class
?>