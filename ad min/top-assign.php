<?php
require_once '../includes/admin_sess.php';
//////////////////////////////////////////
require_once '../includes/addnews.inc';
//////////////////////////////////////////
function get_cat ($link){
	$sql = "SELECT * FROM category";
	$result = @mysqli_query($link, $sql);
	while ($rows=@mysqli_fetch_assoc($result)){
		echo "<option value=\"$rows[id]\">$rows[category]</option>";
	}
}

//////////////////////////
function add_link ($link,$newsid){
	// Get Punch link
	if (!empty($_POST['punch'])):
		$links .= "('".addslash($_POST['punch'])."','1','$newsid'),";
	endif;
	
	// Get Thisday link
	if (!empty($_POST['thisday'])):
		$links .= "('".addslash($_POST['thisday'])."','18','$newsid'),";
	endif;
	
	// Get Vanguard link
	if (!empty($_POST['vanguard'])):
		$links .= "('".addslash($_POST['vanguard'])."','19','$newsid'),";
	endif;
	
	// Get Guardian link
	if (!empty($_POST['guardian'])):
		$links .= "('".addslash($_POST['guardian'])."','9','$newsid'),";
	endif;
	
	// Get 234 Next link
	if (!empty($_POST['next'])):
		$links .= "('".addslash($_POST['next'])."','13','$newsid'),";
	endif;
	
	// Get Sun News link
	if (!empty($_POST['sunnews'])):
		$links .= "('".addslash($_POST['sunnews'])."','16','$newsid'),";
	endif;
	
	// Get Other link
	if (!empty($_POST['other'])):
		$links .= "('".addslash($_POST['other'])."','20','$newsid')";
	endif;
	
	///////////////////////////////
	// Save Info
	$sql = "INSERT INTO links (link, sourceId, newsId)
	VALUES
	$links";
	if (@mysqli_query($link, $sql)):
		return 1;
	else:
		return 0;
	endif;
}
///////////////////////////////////////////////
function update_head ($link){
	$sql = "UPDATE topstories SET used = '1' WHERE heading = '$_POST[getvalue]' AND article_date = '".date("Y-m-d")."' LIMIT 1";
	@mysqli_query($link, $sql);
}
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['category'])):
	$news = new add;
	if ($news->success):
		$newsid = $news->get_id($link);
		if (add_link($link,$newsid)):
			update_head($link);
		endif;
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
.style10 {color: #FFFFFF; font-weight: bold; font-family: Tahoma, Verdana; }
-->
</style>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  search_term = document.getElementById('title').value;
  theURL = 'http://images.google.com.ng/images?hl=en&q='+search_term;
  window.open(theURL,winName,features);
}
function MM_custopenBrWindow(tBox,tSite,winName,features) { //v2.0
  setRO(0,tBox);
  search_term = document.getElementById('title').value;
  theURL = 'http://www.google.com.ng/search?q='+search_term+' site:'+tSite+'&tbs=qdr:w';
  window.open(theURL,winName,features);
}
function setRO(bool,box) {
   if(bool) {
      document.getElementById(box).readOnly = true;
	  document.getElementById(box).style.backgroundColor = 'white';
   }
   else {
      document.getElementById(box).readOnly = false;
	  document.getElementById(box).style.backgroundColor = 'yellow';
   }
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
    <tr>
      <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="133" align="right" valign="middle"><span class="style1">Title:</span></td>
          <td width="606" align="left"><input name="title" type="text" id="title" value="<?php echo $_GET['topic'];?>" size="30" maxlength="100" /></td>
        </tr>
        <tr>
          <td align="right" valign="middle" bgcolor="#003300"><span class="style10">The Punch</span></td>
          <td align="left" valign="middle" bgcolor="#003300"><label>
            <input name="punch" type="text" id="punch" size="30" readonly="readonly" onchange="setRO(1,'punch')" />
            <img src="../assets/search.gif" alt="Search on punch" width="55" height="18" border="0" align="absmiddle" onclick="MM_custopenBrWindow('punch','punchng.com','addedit','toolbar=yes,status=yes,scrollbars=yes,resizable=yes,width=500,height=500')" /><a href="http://www.punchng.com/" target="addedit"><img src="../assets/visit.gif" alt="Visit Punch" width="72" height="18" border="0" align="absmiddle" onclick="setRO(0,'punch')" /></a></label></td>
        </tr>
        <tr>
          <td align="right" valign="middle" bgcolor="#003300"><span class="style10">Thisday</span></td>
          <td align="left" valign="middle" bgcolor="#003300"><label>
            <input name="thisday" type="text" id="thisday" size="30" readonly="readonly" onchange="setRO(1,'thisday')" />
            <img src="../assets/search.gif" alt="Search on Thisday" width="55" height="18" border="0" align="absmiddle" onclick="MM_custopenBrWindow('thisday','thisdayonline.com','addedit','toolbar=yes,status=yes,scrollbars=yes,resizable=yes,width=500,height=500')" /><a href="http://www.thisdayonline.com/" target="addedit"><img src="../assets/visit.gif" alt="Visit Thisday" width="72" height="18" border="0" align="absmiddle" onclick="setRO(0,'thisday')" /></a></label></td>
        </tr>
        <tr>
          <td align="right" valign="middle" bgcolor="#003300"><span class="style10">Vanguard</span></td>
          <td align="left" valign="middle" bgcolor="#003300"><label>
            <input name="vanguard" type="text" id="vanguard" size="30" readonly="readonly" onchange="setRO(1,'vanguard')" />
            <img src="../assets/search.gif" alt="Search on Vanguard" width="55" height="18" border="0" align="absmiddle" onclick="MM_custopenBrWindow('vanguard','vanguardngr.com','addedit','toolbar=yes,status=yes,scrollbars=yes,resizable=yes,width=500,height=500')" /><a href="http://www.vanguardngr.com/" target="addedit"><img src="../assets/visit.gif" alt="Visit Vanguard" width="72" height="18" border="0" align="absmiddle" onclick="setRO(0,'vanguard')" /></a></label></td>
        </tr>
        <tr>
          <td align="right" valign="middle" bgcolor="#003300"><span class="style10">Guardian</span></td>
          <td align="left" valign="middle" bgcolor="#003300"><label>
            <input name="guardian" type="text" id="guardian" size="30" readonly="readonly" onchange="setRO(1,'guardian')" />
            <img src="../assets/search.gif" alt="Search on Guardian" width="55" height="18" border="0" align="absmiddle" onclick="MM_custopenBrWindow('guardian','ngrguardiannews.com','addedit','toolbar=yes,status=yes,scrollbars=yes,resizable=yes,width=500,height=500')" /><a href="http://www.ngrguardiannews.com/" target="addedit"><img src="../assets/visit.gif" alt="Visit Guardian" width="72" height="18" border="0" align="absmiddle" onclick="setRO(0,'guardian')" /></a></label></td>
        </tr>
        <tr>
          <td align="right" valign="middle" bgcolor="#003300"><span class="style10">234 Next</span></td>
          <td align="left" valign="middle" bgcolor="#003300"><label>
            <input name="next" type="text" id="next" size="30" readonly="readonly" onchange="setRO(1,'next')" />
            <img src="../assets/search.gif" alt="Search on 234Next" width="55" height="18" border="0" align="absmiddle" onclick="MM_custopenBrWindow('next','234next.com','addedit','toolbar=yes,status=yes,scrollbars=yes,resizable=yes,width=500,height=500')" /><a href="http://www.234next.com/" target="addedit"><img src="../assets/visit.gif" alt="Visit 234Next" width="72" height="18" border="0" align="absmiddle" onclick="setRO(0,'next')" /></a></label></td>
        </tr>
        <tr>
          <td align="right" valign="middle" bgcolor="#003300"><span class="style10">Sun News</span></td>
          <td align="left" valign="middle" bgcolor="#003300"><label>
            <input name="sunnews" type="text" id="sunnews" size="30" readonly="readonly" onchange="setRO(1,'sunnews')" />
            <img src="../assets/search.gif" alt="Search on Sun News" width="55" height="18" border="0" align="absmiddle" onclick="MM_custopenBrWindow('sunnews','sunnewsonline.com','addedit','toolbar=yes,status=yes,scrollbars=yes,resizable=yes,width=500,height=500')" /><a href="http://www.sunnewsonline.com/" target="addedit"><img src="../assets/visit.gif" alt="Visit Sun News Online" width="72" height="18" border="0" align="absmiddle" onclick="setRO(0,'sunnews')" /></a></label></td>
        </tr>
        <tr>
          <td align="right" valign="middle" bgcolor="#003300"><span class="style10">Other</span></td>
          <td align="left" valign="middle" bgcolor="#003300"><label>
            <input name="other" type="text" id="other" size="30" readonly="readonly" onchange="setRO(1,'other')" />
            <img src="../assets/search.gif" alt="Search on Google" width="55" height="18" border="0" align="absmiddle" onclick="MM_custopenBrWindow('other','','addedit','toolbar=yes,status=yes,scrollbars=yes,resizable=yes,width=500,height=500')" /></label></td>
        </tr>
        <tr>
          <td align="right" valign="top"><p class="style1">Description:</p></td>
          <td align="left"><textarea name="description" id="description" cols="25" rows="5"></textarea></td>
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
            <input name="photo" type="text" id="photo" size="30" maxlength="300" />
            <img src="../assets/get_img.gif" alt="Search Image In Google" width="130" height="19" border="1" align="absmiddle" onclick="MM_openBrWindow('','addedit','toolbar=yes,status=yes,scrollbars=yes,resizable=yes,width=500,height=500')" /></label></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center"><label>
        <input name="getvalue" type="hidden" id="getvalue" value="<?php echo $_GET['topic'];?>" />
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
      <td height="150" align="center" valign="middle"><span class="style5">You  have successfully added one Article, <a href="topstories.php" style="color:#FFFFFF; text-decoration:none;"><strong>+add another</strong></a></span></td>
    </tr>
  </table>
  <?php endif;?>
</body>
</html>
