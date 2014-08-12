<?php
class resizeimage{
	// Set a few variables

var $image = "";
var $newimage = "";
var $max_height = 700;
var $max_width = 700;
var $pagingType = '';

// Main code
	function get_mime($path)
	{
	
		$img_data = getimagesize($path);
		return $img_data['mime'];
	}
	function resize($image,$newimage, $maxheight, $maxwidth)
	{
		ini_set("memory_limit", "100M");
		$this->image = $image;
		$this->newimage = $newimage;
		$this->max_height= $maxheight;
		$this->max_width = $maxwidth;
		
		$mime=$this->get_mime($this->image);
		
		switch($mime)
		{
			case 'image/jpeg':
				$src_img = imagecreatefromjpeg($this->image);
			break;
			
			case 'image/gif':
				$src_img = imagecreatefromgif($this->image);
			break;
			
			case 'image/png':
				$src_img = imagecreatefrompng($this->image);
			break;
		}
		
		//$src_img = ImageCreateFromJpeg($this->image);
		$orig_width = ImageSX($src_img); 
		$orig_height = ImageSY($src_img);
		
		//print $orig_width . "<br/>". $orig_height;exit;
		if (($orig_width < $maxwidth) && ($orig_height < $maxheight ))
		{
			copy($image,$newimage);
		}
		else
		{
			$image_quality = 80;
			$addborder = 0;
	
			if ($orig_height > $orig_width)
			{
					$new_height = $maxheight;
					$new_width = $orig_width * $maxheight / $orig_height;
	
					if ($new_width > $maxwidth)
					{
							$new_width = $maxwidth;
							$new_height = $orig_height * $maxwidth / $orig_width;
					}
			}
			else
			{
					$new_width = $maxwidth;
					$new_height = $orig_height * $maxwidth / $orig_width;
					if ($new_height > $maxheight)
					{
							$new_height = $maxheight;
							$new_width = $orig_width * $maxheight / $orig_height;
					}
			}	
			
			$dst_img = ImageCreateTrueColor($new_width,$new_height); 
			ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height); 
			
			if ($addborder == 1) {
					// Add border
					$black = ImageColorAllocate($dst_img, 0, 0, 0); 
					ImageSetThickness($dst_img, 1);
					ImageLine($dst_img, 0, 0, $new_width, 0, $black);
					ImageLine($dst_img, 0, 0, 0, $new_height, $black);
					ImageLine($dst_img, $new_width-1, 0, $new_width-1, $new_height, $black);
					ImageLine($dst_img, 0, $new_height-1, $new_width, $new_height-1, $black);
			}
					
			ImageJpeg($dst_img, $this->newimage, $image_quality); 
			ImageDestroy($src_img); 
			ImageDestroy($dst_img);
		}
	}
}
?>
	