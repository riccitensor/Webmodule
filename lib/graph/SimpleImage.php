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
   
   var $formatConvert = '';
   var $compression=75;

   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_PNG, $permissions=null) {
      if ($this->formatConvert==''){
          if( $image_type == IMAGETYPE_JPEG ) {
             imagejpeg($this->image,$filename,$this->compression);
          } elseif( $image_type == IMAGETYPE_GIF ) {
             imagegif($this->image,$filename);
          } elseif( $image_type == IMAGETYPE_PNG ) {
             imagepng($this->image,$filename);
          }
      } else {
          if ($this->formatConvert=='jpeg'){
              imagejpeg($this->image,$filename,$this->compression);
          } else 
          if ($this->formatConvert=='gif'){
              imagegif($this->image,$filename);
          } else 
          if ($this->formatConvert=='png'){
              imagepng($this->image,$filename);
          }
          
      }
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_PNG) {
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
   
   function crop($DoXX,$DoYY) {
       $xxImage = $this->getWidth();
       $yyImage = $this->getHeight();
       $Xroznica = $DoXX / $xxImage;
       $WyliczoneYY = floor($yyImage *  $Xroznica);
       $Yroznica = $DoYY / $yyImage;
       $WyliczoneXX = floor($xxImage *  $Yroznica);       
       
       //echo "DoXX = $DoXX <br/> DoYY = $DoYY <br/>";
       //echo "xxImage = $xxImage <br/> yyImage = $yyImage <br/>";
       //echo "WyliczoneXX = $WyliczoneXX <br/> WyliczoneYY = $WyliczoneYY <br/>";
       
       $image_new = imagecreatetruecolor($DoXX, $DoYY);       
       if ($WyliczoneYY>=$DoYY) {           
           //echo "YY <br/>X=$DoXX <br/>Y=$WyliczoneYY <br/>";           
           $this->resize($DoXX, $WyliczoneYY);           
       } else       
       if ($WyliczoneXX>=$DoXX) {           
           //echo "XX <br/>X=$WyliczoneXX <br/>Y=$DoYY <br/>";
           $this->resize($WyliczoneXX, $DoYY);    
       }       
       imagecopyresampled($image_new, $this->image, 0, 0, 0, 0, $DoXX, $DoYY, $DoXX, $DoYY);
       $this->image = $image_new;
   }
   
   
   
}
?>