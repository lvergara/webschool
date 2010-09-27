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
EXAMPLES
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
 
class SimpleImage {
   
	var $image;
	var $image_type;
	var $image_name;
	var $image_size;
	var $image_tmp_name;
	var $image_ext;
	var $file_name;
	var $file_ext;
 
   function load($filename) 
   {
		$image_info = getimagesize($filename);
		$this->image_type = $image_info[2];
		$this->image_name = $filename;	   
		$this->image_tmp_name = $filename;
        
		if( $this->image_type == 2 )
		{		 
			$this->image = imagecreatefromjpeg($filename);		 
			$this->image_ext = 'jpg';
		}
		elseif( $this->image_type == 1 ) 
		{
			$this->image = imagecreatefromgif($filename);
			$this->image_ext = 'gif';
		}
		elseif( $this->image_type == 3 ) 
		{
			$this->image = imagecreatefrompng($filename);		
			$this->image_ext = 'png';
		}
   }
   function save($filename, $image_type=2, $compression=95, $permissions=NULL)
   {   	             
		if( $this->image_type == 2 )
		{          
			//$this->setFileName($filename,$this->image_ext);	  		
			imagejpeg($this->image,$filename.'.'.$this->image_ext,$compression);
		} 
		elseif( $this->image_type == 1 )
		{
			//$this->setFileName($filename,$this->image_ext);	  
			imagegif($this->image,$filename.'.'.$this->image_ext);         
		}
		elseif( $this->image_type == 3 ) 
		{
			//$this->setFileName($filename,$this->image_ext);
			imagepng($this->image,$filename.'.'.$this->image_ext);
		}   
		
		if( $permissions != null) 
		{
			chmod($filename,$permissions);
		}
   }
   function output($image_type=2) {
      if( $image_type == 2 ) {
         imagejpeg($this->image);
      } elseif( $image_type == 1 ) {
         imagegif($this->image);         
      } elseif( $image_type == 3 ) {
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
	  
		if($width <= $this->getWidth()) 
			$this->resize($width,$height);
		else
			$this->resize($this->getWidth(),$this->getHeight());  
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
	function setImgName($name)
	{   
		$this->file_name = $name.'.'.$this->image_ext;    
	}
	function getImgName()
	{
		return $this->file_name;
	}
	
   //Funciones para guardar imagen en Base de Datos
	function loadFormFile($formFile) 
	{
		$this->image_tmp_name = $formFile['tmp_name'];
		$this->image_name = $formFile['name'];		
		$this->image_size = $formFile['size'];
		
		$image_info = getimagesize($this->image_tmp_name);

      	$this->image_type = $image_info[2];
		
		if( $this->image_type == 2 ) 
		{
			$this->image = imagecreatefromjpeg($this->image_tmp_name);
			$this->image_ext = 'jpg';
			return true;
		} 
		elseif( $this->image_type == 1 ) 
		{
			$this->image = imagecreatefromgif($this->image_tmp_name);
			$this->image_ext = 'gif';
			return true;
		} 
		elseif( $this->image_type == 3 ) 
		{
			$this->image = imagecreatefrompng($this->image_tmp_name);
			$this->image_ext = 'png';
			return true;
		}
		else
		{
			return false;
		}		
	}
	function setNewData()
	{
		$this->save($this->image_name.'temp');
		$this->image_size = filesize($this->image_name.'temp');		
		$fp = fopen($this->image_name.'temp', 'r');
		$this->image_content = addslashes( fread($fp, filesize($this->image_name.'temp')) );
		fclose($fp);		
		unlink($this->image_name.'temp');		
	}
	//Funciones para copiar sin comprimir
	function setCopyFile($formFile) 
	{
		$this->image_tmp_name = $formFile['tmp_name'];
		$this->image_name = $formFile['name'];		
		$this->image_size = $formFile['size'];
		
		$image_info = getimagesize($this->image_tmp_name);

      	$this->image_type = $image_info[2];
		
		if( $this->image_type == 2 ) 
		{		
			$this->file_ext = 'jpg';		
		} 
		elseif( $this->image_type == 1 ) 
		{
			$this->file_ext = 'gif';
		} 
		elseif( $this->image_type == 3 ) 
		{
			$this->file_ext = 'png';
		}
		else
		{
			$this->file_ext = 'jpg';
		}		
	}
	function setFileName($name)
	{
		$this->file_name = $name.'.'.$this->file_ext;
	}
	function getFileName()
	{
		return $this->file_name;
	}
	function copyFileTo($route)
	{
		if(!copy($this->image_tmp_name,$route.$this->file_name))
		{
			echo 'Error al copiar el archivo.';
		}
	}
}
?>