<?php
require_once '../includes/admin_sess.php';
//////////////////////////////////////////
function get_sources ($link){
	$sql = "SELECT * FROM sources";
	$result = @mysqli_query($link, $sql);
	$i=1;
	while ($rows=@mysqli_fetch_assoc($result)){
		$options .= "<option value=\"get-headers.php?source=$rows[id]&amp;paper=$rows[source]&amp;feed=$rows[feed]\">$rows[source]</option>\n";
		//set paper process values in session
		$c_url = 'page'.$i;
		$_SESSION[$c_url]="get-headers.php?autoprop=$i&amp;source=$rows[id]&amp;paper=$rows[source]";
		$i++;
	}
	$_SESSION['page'.$i]="get-headers.php";
	return $options;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Process Daily Paper</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	color: #FFFFFF;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_jumpMenuGo(objId,targ,restore){ //v9.0
  var selObj = null;  with (document) { 
  if (getElementById) selObj = getElementById(objId);
  if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0; }
}
//-->
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="#FFFFFF" class="allborder">
  <tr>
    <td><span class="style1">PROCESS DAILY NEWS</span></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      
      <tr>
        <td width="52%" align="center" valign="top"><form action="get-headers.php" method="post" name="pro_paper" target="paper_int" id="pro_paper">
          <label>
          <select name="selectpaper" id="selectpaper">
            <?php echo get_sources($link);?>
          </select>
          <input type="button" name="go_button" id= "go_button" value="Process Paper" onclick="MM_jumpMenuGo('selectpaper','paper_int',0)" />
          </label>
    <label></label>
        &nbsp;&nbsp;&nbsp;<a href="get-headers.php?autoprop=1" target="paper_int" style="color:#00FF00;"><strong>[Autoprocess All]</strong></a>
        </form>        </td>
        </tr>
      <tr>
        <td align="center" valign="top"><iframe width="400" height="200" id="paper_int" name="paper_int" frameborder="0"></iframe></td>
        </tr>
      <tr>
        <td align="center" valign="top"><a href="assign-links.php" style="color:#FFFF00;"><strong>&gt;&gt; STEP 2: Assign Links</strong></a></td>
        </tr>
      
    </table></td>
  </tr>
</table>
</body>
</html>
