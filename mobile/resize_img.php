<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             resize offsite image
| category:         image handling
|
| last modified:    Fri, 01 Jul 2005 22:39:17 GMT
| downloaded:       Sun, 23 Jan 2011 20:15:05 GMT as copy from textarea
|
| code URL:
| http://phparadise.de/php-code/image-handling/resize-offsite-image/
|
| description:
| grabs an image of another server and displays a resized version. you can easily
| make and save thumbnails from remote images this way. if you use this to just
| display the image, make sure there is NO output before this script, no
| blankspace, no nothing or you'll get a "headers already sent" error !
|
------------------------------------------------------------------------------*/
// Custom script
if (empty($_GET['imgpath']) || empty($_GET['h_size'])):
	exit();
endif;

//////////////////////////////

// make sure there is NO output before this script, no blankspace, no nothing
// or you'll get a "headers already sent" error

// the image from another site
$off_site = $_GET['imgpath'];

// save thumbnail or display resized image.
// leave blank to just show image
// otherwise specify the path and name where the thumbnai is saved
$savethumb = '';

// read binary stream
$fp = fopen($off_site, 'rb') or die('Unable to open file '.$off_site.' for reading');
$buf = '';
while(!feof($fp))
{
	$buf .= fgets($fp, 4096);
}
fclose($fp);

$data = $buf;

//set new height
$size = $_GET['h_size'];
$src = imagecreatefromstring($data);
$width = imagesx($src);
$height = imagesy($src);
$aspect_ratio = $height/$width;

//start resizing
if($height <= $size)
{
	$new_w = $width;
	$new_h = $height;
}else{
	$new_h = $size;
	$new_w = abs($new_h / $aspect_ratio);
}

$img = imagecreatetruecolor($new_w,$new_h);

//output image
imagecopyresampled($img,$src,0,0,0,0,$new_w,$new_h,$width,$height);

// output header
if(empty($savethumb)) header('Content-Type: image/jpeg');

// determine image type and send it to the browser
// or save to file if specified
imagejpeg($img, $savethumb, 90);
imagedestroy($img);

?>