<?php
function get_cat ($link){
	$sql = "SELECT * FROM category";
	$result = @mysqli_query($link, $sql);
	while ($rows=@mysqli_fetch_assoc($result)){
		echo "<option value=\"$rows[id]\">$rows[category]</option>\n";
	}
}

function get_sources ($link){
	$sql = "SELECT * FROM sources";
	$result = @mysqli_query($link, $sql);
	while ($rows=@mysqli_fetch_assoc($result)){
		echo "<tr><td align=\"center\">$rows[source] [<a href=\"?del=$rows[id]\">remove</a>]</td></tr>\n";
	}
}

function get_sources_lnk ($link, $newsId){ //Obsolete for now
	$sql = "SELECT sources.source
	FROM sources, links
	WHERE links.newsId = '$newsId'
	AND links.sourceId = sources.id";
	$result = @mysqli_query($link, $sql);
	while ($rows = @mysqli_fetch_assoc($result)){
		$source_str .= " $rows[source] |";
	}
	$source_str = substr($source_str, 0, -1); //remove last '|'
	return $source_str;
}

function get_bulletins ($link, $pubdate, $cat){
	$yespubdate = date("Y-m-d",strtotime("yesterday"));
	$sql = "SELECT bulletin.id, bulletin.title, SUBSTRING(bulletin.description, 1, 400) AS description, bulletin.img, bulletin.storyDate, category.category
		FROM bulletin, category
		WHERE (bulletin.storyDate = '$pubdate' || bulletin.storyDate = '$yespubdate')
		AND bulletin.category = category.id
		AND category.category = '$cat' 
		ORDER BY storyDate DESC
		LIMIT 1";
	//echo $sql;
	if ($result = @mysqli_query($link, $sql)):
		return $result;
	else:
		return FALSE;
	endif;
}

function get_arts ($link, $pubdate, $cat, $jid="", $limit = "30"){
	if (!empty($cat)):
		$inner = "AND category.category = '$cat' ";
	else:
		$inner = "";
	endif;
	
	$yespubdate = date("Y-m-d",strtotime("yesterday"));
	
	if (!empty($jid)):
		$wh = "AND articles.id = '$jid' ";
	else:
		$wh = "AND (articles.article_date = '$pubdate' || articles.article_date = '$yespubdate')";
	endif;
	
	$sql = "SELECT articles.id, articles.title, articles.description, articles.img, articles.article_date, articles.social_score, articles.rate, articles.url, category.category, shortcode.code, sources.source
		FROM articles, category, shortcode, sources
		WHERE articles.catId = category.id
		$wh
		$inner
		AND articles.id = shortcode.newsId 
		AND articles.sourceId = sources.id
		ORDER BY article_date DESC, 
		social_score DESC,
		rate DESC
		LIMIT $limit";
	//echo $sql;
	if ($result = @mysqli_query($link, $sql)):
		return $result;
	else:
		return FALSE;
	endif;
}

function get_bul ($link, $id){
	$sql = "SELECT id, title, SUBSTRING(description, 1, 400) AS description, img
		FROM bulletin
		WHERE id = '$id'
		LIMIT 1";
		//echo $sql;
		//exit();
		if ($result = @mysqli_query($link, $sql)):
			return $result;
		else:
			return FALSE;
		endif;
}

function get_art ($link, $id){
	$sql = "SELECT articles.id, articles.title, articles.description, articles.img, articles.url, articles.social_score, sources.source, shortcode.code 
		FROM articles, sources, shortcode
		WHERE articles.id = '$id'
		AND articles.sourceId = sources.id
		AND articles.id = shortcode.newsId
		LIMIT 1";
		//echo $sql;
		//exit();
		if ($result = @mysqli_query($link, $sql)):
			return $result;
		else:
			return FALSE;
		endif;
}

function getcomments ($link,$artid,$limit=""){
	$comments = '';
	$sql = "SELECT * FROM comments WHERE newsId = '$artid' ORDER BY `timestamp` DESC $limit";
	$result = @mysqli_query($link, $sql);
	while ($rows = @mysqli_fetch_assoc($result)){
		$formated_date = date ("D jS F, Y",strtotime($rows['timestamp']));
		$comments .= "<div class=\"ind_comment\">
		<span style='font-size: 10px; color: #000099;'><strong>$rows[name]</strong> &nbsp;&nbsp;&nbsp;&nbsp; </span><span style='font-size: 10px; color: #666666; font-family: Tahoma, Verdana;'>[ $formated_date ]</span>
		<p>$rows[comment]</p>
		</div>";
	
	}
	return $comments;
	
}

function get_comm_no ($link, $artId){
	$sql = "SELECT COUNT(1) AS num FROM comments WHERE newsId = '$artId'";
	$result = @mysqli_query($link, $sql);
	$row = @mysqli_fetch_assoc($result);
	return $row['num'];
}
	
function rate ($link, $id){
	$sql = "UPDATE news SET rate = rate+1 WHERE id='$id' LIMIT 1";
	if (@mysqli_query($link,$sql)):
		$_SESSION['rated'][$id] = 1;
		return 1;
	else:
		return 0;
	endif;
}

function default_date ($link){
	$sql = "SELECT currDate FROM currdate LIMIT 1";
	$result = @mysqli_query($link,$sql);
	$row = @mysqli_fetch_assoc($result);
	return $row['currDate'];
}
?>