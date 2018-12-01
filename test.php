<?php
require_once 'includes/db.php';

require_once 'includes/common.php';
////////////////////////////////
require_once 'includes/functions2.php';
require_once 'includes/highlight_test.php';
							$new_news = new get_news("Health");
							echo $new_news->html;
?>