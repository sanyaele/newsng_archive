<?php
class related {
	public $dblink;
	private $searchstring;
	public $rel;
	
	function __construct (){
		global $link;
		$this->dblink = $link;
	}	
	
	function fulltext ($string, $link){ // Do the default fulltext search on the database
		$this->searchstring = $string;

		$sql = "SELECT DISTINCT MATCH(title, description) Against ('$this->searchstring' IN BOOLEAN MODE) as score, id FROM articles WHERE MATCH(title, description) Against ('$this->searchstring' IN BOOLEAN MODE) ORDER BY score DESC LIMIT 10";
		$result = @mysqli_query($link, $sql);
		
		if (@mysqli_num_rows($result) > 0):
			while ($rows = @mysqli_fetch_assoc($result)){
				$this->rel[$rows['id']] = $rows['score'];
			}
			return TRUE;
		else:
			return FALSE;
		endif;
	}
	
	/////////////////////////////////////////////////////
	function altsearch ($string, $link, $limit="10"){
		$this->searchstring = split (" ",$string);
		
		// compile sql query ///////////////////////////////////////////
		$sql = "SELECT DISTINCT COUNT(*) As score, id FROM articles WHERE (";
		while(list($key,$val)=each($this->searchstring)){
		  if($val<>" " and strlen($val) > 0){
		  $sql .= "(title LIKE '%$val%' OR description LIKE '%$val%') OR";
		  }
		}
		$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
		$sql .= ") GROUP BY id ORDER BY score DESC LIMIT ".$limit;
		////////////////////////////////////////////////////////////////
		$result = @mysqli_query($link, $sql);
		if (@mysqli_num_rows($result) > 0):
			while ($rows = @mysqli_fetch_assoc($result)){
				$this->rel[$rows['id']] = $rows['score'];
			}
			return TRUE;
		else:
			return FALSE;
		endif;
	}
	
	function add2db ($artid, $link){
		foreach ($this->rel as $rel=>$score){
			$val .= "('".$artid."','".$rel."','".$score."'),";
			$val .= "('".$rel."','".$artid."','".$score."'),";
		}
		
		$val = substr($val, 0, (strlen($val)-1));
		
		$sql = "INSERT IGNORE INTO `related_articles` (`artId`, `relId`, `score`)
		VALUES ".$val;
		@mysqli_query($link, $sql);
	}
	
}
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
?>