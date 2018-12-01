<?php
require_once '../includes/admin_sess.php';
///////////////////////////////////
require_once '../includes/addbulletin.inc';
///////////
function get_cat ($link){
	$sql = "SELECT * FROM category";
	$result = @mysqli_query($link, $sql);
	while ($rows=@mysqli_fetch_assoc($result)){
		echo "<option value=\"$rows[id]\">$rows[category]</option>";
	}
}

function get_bulletin ($link){
	$sql = "SELECT bulletin.id, bulletin.title, SUBSTRING(bulletin.description, 1, 400) AS description, bulletin.img, category.category FROM bulletin, category WHERE bulletin.category = category.id 
	ORDER BY storyDate DESC LIMIT 50";
	$result = @mysqli_query($link, $sql);
	
	while ($rows = @mysqli_fetch_assoc($result)){
		echo "<div class=\"bulbody\"><strong>$rows[title]</strong><br />".
		$rows['description']
		."<hr color=\"#000000\" /> <strong style=\"color:#FFFF00\">Category:</strong> $rows[category] <a href=\"../view_bulletin.php?id=$rows[id]\" target=\"_blank\">View</a> 
		| <a href=\"bulletin.php?edit=$rows[id]\">Edit</a></div>";
	}
}

function get_details ($link){
	$newsid = addslash ($_GET['edit']);
	$sql = "SELECT * FROM bulletin WHERE id='$newsid' LIMIT 1";
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
.success {
	font-size: 11px;
	color: #F00;
	font-weight: bold;
}
.bulletin {
	color: #090;
	font-size: 15px;
}
.bultxt {
	color: #FFF;
}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td class="bulletin">BULLETIN</td>
    <td width="292">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="bultxt"><?php get_bulletin ($link);?></td>
    <td align="left" valign="top"><?php
if (empty($news->success)):
?>
      <form action="bulletin.php" method="post" enctype="multipart/form-data" name="add" id="add">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="73">&nbsp;</td>
            <td width="300"><span class="style2">
              <?php
	  if (!empty($_GET['edit'])):
	  	echo "<strong>Edit:</strong> $news_det[title]";
	  else:
	  	echo "Add Bulletin";
	  endif;
	  ?>
            </span></td>
          </tr>
          <tr>
            <td align="right" valign="top"><span class="style1">Title</span></td>
            <td><label>
              <input name="title" type="text" class="boxwid" id="title" value="<?php if (!empty($news_det['title'])) { echo $news_det['title'];}?>" size="30" maxlength="100" />
            </label></td>
          </tr>
          <tr>
            <td align="right" valign="top"><span class="style1">Description</span></td>
            <td><label>
              <textarea name="description" cols="30" rows="5" class="boxwid" id="description"><?php if (!empty($news_det['description'])){ echo $news_det['description'];}?></textarea>
            </label></td>
          </tr>
          <tr>
            <td align="right" valign="top"><span class="style1">Category</span></td>
            <td><label>
              <select name="category" class="boxwid" id="category">
                <?php
		if (!empty($news_det['category'])):
			echo "<option value=\"$news_det[category]\">same category</option>";
		endif;
		
		echo get_cat($link); //Get other categories
		?>
              </select>
            </label>
              &nbsp;</td>
          </tr>
          <tr>
            <td align="right" valign="top" class="style1">Image</td>
            <td><label for="image"></label>
              <input name="image" type="file" class="boxwid" id="image" />
            <label>              </label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><label>
              <input name="newsid" type="hidden" id="newsid" value="<?php if (!empty($news_det['id'])){echo $news_det['id'];}?>" />
              <input type="submit" name="addnews" id="addnews" value="Add News" />
            </label></td>
          </tr>
        </table>
      </form>
      <?php
else:
?>
      <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td colspan="2" align="center" bgcolor="#FFFFFF" class="success">You have successfully Added/Edited one story</td>
        </tr>
        <tr>
          <td width="73" align="right" valign="top">&nbsp;</td>
          <td width="300"><label><span class="style4">What do you want to do?</span></label></td>
        </tr>
        <tr>
          <td align="right" valign="top"><span class="style1">Edit:</span></td>
          <td bgcolor="#00FF66"><a href="bulletin.php?edit=<?php echo $news->newsid;?>">Edit this story</a></td>
        </tr>
      </table>
    <?php
endif;
?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
