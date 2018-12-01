<?php
require_once '../includes/admin_sess.php';
//////////////////////////////////////////
require_once '../includes/addnews.inc';
require_once '../includes/functions.php';
//////////////////////////////////////////
function get_titles ($link){
	//get today's date
	$currdate = date("Y-m-d");
	
	$sql = "SELECT headings.id, IF (CHAR_LENGTH(headings.heading) > 75, CONCAT(SUBSTR(headings.heading,1,75),'...'), headings.heading) AS heading, sources.source
	FROM headings, sources
	WHERE headings.sourceId = sources.id
	AND headings.article_date = '$currdate'
	AND headings.used = '0'
	ORDER BY heading ASC";
	
	$result = @mysqli_query($link, $sql);
	if (@mysqli_num_rows($result)>0):
		while ($rows=@mysqli_fetch_assoc($result)){
			$list[$rows['source']][$rows['id']]=$rows['heading'];
		}
		
		$i=1;
		foreach ($list as $key=>$value){
			echo "
			<tr>
				<td>
					<strong style=\"color:#00FF00\">$key</strong><br />
					<select name=\"paper".$i."[]\" size=\"10\" multiple=\"multiple\" id=\"paper".$i."[]\">
			";
			
			foreach ($value as $id=>$title){
				echo "<option value=\"$id\" ondblclick=\"openLink('$id','addedit','toolbar=yes,status=yes,scrollbars=yes,resizable=yes,width=500,height=500')\">$title</option>\n";
			}
			
			echo "
					</select>
				</td>
			</tr>
			";
			$i++;
		}
	else:
			echo "
			<tr>
				<td bgcolor=\"#FFFFFF\">
					<strong style=\"color:#FF0000\">There are no articles processed for today</strong>
				</td>
			</tr>
			";
	endif;
}

/////////////////////////


/////////////////////////
function source_num ($link){
	$sql = "SELECT COUNT( DISTINCT sourceId ) AS num FROM headings WHERE article_date='".date("Y-m-d")."'";
	$result = @mysqli_query($link, $sql);
	$row=@mysqli_fetch_assoc($result);
	return $row['num'];
}

//////////////////////////
function add_link ($link,$head_id,$newsid){
	// Get info from headings
	$dlink = $link;
	$sql = "SELECT sourceId, url FROM headings WHERE id='$head_id' LIMIT 1";
	$result = @mysqli_query($link, $sql);
	$row=@mysqli_fetch_assoc($result);
	
	
	$url = $row['url'];
	$sourceId = $row['sourceId'];
	///////////////////////////////
	// Save Info
	$sql = "INSERT INTO links SET
	link = '$url',
	sourceId = '$sourceId',
	newsId = '$newsid'";
	if (@mysqli_query($dlink, $sql)):
		return 1;
	else:
		return 0;
	endif;
}
///////////////////////////////////////////////
function update_head ($link, $headid){
	$sql = "UPDATE headings SET used = '1' WHERE id = '$headid' LIMIT 1";
	@mysqli_query($link, $sql);
}
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['category'])):
	$news = new add;
	if ($news->success):
		$newsid = $news->get_id($link);
		
		$i=1;
		$total = source_num($link);
		while ($total >= $i){
			$paper = 'paper'.$i;
			if (!empty($_POST[$paper])):
				foreach ($_POST[$paper] as $head_id){
					//echo "$head_id => $newsid<br />";
					
					if (add_link($link,$head_id,$newsid)):
						update_head($link,$head_id);
					endif;
				}
			endif;
			
			$i++;
		}
		//exit();
	endif;
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Assign links to Story</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #CCCCCC;
	font-weight: bold;
}
.style5 {
	font-size: 16px;
	color: #FFFF00;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  search_term = document.getElementById('title').value;
  theURL = 'http://images.google.com.ng/images?hl=en&q='+search_term;
  window.open(theURL,winName,features);
}

function openLink(linkId,winName,features) {
	theURL = 'openlink.php?linkid='+linkId;
	window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
<?php
if (!$news->success):
?>
<form id="assign" name="assign" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <?php get_titles($link);?>
    <tr>
      <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="100" align="right" valign="middle"><span class="style1">Title:</span></td>
          <td align="left"><input name="title" type="text" id="title" size="50" maxlength="100" /></td>
        </tr>
        <tr>
          <td align="right" valign="top"><p class="style1">Description:</p></td>
          <td align="left"><textarea name="description" id="description" cols="40" rows="5"></textarea></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="style1">Category:</span></td>
          <td align="left"><select name="category" id="category">
              <?php get_cat($link); ?>
          </select></td>
        </tr>
        <tr>
          <td align="right" valign="middle" class="style1">Image:</td>
          <td align="left" valign="middle"><label>
            <input name="photo" type="text" id="photo" size="50" maxlength="300" />
            <img src="../assets/get_img.gif" alt="Search Image In Google" width="130" height="19" border="1" align="absmiddle" onclick="MM_openBrWindow('','addedit','toolbar=yes,status=yes,scrollbars=yes,resizable=yes,width=500,height=500')" /></label></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center"><label>
        <input type="submit" name="add" id="add" value="Add Article" />
      </label></td>
    </tr>
  </table>
  
</form>
<?php
else:
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="150" align="center" valign="middle"><span class="style5">You  have successfully added one Article, <a href="assign-links.php" style="color:#FFFFFF; text-decoration:none;"><strong>+add another</strong></a></span></td>
    </tr>
  </table>
  <?php endif;?>
</body>
</html>
