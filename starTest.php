<?php
//creates a image handle
$img = imagecreate( 200, 200 );
 
//choose a bg color, u can play with the rgb values
$background = imagecolorallocate( $img,232, 0, 135 );
 
//chooses the text color
$text_colour = imagecolorallocate( $img, 255, 255, 255 );
 
//sets the thickness/bolness of the line
imagesetthickness ( $img, 3 );
 
//draws a line  params are (imgres,x1,y1,x2,y2,color)
imageline( $img, 20, 130, 165, 130, $text_colour );
 
//pulls the value passed in the URL
$text = $_GET['days'];
 
// place the font file in the same dir level as the php file
$font = 'comic.ttf';
 
//this function sets the font size, places to the co-ords
imagettftext($img, 100, 0, 11, 120, $text_colour, $font, $text);
//places another text with smaller size
imagettftext($img, 16, 0, 10, 160, $text_colour, $font, 'Small Text');
 
//alerts the browser abt the type of content i.e. png image
header( 'Content-type: image/png' );
//now creates the image
imagepng( $img );
 
//destroys used resources
imagecolordeallocate( $text_color );
imagecolordeallocate( $background );
imagedestroy( $img );
?>