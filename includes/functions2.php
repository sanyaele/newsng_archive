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

function get_arts ($link, $cat, $pubdate="", $jid="", $limit="30", $start="0"){
	if (!empty($pubdate)):
		$pub = "AND articles.article_date = '$pubdate'";
	else:
		$pub = "";
	endif;
	
	if (!empty($cat)):
		$catwhere = "AND category.category = '$cat' ";
	else:
		$catwhere = "";
	endif;
	
	if (!empty($jid)):
		$wh = "AND articles.id = '$jid' ";
	else:
		$wh = "";
	endif;
	
	$sql = "SELECT articles.id, articles.title, articles.description, articles.img, articles.article_date, articles.social_score, articles.rate, articles.url, category.category, shortcode.code, sources.source
		FROM articles, category, shortcode, sources
		WHERE articles.catId = category.id
		$pub
		$wh
		$catwhere
		AND articles.id = shortcode.newsId 
		AND articles.sourceId = sources.id
		ORDER BY article_date DESC, 
		social_score DESC
		LIMIT $start, $limit";
	echo $sql;
	if ($result = @mysqli_query($link, $sql)):
		return $result;
	else:
		return FALSE;
	endif;
}

function get_related ($link, $artid){
	
	$sql = "SELECT articles.id, articles.title, articles.img, articles.article_date, articles.social_score, articles.rate, articles.url, related_articles.score
		FROM articles, related_articles
		WHERE articles.catId = related_articles.artId
		AND related_articles.artId = '".$artid."'
		ORDER BY score DESC
		LIMIT 6";
	//echo $sql;
	if ($result = @mysqli_query($link, $sql)):
		return $result;
	else:
		return FALSE;
	endif;
}

function get_related_cat ($link, $cat){
	if (!empty($cat)):
		$catwhere = "AND category.category = '$cat' ";
	else:
		$catwhere = "";
	endif;
	
	$sql = "SELECT articles.id, articles.title, articles.img, articles.article_date, articles.social_score, articles.rate, articles.url, category.category
		FROM articles, category
		WHERE articles.catId = category.id
		$catwhere
		ORDER BY RAND()
		LIMIT 6";
	//echo $sql;
	if ($result = @mysqli_query($link, $sql)):
		return $result;
	else:
		return FALSE;
	endif;
}

