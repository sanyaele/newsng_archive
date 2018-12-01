<?php
require_once '../includes/admin_sess.php';
///////////////////////////////////
function add_link ($link){
	$url = addslash($_POST['url']);
	$newsid = addslash($_POST['newsid']);
	$sourceId = addslash($_POST['source']);
	///////////////////////////////////////
	$sql = "INSERT INTO links SET
	link = '$url',
	sourceId = '$sourceId',
	newsId = '$newsid'";
	@mysqli_query($link, $sql);
}

function del_link($link){
	$linkId = addslash($_GET['del']);
	$sql = "DELETE FROM links WHERE id='$linkId'";
	@mysqli_query($link, $sql);
}
/////////////////////////////////////////////
if (!empty($_POST['url']) && !empty($_POST['newsid']) && !empty($_POST['source'])):
	add_link($link);
elseif (!empty($_GET['del'])):
	del_link($link);
endif;
/////////////////////////////////////////////
require_once '../includes/showlinks.inc';
//////////////////////////////////////////////
$get_sources = new thelinks;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add and Remove News Links</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	color: #FFFF00;
}
.style2 {color: #FFFF00}
.style13 {color: #00FF00; font-size: 10px; }
.style14 {font-size: 10px}
-->
</style>
<script type="text/javascript">
<!--

function get_url(){
if(document.getElementById('source').value == ""){
document.getElementById('url').value = "";
}
<?php
echo $get_sources->jvscript;
?>
else{
document.getElementById('url').value = "";
}
}

//-->
</script>
</head>

<body>
<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#009900">
  <tr>
    <td width="323" align="left"><span class="style1"><strong>Sources for:</strong><br />
 <?php echo $get_sources->title;?></span></td>
  </tr>
  <tr>
    <td align="left"><form id="linkform" name="linkform" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td align="right"><span class="style13">Source</span></td>
          <td><select name="source" class="style14" id="source" onchange="get_url()">
            <?php echo $get_sources->options;?>
          </select></td>
          <td width="45%" rowspan="2" align="left" valign="bottom"><span class="style14">
            <input name="newsid" type="hidden" id="newsid" value="<?php echo $_GET['newsid']?>" />
            <input name="update" type="submit" class="style14" id="update" value="Add Link" />
          </span></td>
        </tr>
        <tr>
          <td width="15%" align="right"><span class="style13">URL</span></td>
          <td width="40%"><input name="url" type="text" class="style14" id="url" size="50" /></td>
          </tr>
      </table>
            </form>    </td>
  </tr>
  <tr>
    <td align="left"><span class="style14">
      <?php echo $get_sources->links;?>
    &nbsp;</span></td>
  </tr>
</table>
</body>
</html>
