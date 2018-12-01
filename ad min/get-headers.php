<?php
require_once '../includes/admin_sess.php';
//////////////////////////////////////////
require_once 'inc/process_reg.php';
///////////////////////////////////////
if (!empty($_GET['source'])):
	if ($_GET['paper'] == 'The Punch'):
		if (!empty($_GET['feed'])):
			$dpaper = new process;
			$mess = $dpaper->mess;
			$color = $dpaper->color;
		else:
			$dpaper = new process;
			$dpaper->punch_p();
			$mess = $dpaper->mess;
			$color = $dpaper->color;
		endif;
			
	elseif($_GET['paper'] == 'This Day'):
		if (!empty($_GET['feed'])):
			
		else:
			$dpaper = new process;
			$dpaper->thisday_p();
			$mess = $dpaper->mess;
			$color = $dpaper->color;
		endif;
			
	elseif($_GET['paper'] == 'Next'):
		if (!empty($_GET['feed'])):
			
		else:
			$dpaper = new process;
			$dpaper->next_p();
			$mess = $dpaper->mess;
			$color = $dpaper->color;
		endif;
			
	elseif($_GET['paper'] == 'Guardian'):
		if (!empty($_GET['feed'])):
			
		else:
			$dpaper = new process;
			$dpaper->guardian_p();
			$mess = $dpaper->mess;
			$color = $dpaper->color;
		endif;
			
	elseif($_GET['paper'] == 'Vanguard'):
		if (!empty($_GET['feed'])):
			
		else:
			$dpaper = new process;
			$dpaper->vanguard_p();
			$mess = $dpaper->mess;
			$color = $dpaper->color;
		endif;
			
	elseif($_GET['paper'] == 'Daily Independent'):
		if (!empty($_GET['feed'])):
			
		else:
			$dpaper = new process;
			$dpaper->independent_p();
			$mess = $dpaper->mess;
			$color = $dpaper->color;
		endif;
			
	elseif($_GET['paper'] == 'Daily Sun'):
		if (!empty($_GET['feed'])):
			
		else:
			$dpaper = new process;
			$dpaper->sun_p();
			$mess = $dpaper->mess;
			$color = $dpaper->color;
		endif;
			
	elseif($_GET['paper'] == 'Nigerian Tribune'):
		if (!empty($_GET['feed'])):
			
		else:
			$dpaper = new process;
			$dpaper->tribune_p();
			$mess = $dpaper->mess;
			$color = $dpaper->color;
		endif;
			
	elseif($_GET['paper'] == 'Business Day'):
		if (!empty($_GET['feed'])):
			
		else:
			$dpaper = new process;
			$dpaper->bday_p();
			$mess = $dpaper->mess;
			$color = $dpaper->color;
		endif;
			
	elseif($_GET['paper'] == 'The Nation'):
		if (!empty($_GET['feed'])):
			
		else:
			$dpaper = new process;
			$dpaper->nation_p();
			$mess = $dpaper->mess;
			$color = $dpaper->color;
		endif;
			
	elseif($_GET['paper'] == 'Daily Trust'):
		if (!empty($_GET['feed'])):
			
		else:
			$dpaper = new process;
			$dpaper->dtrust_p();
			$mess = $dpaper->mess;
			$color = $dpaper->color;
		endif;
			
	else:
		$mess = "We are currently not able to process this paper (<strong>$_GET[paper]</strong>)";
		$color = "#FF0000";
	endif;
endif; // endif for if (!empty($_GET['source'])):
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
if (!empty($_GET['autoprop'])):
	$curr = 'page'.$_GET['autoprop'];
	if (isset($_SESSION[$curr])):
		if (!empty($_GET['source']) && !empty($_GET['paper'])):
			$next_num=$_GET['autoprop']+1;
			$next = 'page'.$next_num;
			echo "<meta http-equiv=\"refresh\" content=\"30;URL=".$_SESSION[$next]."\" />";
		else:
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$_SESSION[$curr]."\" />";
		endif;
		
	endif;
endif;
?>
<title>Get headers</title>
<style type="text/css">
<!--
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
	background-color: <?php echo $color;?>;
}
-->
</style>
</head>

<body>

<?php 
echo $mess;
?>

</body>
</html>
