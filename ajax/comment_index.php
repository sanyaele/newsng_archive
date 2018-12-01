<?php
require_once '../includes/db.php';
require_once '../includes/common.php';
///////////////////////////////////
class addcomment {
	public $id;
	private $name;
	private $email;
	private $comment;
	public $comments;
	public $rate;
	
	function __construct(){
		global $link;
		$this->id = addslash ($_GET['news_id']);
		$this->get_news_detail($link);
	}
	
	function clean (){
		$this->name = $_SESSION['name'] = addslash ($_GET['name']);
		$this->email = $_SESSION['email'] = addslash ($_GET['email']);
		$this->comment = addslash ($_GET['comment']);
	}
	
	function add ($link){
		$sql = "INSERT INTO comments SET
		name = '$this->name',
		email = '$this->email',
		comment = '$this->comment',
		newsId = '$this->id'";
		
		if (@mysqli_query($link, $sql)):
			return TRUE;
		else:
			return FALSE;
		endif;
	}
	
	function get_news_detail ($link){
		$sql = "SELECT `social_score` FROM articles WHERE id = '$this->id' LIMIT 1";
		$result = @mysqli_query($link, $sql);
		$row = @mysqli_fetch_assoc($result);
		$this->rate = $row['social_score'];
	}
	
	function get ($link){
		$sql = "SELECT * FROM comments WHERE newsId = '$this->id' ORDER BY `timestamp` DESC";
		$result = @mysqli_query($link, $sql);
		while ($rows = @mysqli_fetch_assoc($result)){
			$formated_date = date ("D jS F, Y",strtotime($rows['timestamp']));
			$this->comments .= "<div class=\"ind_comment\">
			<span style='font-size: 10px; color: #000099;'><strong>$rows[name]</strong> &nbsp;&nbsp;&nbsp;&nbsp; </span><span style='font-size: 10px; color: #666666; font-family: Tahoma, Verdana;'>[ $formated_date ]</span>
			<p>$rows[comment]</p>
			</div>";
		
		}
		
	}
	
	function get_comm_no ($link){
		$sql = "SELECT COUNT(1) AS num FROM comments WHERE newsId = '$this->id'";
		$result = @mysqli_query($link, $sql);
		$row = @mysqli_fetch_assoc($result);
		return $row['num'];
	}
}
/////////////////////////////////////////////////////////////////////////////////
$addcomm = new addcomment;

// Add to comment if fields not empty
if (!empty($_GET['name']) && !empty($_GET['email']) && !empty($_GET['comment']) && $_GET['comment'] != "Your comment here ..."):
	$addcomm->clean();
	$addcomm->add($link);
endif;

// show comments
$addcomm->get($link);
?>
<table width="315" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="commentlink"><span id="showcommentlink_<?php echo $addcomm->id;?>" class="showlink" onclick="showhidecomment('<?php echo $addcomm->id;?>')"> <?php echo $addcomm->get_comm_no($link);?> Comments [+/-]</span></td>
        </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <div id="comment_div_<?php echo $addcomm->id;?>" style="display:inline;">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="3" bordercolor="#99FF00" class="comment">
      <tr>
        <td><?php echo $addcomm->comments;?> </td>
      </tr>
      <tr>
        <td bordercolor="#CCCCCC"><table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#ECE9D8" class="allborder">
            <tr>
              <td align="center"><textarea name="comment_<?php echo $addcomm->id;?>" rows="2" class="comment_text" id="comment_<?php echo $addcomm->id;?>" onfocus="clear_textbox('comment_<?php echo $addcomm->id;?>')" onkeyup="countchars('comment_<?php echo $addcomm->id;?>','charscount_<?php echo $addcomm->id;?>')" onclick="show_name_email('name_email_<?php echo $addcomm->id;?>')" style="width:223;">Your comment here ...</textarea></td>
            </tr>
            <tr>
              <td align="center">
              <div id="name_email_<?php echo $addcomm->id;?>" style="display:none;">
              <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr bordercolor="#009900">
                    <td width="50%" align="left">Name
                      <input name="name" type="text" class="comment" id="name_<?php echo $addcomm->id;?>" size="15" value="<?php echo $_SESSION['name'];?>" /></td>
                    <td width="50%" align="right">Email
                      <input name="email" type="text" class="comment" id="email_<?php echo $addcomm->id;?>" size="15" value="<?php echo $_SESSION['email'];?>" /></td>
                  </tr>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr>
                    <td width="41%" align="left"><span class="style6">Max 500 characters</span></td>
                    <td width="13%" align="right" class="style5"><div id="charscount_<?php echo $addcomm->id;?>">0</div></td>
                    <td width="12%" align="left" class="style5">chars</td>
                    <td width="34%" align="right" class="style5"><img src="assets/add_comment_sm.gif" alt="Add a comment" width="94" height="20" border="0" style="cursor:pointer" onclick="put_comment('<?php echo $addcomm->id;?>')" /></td>
                  </tr>
              </table>
              </div>
              </td>
            </tr>
        </table></td>
      </tr>
    </table>
    </div>
    </td>
  </tr>
</table>
