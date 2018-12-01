<?php
$photourl = "http://images.google.com?l=eng&imgurl=http://www.newsng.com/looks.gif&c=ng";
if (preg_match("/imgurl=(.*(.jpg|.gif|.png){1})/",$photourl,$photoarray)):
	foreach ($photoarray as $key=>$value){
		if ($key=='1'):
			$photo = $value;
			echo $key .": ".$photo;
		endif;
	}
else:
	$photo = substr(addslash($photourl),0,300);
endif;

echo "<br /> Final is $photo";
?>