<?php
function archives (){
	// print for today
	echo "<br /><a href=\"index.php\" class=\"archive\"><strong>Today</strong></a> <br />";
	
	$i=1;
	while ($i < 10){
		$pageday = date("l jS F, Y", strtotime("-$i day"));
		$urlday = date("Y_m_d", strtotime("-$i day"));
		echo "<br /><a href=\"archive.php?archive=$urlday\" class=\"archive\">$pageday</a> <br />";
		$i++;
	}
}
?>