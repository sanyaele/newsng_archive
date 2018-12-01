<?php
require_once '../includes/admin_sess.php';
require_once '../includes/functions.php';
//////////////////////////////////////////


function addsource ($link,$source,$url,$rss,$cat){
	$source = addslash($source);
	$url = addslash($url);
	$rss = addslash($rss);
	$catId = substr($cat, 0, 1);
	
	$sql = "INSERT INTO sources SET
	source = '$source',
	url = '$url',
	rss = '$rss',
	catId = '$catId'";
	if (@mysqli_query($link,$sql)):
		return "<strong>$source</strong> was successfully added";
	else:
		return "There was a problem adding <strong>$source</strong>";
	endif;
}

function delsource ($link,$id){
	$id = addslash($id);
	$sql = "DELETE FROM sources WHERE id = '$id' LIMIT 1";
	if (@mysqli_query($link,$sql)):
		return "Source has been successfully deleted";
	else:
		return "There was a problem deleting specified source";
	endif;
}

if (!empty($_POST['source'])):
	$mess = addsource ($link,$_POST['source'],$_POST['url'],$_POST['rss'],$_POST['category']);
endif;

if (!empty($_GET['del'])):
	$mess = delsource ($link,$_GET['del']);
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Sources</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {
	color: #FFFFFF;
	font-size: 11;
}
.style3 {
	font-size: 14px;
	color: #FFFF00;
	font-weight: bold;
}
.style4 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><span class="style4"><?php if (!empty($mess)){echo $mess;}?></span></td>
  </tr>
  
  
  <tr>
    <td><form id="sources" name="sources" method="post" action="">
      <table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#009900">
        <tr>
          <td colspan="2" align="center"><span class="style3">Add New Source</span></td>
          </tr>
        <tr>
          <td width="50%" align="right"><span class="style2">Name</span></td>
          <td width="50%"><label>
            <input name="source" type="text" id="source" size="30" />
          </label></td>
        </tr>
        <tr>
          <td align="right"><span class="style2">URL</span></td>
          <td><label>
            <input name="url" type="text" id="url" size="30" />
          </label></td>
        </tr>
        <tr>
          <td align="right"><span class="style2"><label for="rss">RSS</label></span></td>
          <td>
            <input name="rss" type="text" id="rss" size="30" /></td>
        </tr>
        <tr>
          <td align="right"><span class="style2"><label for="category">Category</label></span></td>
          <td>
            <select name="category" id="category">
              <?php get_cat($link); ?>
            </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><label>
            <input type="submit" name="addsource" id="addsource" value="Add Source" />
          </label></td>
        </tr>
      </table>
    </form>    </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0" class="style2">
      <tr>
        <td align="center" class="style3">Current Sources</td>
      </tr>
      <?php
	  get_sources ($link);
	  ?>
    </table></td>
  </tr>
</table>
</body>
</html>
