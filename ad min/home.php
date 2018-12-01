<?php
require_once '../includes/admin_sess.php';
//////////////////////////////////////////
if (!empty($_GET['reset_date'])):
	$_SESSION['date'] = "";
	unset ($_SESSION['date']);
endif;
//////////////////////////////////////////
if (!empty($_POST['day']) && !empty($_POST['month']) && !empty($_POST['year'])):
	$_SESSION['date'] = addslash($_POST['year'])."-".addslash($_POST['month'])."-".addslash($_POST['day']);
endif;
//////////////////////////////////////////
if (isset($_POST['setwebdate'])):
	//set website date
	$db = $link;
	$sql = "UPDATE currdate SET currDate='".$_SESSION['date']."'";
	$result = @mysqli_query($db, $sql);
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Console</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style12 {	font-family: Tahoma;
	font-size: 12px;
}
.style11 {font-size: 9px;
	color: #0000FF;
}
.style14 {
	color: #FFFFFF;
	font-size: 14px;
	font-weight: bold;
}
.style15 {color: #FFFF00}
.style16 {
	color: #FF0000;
	font-weight: bold;
}
.style17 {
	font-size: 11px;
	font-family: Tahoma;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="../assets/new_logo2_back.gif"><img src="../assets/new_logo2.gif" alt="News In Nigeria" width="158" height="73" /></td>
  </tr>
  <tr>
    <td align="right" valign="top" bgcolor="#FFFFFF">
    <?php
	if ($_SESSION['type'] == 'global'):
	?>
    <a href="newsletter.php">Newsletter</a> | 
    <?php
	endif;
	?>
    <a href="?logoff=1">Sign-out</a>
    
    </td>
  </tr>
  <tr>
    <td>
    <?php
	if (empty($_SESSION['date'])):
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="25%" align="center">&nbsp;</td>
        <td width="50%" align="center"><span class="style14">Select a Publication Date</span></td>
        <td width="25%" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center" bgcolor="#99FF66"><form id="archives" name="archives" method="post" action="home.php">
            <span class="style11">Day:
              <select name="day" class="style12" id="day">
              <option selected="selected" value="<?php echo date("d",time()); ?>"><?php echo date("d",time()); ?></option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
            </select>
              Month:
              <select name="month" class="style12" id="month">
                <option selected="selected" value="<?php echo date("m",time()); ?>"><?php echo date("m",time()); ?></option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
              Year:
              <label>
                <select name="year" class="style12" id="year">
                  <option selected="selected" value="<?php echo $this_yr = date("Y",time()); ?>"><?php echo date("Y",time()); ?></option>
                  <?php
				  $yr_i = 1;
				  while ($yr_i < 10){
					  $this_yr--;
					  echo '<option value="'.$this_yr.'">'.$this_yr.'</option>\n';
					  $yr_i++;
				  }
				  ?>
                </select> 
              </label>
              <label>
                <input name="go" type="submit" class="style12" id="go" value="SET" />
              </label>
            </span>
        </form></td>
        <td align="center">&nbsp;</td>
      </tr>
    </table>
    
    <?php
	else:
	?>
    <table width="100%" border="0" cellpadding="5" cellspacing="0">
      
      <tr>
        <td colspan="2" align="right" valign="top"><form action="home.php" method="post" name="webdate" class="style15" id="webdate">
          Current Publication date: <span class="style16"><?php echo $_SESSION['date']; ?></span> 
                       <label>
                       <?php
	if ($_SESSION['type'] == 'global'):
	?>
                       <input type="submit" name="setwebdate" id="setwebdate" value="Set As Website Date" />
                       <?php
	endif;
	?> 
                       <a href="?reset_date=1"><img src="../assets/reset.gif" alt="Reset Date" width="25" height="25" border="0" align="absbottom" /></a>                       </label>
        </form></td>
        </tr>
      <tr>
        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF"><span class="style17"><a href="bulletin.php" target="articles">Add Bulletin</a> | <a href="stories.php" target="articles">View  Articles</a>
            <?php
	if ($_SESSION['type'] == 'global'):
	?>
| <a href="edit_sources.php" target="addedit">Edit Sources</a>
          <?php
	endif;
	?>
        </span></td>
      </tr>
      <tr>
        <td align="left" valign="top"><iframe name="articles" id="articles" width="100%" height="500" frameborder="0" src="stories.php"></iframe></td>
        <td width="450" align="left" valign="top"><iframe name="addedit" id="addedit" width="100%" height="500" frameborder="0" src=""></iframe></td>
        </tr>
      <tr>
        <td align="left" valign="top"><span class="style1">&copy;Copyright 2009 - 2012 <a href="http://www.goldensteps.com.ng">GoldenSteps Enterprises</a>. All Rights Reserved.</span></td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table>
    <?php
	endif;
	?>    </td>
  </tr>
</table>
</body>
</html>
