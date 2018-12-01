<?php
require_once '../includes/db.php';
//////////////////////////////////
function remove_email_newsng ($link, $email){
	$sql = "DELETE FROM `mailing_list` WHERE `email` = '$email' LIMIT 1";
	@mysqli_query($link, $sql);
}
//////////////////////////////////
# define variables
$mail_box = '{mail.newsng.com:143/novalidate-cert}'; //imap example
$mail_user = 'admin@newsng.com'; //mail username
$mail_pass = 'tummymouse'; //mail password
$delete = '2'; //deletes emails with at least this number of failures

# connect to mailbox
$conn = imap_open ($mail_box, $mail_user, $mail_pass) or die(imap_last_error());
$num_msgs = imap_num_msg($conn);

# start bounce class
require_once('bounce_driver.class.php');
$bouncehandler = new Bouncehandler();

# get the failures
$email_addresses = array();
$delete_addresses = array();
  for ($n=1;$n<=$num_msgs;$n++) {
  $bounce = imap_fetchheader($conn, $n).imap_body($conn, $n); //entire message
  $multiArray = $bouncehandler->get_the_facts($bounce);
    if (!empty($multiArray[0]['action']) && !empty($multiArray[0]['status']) && !empty($multiArray[0]['recipient']) ) {
      if ($multiArray[0]['action']=='failed') {
      $email_addresses[$multiArray[0]['recipient']]++; //increment number of failures
      $delete_addresses[$multiArray[0]['recipient']][] = $n; //add message to delete array
      } //if delivery failed
    } //if passed parsing as bounce
  } //for loop

# process the failures
  foreach ($email_addresses as $key => $value) { //trim($key) is email address, $value is number of failures
    if ($value>=$delete) {
    /*
    do whatever you need to do here, e.g. unsubscribe email address
    */
	remove_email_newsng ($link, trim($key));
    # mark for deletion
      foreach ($delete_addresses[$key] as $delnum) imap_delete($conn, $delnum);
    } //if failed more than $delete times
  } //foreach

# delete messages
imap_expunge($conn);

# close
imap_close($conn);

?>