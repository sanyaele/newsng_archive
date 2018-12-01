<?php
function topstories ($link,$pubdate='',$limit=4){
	$link2 = $link;
	
	if ($pubdate==''){
		$wh = "1";
	} else {
		$wh = "`article_date`='$pubdate'";
	}
	
	$sql = "SELECT `id`, `title`, `description`, `img`, `social_score`, `article_date`
		FROM `articles`
		WHERE $wh
		ORDER BY `article_date` DESC, 
		`social_score` DESC
		LIMIT ".$limit;
	$result = @mysqli_query($link, $sql);
	while ($rows = @mysqli_fetch_assoc($result)){

		if (empty($rows['img'])){
			$rows['img'] = 'placeholders/217x143/217x143-2.jpg';
		}
		
		echo '
		<li>
			<article>
				<header class="clearfix">
					<a href="story-detail.php?title='.str_replace (" ", "-", $rows['title']).'&story='.$rows['id'].'"><img src="'.$rows['img'].'" class="responsive-img" alt="'.$rows['title'].'" /></a>
					<p><strong>'.date("d", strtotime($rows['article_date'])).' /</strong><span>'.date("F", strtotime($rows['article_date'])).' '.date("Y", strtotime($rows['article_date'])).'</span></p>
					<span class="entry-comments">'.$rows['social_score'].' Buzz <span>'.get_comm_no ($link2, $rows['id']).' Comments</span> </span>
				</header>
				<div class="entry-content">
					<h6 class="entry-title"><a href="story-detail.php?title='.str_replace (" ", "-", $rows['title']).'&story='.$rows['id'].'">'.ucfirst($rows['title']).'</a></h6>
					'. html_entity_decode($rows['description']).'
					<a class="more-link" href="story-detail.php?title='.str_replace (" ", "-", $rows['title']).'&story='.$rows['id'].'">Learn more</a>
				</div><!--entry-content-->
			</article>
		</li>';
	}
}

function featured_imgs ($link,$pubdate=''){
	if ($pubdate==''){
		$wh = "1";
	} else {
		$wh = "`article_date`='$pubdate'";
	}
	
	$sql = "SELECT `id`, `title`, `description`, `img`, `social_score`, `article_date`
		FROM `articles`
		WHERE $wh
		AND `img` != ''
		ORDER BY `article_date` DESC, 
		`social_score` DESC
		LIMIT 7";
	$result = @mysqli_query($link, $sql);
	while ($rows = @mysqli_fetch_assoc($result)){
		echo '
		<li>
				<article>
					<a class="entry-thumb" href="story-detail.php?title='.str_replace (" ", "-", $rows['title']).'&story='.$rows['id'].'"><img src="'.$rows['img'].'" alt="'.$rows['title'].'" /></a>
					<div class="entry-content">
						<h2 class="entry-title"><a href="story-detail.php?title='.str_replace (" ", "-", $rows['title']).'&story='.$rows['id'].'">'.ucfirst($rows['title']).'</a></h2>
						'. html_entity_decode($rows['description']).'
						<a class="more-link" href="story-detail.php?title='.str_replace (" ", "-", $rows['title']).'&story='.$rows['id'].'">Learn more</a>
					</div><!--entry-content-->
				</article>
			</li>';
	}
}

function alltime ($link){
	$sql = "SELECT `articles`.`id`, `articles`.`title`, `articles`.`img`, `articles`.`social_score`, `articles`.`article_date`, `category`.`category`
		FROM `articles`, `category`
		WHERE `articles`.`catId` = `category`.`id`
		ORDER BY `social_score` DESC
		LIMIT 10";
	$result = @mysqli_query($link, $sql);
	while ($rows = @mysqli_fetch_assoc($result)){
		echo '          <div class="entry-item">
                            <h5 class="entry-title"><a href="story-detail.php?title='.str_replace (" ", "-", $rows['title']).'&story='.$rows['id'].'">'.ucfirst($rows['title']).'</a> <span>'.ucfirst($rows['category']).' &nbsp; <span>Buzz: '.$rows['social_score'].'</span></span></h5>
							
                        </div>';
	}
}
?>