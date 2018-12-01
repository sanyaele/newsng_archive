<?php

////////////////////////
require_once 'includes/db.php';

require_once 'includes/common.php';
require_once 'includes/functions.php';
///////////////////////////////////
require_once 'includes/pub_date.php';

/* E X A M P L E -----------------------------------------------
		$feed = new RSS();
		$feed->title       = "RSS Feed Title";
		$feed->link        = "http://website.com";
		$feed->description = "Recent articles on your website.";

		$db->query($query);
		$result = $db->result;
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$item = new RSSItem();
			$item->title = $title;
			$item->link  = $link;
			$item->setPubDate($create_date); 
			$item->description = "<![CDATA[ $html ]]>";
			$feed->addItem($item);
		}
		echo $feed->serve();
	---------------------------------------------------------------- */

	class RSS
	{
		var $title;
		var $sscore;
		var $link;
		var $description;
		var $language = "en-us";
		var $pubDate;
		var $items;
		var $tags;

		function RSS()
		{
			$this->items = array();
			$this->tags  = array();
		}

		function addItem($item)
		{
			$this->items[] = $item;
		}

		function setPubDate($when)
		{
			if(strtotime($when) == false)
				$this->pubDate = date("D, d M Y H:i:s ", $when) . "GMT";
			else
				$this->pubDate = date("D, d M Y H:i:s ", strtotime($when)) . "GMT";
		}

		function getPubDate()
		{
  			if(empty($this->pubDate))
				return date("D, d M Y H:i:s ") . "GMT";
			else
				return $this->pubDate;
		}

		function addTag($tag, $value)
		{
			$this->tags[$tag] = $value;
		}

		function out()
		{
			$out  = $this->head();
			$out .= "<channel>\n";
			$out .= "<title>" . $this->title . "</title>\n";
			$out .= "<link>" . $this->link . "</link>\n";
			$out .= "<description>" . $this->description . "</description>\n";
			$out .= "<language>" . $this->language . "</language>\n";
			$out .= "<pubDate>" . $this->getPubDate() . "</pubDate>\n";
			$out .= '<atom10:link xmlns:atom10="http://www.w3.org/2005/Atom" rel="self" type="application/rss+xml" href="http://newsng.com/feed.php" />' . "\n";

			foreach($this->tags as $key => $val) $out .= "<$key>$val</$key>\n";
			foreach($this->items as $item) $out .= $item->out();

			$out .= "</channel>\n";
			
			$out .= $this->footer();

			$out = str_replace("&", "&amp;", $out);

			return $out;
		}
		
		function serve($contentType = "application/xml")
		{
			$xml = $this->out();
			header("Content-type:$contentType");
			echo $xml;
		}

		function head()
		{
			$out  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
			$out .= '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">' . "\n";
			return $out;
		}

		function footer()
		{
			return '</rss>';
		}
	} // End class RSS

	class RSSItem
	{
		var $title;
		var $sscore;
		var $link;
		var $description;
		var $pubDate;
		var $guid;
		var $tags;
		var $attachment;
		var $length;
		var $mimetype;

		function RSSItem()
		{ 
			$this->tags = array();
		}

		function setPubDate($when)
		{
			if(strtotime($when) == false)
				$this->pubDate = date("D, d M Y H:i:s ", $when) . "GMT";
			else
				$this->pubDate = date("D, d M Y H:i:s ", strtotime($when)) . "GMT";
		}

		function getPubDate()
		{
			if(empty($this->pubDate))
				return date("D, d M Y H:i:s ") . "GMT";
			else
				return $this->pubDate;
		}

		function addTag($tag, $value)
		{
			$this->tags[$tag] = $value;
		}

		function out()
		{
			$out .= "<item>\n";
			$out .= "<title>" . html_entity_decode(($this->title), ENT_QUOTES, "UTF-8") . " (Buzz: ".$this->sscore.")</title>\n";
			$out .= "<link>" . $this->link . "</link>\n";
			$out .= "<description>" . $this->description . "</description>\n";
			$out .= "<pubDate>" . $this->getPubDate() . "</pubDate>\n";

			if($this->attachment != "")
				$out .= "<enclosure url='{$this->attachment}' length='{$this->length}' type='{$this->mimetype}' />";

			if(empty($this->guid)) $this->guid = $this->link;
			$out .= "<guid>" . $this->guid . "</guid>\n";

			foreach($this->tags as $key => $val) $out .= "<$key>$val</$key\n>";
			$out .= "</item>\n";
			return $out;
		}

		function enclosure($url, $mimetype, $length)
		{
			$this->attachment = $url;
			$this->mimetype   = $mimetype;
			$this->length     = $length;
		}
	} // End class RSSItem
	
	/////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////
	$feed = new RSS();
	$feed->title       = "Today's Hottest Nigerian News";
	$feed->link        = "http://newsng.com";
	$feed->description = "We provide the most recent Nigerian news in the most accessible manner, organising Nigerian news from various sources into one unified system. And allowing you access to this information through the web and automatically updated News on your desktop/online/mobile RSS Feeds.";


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
$ddlink = $link;


// Set Category ////////////////////////
if (!empty($_GET['cat'])):
	$cat = addslash($_GET['cat']);
	$cat_where = "AND category.category = '$cat'";
else:
	$cat_where = "";
endif;


$sql = "SELECT articles.id, articles.title, articles.description, articles.img, articles.social_score,  articles.timeAdded, category.category, shortcode.code, sources.source
FROM articles, category, shortcode, sources
WHERE articles.catId = category.id
AND articles.id = shortcode.newsId
AND articles.sourceId = sources.id
AND articles.social_score != '0'
$cat_where
ORDER BY article_date DESC, 
social_score DESC
LIMIT 20";

$dblink = $link;
if ($result = mysqli_query($dblink, $sql)):
	while ($rows = mysqli_fetch_assoc($result)){
		$item = new RSSItem();
		$item->title = htmlspecialchars($rows['title'], ENT_QUOTES, 'utf-8');
		$item->sscore = $rows['social_score'];
		$item->link  = "http://newsng.com/?$rows[code]";
		$item->setPubDate($rows['timeAdded']); 
		$item->guid = 'http://newsng.com/story-detail.php?title='.urlencode(str_replace (" ", "-", $rows['title'])).'&story='.$rows['id'];
		$item->description = "<![CDATA[<img src='$rows[img]' alt='' align='left' />".$rows['description']." (Source: ".$rows['source'].") ]]> ";
		$feed->addItem($item);
	}
	
	$feed->serve();
endif;
		
		
?>