function get_bul ($link, $id){
	$sql = "SELECT id, title, SUBSTRING(description, 1, 400) AS description, img, storyDate
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
	$sql = "SELECT articles.id, articles.title, articles.description, articles.img, articles.url, articles.article_date, articles.social_score, category.category, sources.source, shortcode.code 
		FROM articles, category, sources, shortcode
		WHERE articles.id = '$id'
		AND articles.catId = category.id
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
function get_date ($datetime){ // Reformat date
	$sec_diff = (strtotime(date("Y-m-d H:i:s")) - strtotime(date("$datetime")));
	
	if ($sec_diff < '60'): // Less than a minute
		$time_diff = round( abs($sec_diff), 0 ); // How many seconds ago
		return $time_diff . "sec ago";
	elseif ($sec_diff < '3600'): // Less Than an hour
		$time_diff = round( abs($sec_diff) / 60, 0 ); // How many minutes ago
		$secs_rem = round( abs($sec_diff) % 60, 0 ); // How many seconds remaining
		return  $time_diff ."min ".$secs_rem ."sec ago";
	elseif ($sec_diff < '86400'): // Less Than a day
		$time_diff = round( abs($sec_diff) / 3600, 0 );  //How many hours ago
		$mins_rem = round( (abs($sec_diff) % 3600) / 60, 0 ); //How many minutes remaining
		return  $time_diff ."hr ".$mins_rem ."min ago";
	elseif ($sec_diff < '259200'): // Less Than 3 days
		$time_diff = round( abs($sec_diff) / 86400, 0 ); //How many days ago
		$hrs_rem = round( (abs($sec_diff) % 86400) / 3600, 0 ); //How many hours remaining
		return  $time_diff ."day ".$hrs_rem ."hr ago";
	else: // More than three days
		return date ("D jS F, Y H:m:s", strtotime(date($datetime))); // Display date time stamp on the last report
	endif;
}

function getcomments ($link,$artid,$limit="20"){
	$sql = "SELECT * FROM comments WHERE newsId = '$artid' ORDER BY `timestamp` DESC LIMIT $limit";
	//echo $sql;
	$result = @mysqli_query($link, $sql);
	$i = 1;
	
	$comments = array();
	$replies = array();
	while ($rows = @mysqli_fetch_assoc($result)){
		if (!empty($rows['replyId'])){
				$replies[$rows['id']]['replyId'] = $rows['replyId'];
				$replies[$rows['id']]['name'] = $rows['name'];
				$replies[$rows['id']]['comment'] = $rows['comment'];
				$replies[$rows['id']]['tdate'] = get_date ($rows['timestamp']);
				
		} else {
			$comments[$rows['id']]['name'] = $rows['name'];
			$comments[$rows['id']]['comment'] = $rows['comment'];
			$comments[$rows['id']]['tdate'] = get_date ($rows['timestamp']);
		}
		/*
		$comments .= "<div class=\"ind_comment\">
		<span style='font-size: 10px; color: #000099;'><strong>$rows[name]</strong> &nbsp;&nbsp;&nbsp;&nbsp; </span><span style='font-size: 10px; color: #666666; font-family: Tahoma, Verdana;'>[ $formated_date ]</span>
		<p>$rows[comment]</p>
		</div>";
		*/
		$i++;
	}
	
	//Process replies
	$replies2 = array_reverse($replies, true);
	$reps1 = array();
	$reps2 = array();
	
	foreach ($replies2 as $rid=>$r){
		if (array_key_exists($r['replyId'], $replies)){ // These are replies to replies
			$reps2[$rid] = $r;
		} else { // These are replies to comments
			$reps1[$rid] = $r;
		}
	}
	
	
	if ($i > 1){
		return get_formatted_comments ($comments, $reps1, $reps2);
	} else {
		return FALSE;
	}
	
	
}

function get_formatted_comments ($comments, $replies, $replies2){
	$comment_txt = '<a name="viewcomment"></a>';
		foreach ($comments as $comm_id=>$comm_det){
			$comment_txt .= '<li class="comment clearfix">
                                <article class="comment-wrap clearfix">
			<div class="comment-body">
					  <div class="comment-meta">
							<span class="author">'.$comm_det['name'].'</span>
							<span class="date">/&nbsp;&nbsp;'.$comm_det['tdate'].'</span>
						</div><!-- end:comment-meta -->                        
						<p>'.$comm_det['comment'].'</p>
						<footer class="clearfix">
							<p class="clearfix">
								<a href="#makecomment" class="comment-reply-link" onclick="document.getElementById(\'replyid\').value=\''.$comm_id.'\'">Reply</a>
							</p>
						</footer>
				  </div> 
				  </article>
				</li>';
			
			foreach ($replies as $rep_id=>$rep_det){
				if ($rep_det['replyId'] == $comm_id){
					$comment_txt .= '<ul class="children-1">
                                <li class="comment clearfix">
                                    <article class="comment-wrap clearfix">
                                      <div class="comment-body">
                                      <div class="comment-meta">
                                                <span class="author">'.$rep_det['name'].'</span>
                                            <span class="date">/&nbsp;&nbsp;'.$rep_det['tdate'].'</span>
                                            </div><!-- end:comment-meta -->                        
                                            <p>'.$rep_det['comment'].'</p>
                                            <footer class="clearfix">
                                                <p class="clearfix">
                                                    <a href="#makecomment" onclick="document.getElementById(\'replyid\').value=\''.$rep_id.'\'" class="comment-reply-link">Reply</a>
                                                </p>
                                            </footer>
                                      </div><!-- end:comment-body -->
                                    </article>                                                                               
                                </li>
                            </ul>';
							
								
					foreach ($replies2 as $rep_id2=>$rep_det2){
						if ($rep_det2['replyId'] == $rep_id){
							$comment_txt .= '<ul class="children-2">
										<li class="comment clearfix">
											<article class="comment-wrap clearfix">
											  <div class="comment-body">
											  <div class="comment-meta">
														<span class="author">'.$rep_det2['name'].'</span>
													<span class="date">/&nbsp;&nbsp;'.$rep_det2['tdate'].'</span>
													</div><!-- end:comment-meta -->                        
													<p>'.$rep_det2['comment'].'</p>
													<footer class="clearfix">
														<p class="clearfix">
															<a href="#makecomment" onclick="document.getElementById(\'replyid\').value=\''.$rep_id.'\'" class="comment-reply-link">Reply</a>
														</p>
													</footer>
											  </div><!-- end:comment-body -->
											</article>                                                                               
										</li>
									</ul>';
						}
					} // End foreach ($replies2 as $rep_id2=>$rep_det2)
				} 
			}// End foreach ($replies as $rep_id=>$rep_det)
		} // End ($comments as $comm_id=>$comm_det)
		
		$comment_txt .= '<a name="makecomment"></a>';
		
		return $comment_txt;
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