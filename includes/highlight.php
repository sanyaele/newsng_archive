<?php
///////////////////////////////////
///////////////////////////////////
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
	
	function __construct ($cat,$pubdate){
		global $link;
		$this->cat = $cat;
		
		$this->dblink = $link;
		
		// Get publication date
		$this->pubdate = $pubdate;
		
		// load news
		$this->get_articles ();
		
		// Arrange news
		$start = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		
        /*
		"<tr>
          <td height=\"80\" bgcolor=\"#242424\"><h2> $this->cat </h2></td>
        </tr>";
		*/
		
		$end = "</table>";
		// Concatenate the various parts ////
		$this->html = $start.$this->section.$end;
	}
	
	function get_articles (){ 
		//Set Name and Email sessions
		if (empty($_SESSION['name'])):
			$_SESSION['name'] = '';
			$_SESSION['email'] = '';
		endif;
		
		// Get bulletins
		if ($bresult = get_bulletins ($this->dblink, $this->pubdate, $this->cat)):
			while ($brows = @mysqli_fetch_assoc($bresult)){
					if ($brows['img'] != ''):
						$bimg_src = '<img src="'.$brows[img].'" width="100px" align="left" hspace="5" vspace="5" />';
					else:
						$bimg_src = '';
					endif;
					
					$pos1 = strrpos($brows['description'], " ");
					if ($pos1 !== false):
						$brows['description'] = substr($brows['description'], 0, $pos1);
					endif;
					$brows['description'] .= '...';
					
					$this->section .= "<tr><td>
					
					<h3><a href=\"story-detail.php?title=".urlencode(str_replace (" ", "-", $brows['title']))."&story=$brows[id]&type=b\">".ucfirst($brows['title'])."</a></h3>
					<p class=\"description\">$bimg_src ".$brows['description']."<br /><br /><br />
					</p>
					</td>
				  </tr>";
			}
		endif;
		
		// Display all articles for this section
		if ($result = get_arts ($this->dblink, $this->cat, $this->pubdate)):
			$i=1; // counter for ad display
			while ($rows = @mysqli_fetch_assoc($result)){
				if ($i <= 5):
					if ($rows['img'] != ''):
						$img_src = '<img src="'.$rows['img'].'" class=\"smallpix\" />';
					endif;
					
					$this->section .= "<tr><td>
					
					<h3><a href=\"story-detail.php?title=".urlencode(str_replace (" ", "-", $rows['title']))."&story=$rows[id]\">".ucfirst($rows['title'])."</a></h3>
					<p class=\"description\">$rows[description]<br />
					<span class=\"sscore\">Buzz: <span style=\"color: #990000;\">$rows[social_score]</span></span><br />
					<strong class=\"sources\">".ucfirst($rows['source'])." | <span style=\"color: #009900;\">".get_comm_no ($this->dblink,$rows['id'])." Comments</span></strong><br />
					";
					
					/*/////// REMOVE COMMENT FROM HOME PAGE //////////////
					$this->section .= "<div id=\"commentpack_$rows[id]\">
					<table width=\"330px\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
					  <tr>
						<td><div class=\"commentlink\"><span id=\"showcommentlink_$rows[id]\" class=\"showlink\" onclick=\"showhidecomment('$rows[id]')\"> ".get_comm_no ($this->dblink,$rows['id'])." Comments [+/-]</span></div>
							  
						</td>
					  </tr>
					  <tr>
						<td>
						<div id=\"comment_div_$rows[id]\" style=\"display:block;\">
						<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"3\" bordercolor=\"#99FF00\" class=\"comment\">
						  <tr>
							<td>".getcomments($this->dblink, $rows['id'], 'LIMIT 2')." </td>
						  </tr>
						  <tr>
							<td bordercolor=\"#CCCCCC\"><table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#ECE9D8\" bgcolor=\"#ECE9D8\" class=\"allborder\">
								<tr>
								  <td align=\"left\"><textarea name=\"comment_$rows[id]\" rows=\"2\" class=\"comment_text\" id=\"comment_$rows[id]\" onfocus=\"clear_textbox('comment_$rows[id]')\" onkeyup=\"countchars('comment_$rows[id]','charscount_$rows[id]')\" onclick=\"show_name_email('name_email_$rows[id]')\" style=\"width:223;\">Your comment here ...</textarea></td>
								</tr>
								<tr>
								  <td align=\"center\">
								  <div id=\"name_email_$rows[id]\" style=\"display:none;\">
								  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
									  <tr bordercolor=\"#009900\">
										<td width=\"50%\" align=\"left\">Name
										  <input name=\"name\" type=\"text\" class=\"comment\" id=\"name_$rows[id]\" size=\"15\" value=\"".$_SESSION['name']."\" /></td>
										<td width=\"50%\" align=\"right\">Email
										  <input name=\"email\" type=\"text\" class=\"comment\" id=\"email_$rows[id]\" size=\"15\" value=\"".$_SESSION['email']."\" /></td>
									  </tr>
								  </table>
								  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
									  <tr>
										<td width=\"41%\" align=\"left\"><span class=\"style6\">Max 500 characters</span></td>
										<td width=\"13%\" align=\"right\" class=\"style5\"><div id=\"charscount_$rows[id]\">0</div></td>
										<td width=\"12%\" align=\"left\" class=\"style5\">chars</td>
										<td width=\"34%\" align=\"right\" class=\"style5\"><img src=\"assets/add_comment_sm.gif\" alt=\"Add a comment\" width=\"94\" height=\"20\" border=\"0\" style=\"cursor:pointer\" onclick=\"put_comment('$rows[id]')\" /></td>
									  </tr>
								  </table>
								  </div>
								  </td>
								</tr>
							</table></td>
						  </tr>
						</table>
						</div>
						</td>
					  </tr>
					</table>
					</div>";
					//////END OF REMOVE COMMENT /////////////////*/
					
					$this->section .= "</p>
					</td>
				  </tr>";
			  else:
			  		$this->more .= "<a href=\"story-detail.php?title=".str_replace (" ", "-", $rows['title'])."&story=$rows[id]\">".ucfirst($rows['title'])."</a><br />";
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