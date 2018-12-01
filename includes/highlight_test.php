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
	private $start;
	//////////////////////
	public $section;
	public $section2;
	public $more;
	public $html;
	
	function __construct ($cat,$num_art="6",$page="1",$pubdate=""){
		global $link;
		$this->cat = $cat;
		
		$this->dblink = $link;
		
		// Get publication date
		$this->pubdate = $pubdate;
		
		if ($page > 1 && $page <= 5){
			$this->start = ($page - 1)*$num_art;
		} else {
			$this->start = 0;
		}
		
		
		// load news
		$this->get_articles ($num_art);
		
		// Arrange news
		$start = '<div class="column-b-left">';
		$middle = '
					</div><!--column-b-left-->
					<div class="column-b-right">
					';
		$end = '
					</div><!--column-b-right-->';
		// Concatenate the various parts ////
		$this->html = $start.$this->section.$middle.$this->section2.$end;
	}
	
	function get_articles ($num_art){ 
		$mid = number_format(($num_art/2),0);
		
		// Get articles
		if ($result = get_arts ($this->dblink, $this->cat, $this->pubdate, "", $num_art, $this->start)):
			$iter = 0;
			while ($rows = @mysqli_fetch_assoc($result)){
							
				if (empty($rows['img'])){
					$rows['img'] = 'placeholders/329x194/329x194-1.jpg';
				}
					
					$pos1 = strrpos($rows['description'], " ");
					if ($pos1 !== false):
						$rows['description'] = substr($rows['description'], 0, $pos1);
					endif;
					$rows['description'] .= '...';
					
					if ($iter < $mid){
						$this->section .= '<article class="entry-item">
                                    <header class="clearfix">
                                        <a href="story-detail.php?title='.urlencode(str_replace (" ", "-", $rows['title'])).'&story='.$rows['id'].'"><img src="'.$rows['img'].'" class="responsive-img hover-img" alt="'.$rows['title'].'" /></a>
										<p><strong>'.date("d", strtotime($rows['article_date'])).' /</strong><span>'.date("F", strtotime($rows['article_date'])).' '.date("Y", strtotime($rows['article_date'])).'</span></p>
                                        <span class="entry-comments">'.$rows['social_score'].' Buzz <span>'.get_comm_no ($this->dblink, $rows['id']).' Comments</span></span>
                                    </header>
                                    <div class="entry-content">
                                        <h6 class="entry-title"><a href="story-detail.php?title='.urlencode(str_replace (" ", "-", $rows['title'])).'&story='.$rows['id'].'">'.ucfirst($rows['title']).'</a></h6>
                                        '.$rows['description'].'
                                        <a class="more-link" href="story-detail.php?title='.urlencode(str_replace (" ", "-", $rows['title'])).'&story='.$rows['id'].'">Learn more</a>
                                    </div><!--entry-content-->
                                </article>';
					} else {
						$this->section2 .= '<article class="entry-item">
                                    <header class="clearfix">
                                        <a href="story-detail.php?title='.urlencode(str_replace (" ", "-", $rows['title'])).'&story='.$rows['id'].'"><img src="'.$rows['img'].'" class="responsive-img hover-img" alt="'.$rows['title'].'" /></a>
                                        <p><strong>'.date("d", strtotime($rows['article_date'])).' /</strong><span>'.date("F", strtotime($rows['article_date'])).' '.date("Y", strtotime($rows['article_date'])).'</span></p>
                                        <span class="entry-comments">'.$rows['social_score'].' Buzz <span>'.get_comm_no ($this->dblink, $rows['id']).' Comments</span></span>
                                    </header>
                                    <div class="entry-content">
                                        <h6 class="entry-title"><a href="story-detail.php?title='.urlencode(str_replace (" ", "-", $rows['title'])).'&story='.$rows['id'].'">'.ucfirst($rows['title']).'</a></h6>
                                        '.$rows['description'].'
                                        <a class="more-link" href="story-detail.php?title='.urlencode(str_replace (" ", "-", $rows['title'])).'&story='.$rows['id'].'">Learn more</a>
                                    </div><!--entry-content-->
                                </article>';
					}
					
				  
				  $iter++;
			}
		endif;
	
	}
} // end class
?>