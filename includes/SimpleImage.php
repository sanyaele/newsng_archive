<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
*/
 
class SimpleImage {
   
   var $image;
   var $image_type;
   var $path;
   var $ext;
 
   function path ($path) {
   		// Create path
		$this->path = $path;
   }
   
   function load($filename,$imgtype) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
	  $imgcreate = 0;
	  /////////////////////////////////////////////////
	  /////////////////////////////////////////////////
      if( $this->image_type == 'IMAGETYPE_JPEG' ) {
         $this->image = imagecreatefromjpeg($filename);
		 $this->ext = ".jpg";
		 $imgcreate = 1;
      } elseif( $this->image_type == 'IMAGETYPE_GIF' ) {
         $this->image = imagecreatefromgif($filename);
		 $this->ext = ".gif";
		 $imgcreate = 1;
      } elseif( $this->image_type == 'IMAGETYPE_PNG' ) {
         $this->image = imagecreatefrompng($filename);
		 $this->ext = ".png";
		 $imgcreate = 1;
      }
	  /////////////////////////////////////////////////
	  if (empty($imgcreate)):
		  if( $imgtype == 'image/jpeg' ) {
			 $this->image_type = 'IMAGETYPE_JPEG';
			 $this->image = imagecreatefromjpeg($filename);
			 $this->ext = ".jpg";
		  } elseif( $imgtype == 'image/pjpeg' ) {
			 $this->image_type = 'IMAGETYPE_JPEG';
			 $this->image = imagecreatefromjpeg($filename);
			 $this->ext = ".jpg";
		  } elseif( $imgtype == 'image/gif' ) {
			 $this->image_type = 'IMAGETYPE_GIF';
			 $this->image = imagecreatefromgif($filename);
			 $this->ext = ".gif";
		  } elseif( $imgtype == 'image/png' ) {
			 $this->image_type = 'IMAGETYPE_PNG';
			 $this->image = imagecreatefrompng($filename);
			 $this->ext = ".png";
		  }
	  endif;
   }
   function save($filename, $image_type='IMAGETYPE_JPEG', $compression=75, $permissions=null) {
      // Create Full path to file
	  $filename = $this->path . $filename;
	  
	  // Delete file if already exists
	  if (file_exists ($filename)):
		  unlink ($filename);
	  endif;
	  
	  if( $image_type == 'IMAGETYPE_JPEG' ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == 'IMAGETYPE_GIF' ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == 'IMAGETYPE_PNG' ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }      
}

/*
Save the above file as SimpleImage.php and take a look at the following examples of how to use the script.

The first example below will load a file named picture.jpg resize it to 250 pixels wide and 400 pixels high and resave it as picture2.jpg

<?php
   include('SimpleImage.php');
   $image = new SimpleImage();
   $image->load('picture.jpg');
   $image->resize(250,400);
   $image->save('picture2.jpg');
?>
If you want to resize to a specifed width but keep the dimensions ratio the same then the script can work out the required height for you, just use the resizeToWidth function.

<?php
   include('SimpleImage.php');
   $image = new SimpleImage();
   $image->load('picture.jpg');
   $image->resizeToWidth(250);
   $image->save('picture2.jpg');
?>
You may wish to scale an image to a specified percentage like the following which will resize the image to 50% of its original width and height

<?php
   include('SimpleImage.php');
   $image = new SimpleImage();
   $image->load('picture.jpg');
   $image->scale(50);
   $image->save('picture2.jpg');
?>
You can of course do more than one thing at once. The following example will create two new images with heights of 200 pixels and 500 pixels

<?php
   include('SimpleImage.php');
   $image = new SimpleImage();
   $image->load('picture.jpg');
   $image->resizeToHeight(500);
   $image->save('picture2.jpg');
   $image->resizeToHeight(200);
   $image->save('picture3.jpg');
?>
The output function lets you output the image straight to the browser without having to save the file. Its useful for on the fly thumbnail generation

<?php
   header('Content-Type: image/jpeg');
   include('SimpleImage.php');
   $image = new SimpleImage();
   $image->load('picture.jpg');
   $image->resizeToWidth(150);
   $image->output();
?>
The following example will resize and save an image which has been uploaded via a form

<?php
   if( isset($_POST['submit']) ) {
      include('SimpleImage.php');
      $image = new SimpleImage();
      $image->load($_FILES['uploaded_image']['tmp_name']);
      $image->resizeToWidth(150);
      $image->output();
   } else {
?>
   <form action="upload.php" method="post" enctype="multipart/form-data">
      <input type="file" name="uploaded_image" />
      <input type="submit" name="submit" value="Upload" />
   </form>
<?php
   }
?>
*/
?>