<?php
require_once '../includes/admin_sess.php';
//////////////////////////////////////////
$head_id = addslash($_GET['linkid']);
$sql = "SELECT url FROM headings WHERE id='$head_id' LIMIT 1";
$result = @mysqli_query($link, $sql);
$row=@mysqli_fetch_assoc($result);
header("Location: $row[url]");
?>