<?php
//////////////////////////////////
# define variables
$mail_box = '{mail.newsng.com:143/novalidate-cert}'; //imap example
$mail_user = 'admin+newsng.com'; //mail username
$mail_pass = 'tummymouse'; //mail password

# connect to mailbox
$conn = imap_open ($mail_box, $mail_user, $mail_pass) or die(imap_last_error());
$num_msgs = imap_num_msg($conn);

for ($n=1;$n<=$num_msgs;$n++) {
	imap_delete($conn, $n);
} //for loop

# delete messages
imap_expunge($conn);

# close
imap_close($conn);

?>