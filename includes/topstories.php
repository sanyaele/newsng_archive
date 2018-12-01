<?php
function topstories ($link,$pubdate){
	$sql = "SELECT id, title, social_score
		FROM articles
		WHERE article_date='$pubdate'
		ORDER BY social_score DESC
		LIMIT 10";
	$result = @mysqli_query($link, $sql);
	while ($rows = @mysqli_fetch_assoc($result)){
		if (strlen($rows['title']) > '39'):
			$contd = "...";
		else:
			$contd = "";
		endif;
		echo "<p>
				<a href=\"http://www.newsng.com/story-detail.php?title=".str_replace (" ", "-", $rows['title'])."&story=$rows[id]\" title=\"".ucfirst($rows['title'])."\">".substr (ucfirst($rows['title']),0,39)."$contd</a>
			</p>";
	}
}
?>