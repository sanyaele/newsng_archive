<?php
class thelinks {
	public $options;
	public $jvscript;
	public $links;
	private $newsid;
	public $title;
	
	function __construct (){
		global $link;
		$this->newsid = addslash($_GET['newsid']);
		/////////////////////////////////
		$this->get_sources($link);
		$this->get_links ($link);
	}
	
	function get_sources ($link){
		$sql = "SELECT * FROM sources";
		$result = @mysqli_query($link, $sql);
		while ($rows=@mysqli_fetch_assoc($result)){
			$this->options .= "<option value=\"$rows[id]\">$rows[source]</option>\n";
			///////////////////////////////////////////////////////////
			// Create JavaScript code
			$this->jvscript .= "else if(document.getElementById('source').value == \"$rows[id]\"){ \n
			document.getElementById('url').value = \"$rows[url]\"; \n
			} \n";
		}
	}
	
	function get_links ($link){
		$sql = "SELECT links.id, links.link, sources.source, news.title 
		FROM links, sources, news
		WHERE newsId = '$this->newsid'
		AND links.sourceId = sources.id
		AND links.newsId = news.id";
		$result = @mysqli_query($link, $sql);
		while ($rows=@mysqli_fetch_assoc($result)){
			$this->links .= "<p><strong class=\"style2\">$rows[source]:</strong> $rows[link] <a href=\"links.php?del=$rows[id]&newsid=$this->newsid\"><strong>[X]</strong></a></p>";
			
			$this->title = $rows['title'];
		}
	}
} // End class thelinks
?>