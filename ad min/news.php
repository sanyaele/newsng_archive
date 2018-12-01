<?php
require_once '../includes/admin_sess.php';
///////////////////////////////////
require_once '../includes/addnews.inc';
///////////
function get_cat ($link){
	$sql = "SELECT * FROM category";
	$result = @mysqli_query($link, $sql);
	while ($rows=@mysqli_fetch_assoc($result)){
		echo "<option value=\"$rows[id]\">$rows[category]</option>";
	}
}
///////////
function get_details ($link){
	$newsid = addslash ($_GET['edit']);
	$sql = "SELECT * FROM articles WHERE id='$newsid' LIMIT 1";
	//echo $sql;
	$result = @mysqli_query($link, $sql);
	$row = @mysqli_fetch_assoc($result);
	return ($row);
}
///////////
if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['category'])):
	$news = new add;
elseif(!empty($_GET['edit'])):
	$news_det = get_details($link);
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add News</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #00FF00}
.style2 {
	font-size: 14px;
	color: #FFFFFF;
}
.style4 {color: #00FF00; font-weight: bold; }
-->
</style>
</head>

<body>
<?php
if (!$news->success):
?>
<form id="add" name="add" method="post" action="news.php">
  <table width="393" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td width="73">&nbsp;</td>
      <td width="300"><span class="style2">
      <?php
	  if (!empty($_GET['edit'])):
	  	echo "<strong>Edit:</strong> $news_det[title]";
	  else:
	  	echo "Add News";
	  endif;
	  ?>
      </span></td>
    </tr>
    <tr>
      <td align="right" valign="top"><span class="style1">Title</span></td>
      <td><label>
        <input name="title" type="text" id="title" value="<?php echo $news_det['title'];?>" size="50" maxlength="100" />
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top"><span class="style1">Description</span></td>
      <td><label>
        <textarea name="description" id="description" cols="40" rows="5"><?php echo $news_det['description'];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top"><span class="style1">Category</span></td>
      <td><label>
        <select name="category" id="category">
        <?php
		if (!empty($news_det['catId'])):
			echo "<option value=\"$news_det[catId]\">same category</option>";
		endif;
		?>
        <?php echo get_cat($link); ?>
        </select>
      </label>
      &nbsp;</td>
    </tr>
    <tr>
      <td align="right" valign="top" class="style1">Image</td>
      <td><label>
        <input name="photo" type="text" id="photo" value="<?php echo $news_det['img'];?>" size="50" maxlength="300" />
      </label></td>
    </tr>
    <tr>
      <td class="bulbody"><a href="<?php echo $news_det['url'];?>" target="_blank" style="color:#FF0;">Open News</a></td>
      <td align="right"><label>
        <input name="newsid" type="hidden" id="newsid" value="<?php echo $news_det['id'];?>" />
        <input type="submit" name="addnews" id="addnews" value="Add News" />
      </label></td>
    </tr>
  </table>
</form>
<?php
else:
?>
<table width="393" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="73" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="300" bgcolor="#FFFFFF">You have successfully Added/Edited one story</td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td><label><span class="style4">What do you want to do?</span></label></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="style1">Links:</span></td>
    <td bgcolor="#00FF66"><a href="links.php?newsid=<?php echo $news->newsid;?>">Create Links to this story</a></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="style1">Add:</span></td>
    <td bgcolor="#00FF66"><a href="news.php">Add another news story</a></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="style1">Edit:</span></td>
    <td bgcolor="#00FF66"><a href="news.php?edit=<?php echo $news->newsid;?>">Edit this story</a></td>
  </tr>
</table>
<?php
endif;
?>
</body>
</html>
