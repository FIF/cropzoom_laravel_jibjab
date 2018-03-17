<?php
	header("Cache-Control: no-cache, must-revalidate"); 
	header("Expires: Sat, 26 Jul 2007 05:00:00 GMT"); 

	$source = 'Transform_data.xml';

	$xmlstr = file_get_contents($source);
	$xmlcont = @simplexml_load_string($xmlstr); 

	// print_r($xmlcont);
	// var_dump($xmlcont); die;

	// get the image width
	// $width = (int) ($imgMain->getimagewidth() /2) - 150;
	// print_r($width); die;

	//Instantiate a barcode img Gmagick object


	$bg = new ImagickPixel('none');
	$face = new Imagick();
	$face->readImage('AT4.png');
	$face_w = $face->getimagewidth();
	$face_h = $face->getimageHeight();
	// echo $duc_height . " ". $duc_width . "<br>"; die;
	// print_r($width - 300); die;
	// $imgMain->compositeimage($imgDuc, 1, $width-300, 50);
	// header("Content-type: image/png");
	// imagepng($imgMain);
	//Write the current image at the current state to a file
	// $fileHandle = fopen("frame_duc_head.png", "w");
	// $imgMain->writeImageFile($fileHandle);

	// Set the colorspace to the same value 
	// $imgMain->setImageColorspace($imgDuc->getImageColorspace() ); 

	//Second image is put on top of the first 
	// $imgRotate = imagerotate($imgDuc, -13.55, 0);
	// $flg = 0;
	foreach($xmlcont as $frame) 
	{
		// echo $frame->time . " <br/>";
		// TODO 
		// 44-79 part One; 
		// $flg++;
		// if($flg < 3) {
		// $imgFace = new Imagick('AT4.png');
		// echo $frame->time . " " . $frame->x. " " . $frame->y . " ". $frame->scale_x. " ". $frame->scale_y. " ". $frame->rotate . " \r\n". "<br>";
		   // echo "{$url->time}  {$url->x} {$url->y} <br/>"; die;
	 	// $frame = "frames/frame_00$url->time.png";

	 	// print_r($imgFrm);
	 	// $imgMain = new Imagick("Frames/frame_0$frame->time.png");
	 	$imgBG = new Imagick("bg.png");
	 	// echo $frame->time . " <br/>" ; 

		// Using Imagemagick or you could use getimagesize()
		// $convert = exec("convert -composite $frame  $head -geometry  +{$url->x}+{$url->y} result/result_00{$url->time}.png");
		// echo "convert -composite $frame  $head -geometry  +{$url->x}+{$url->y} result/result_00{$url->time}.png";
		// print_r($convert);

	 	if((intval($frame->time) >= 44) && (intval($frame->time) <= 79)) { // part1
			// $imgFace = transform(-2, 2.42*$face_w, 2.42*face_h);
			// $imgBG->compositeImage($imgFace, $imgFace->getImageCompose(), intval($frame->x +92.4 -241), intval($frame->y -20.8 -277)); 
			// $img_outp = "RESULT/frame_00". $frame->time. ".png";
			// $imgBG->writeImage(''.$img_outp); 
		} else if((intval($frame->time) >= 80) && (intval($frame->time) <= 125)) { // part2
			// $imgFace = transform(-2, 2.42*$face_w, 2.42*face_h);
			// $imgBG->compositeImage($imgFace, $imgFace->getImageCompose(), intval($frame->x +62 -241), intval($frame->y -32.3 -277)); 
			// $img_outp = "RESULT/frame_00". $frame->time. ".png";
			// $imgBG->writeImage(''.$img_outp); 
		} else if(0) {//(intval($frame->time) >= 132) && (intval($frame->time) <= 196)) { // part3  132 (196)
			// echo $frame->scl_x*0.362/100 . " <br/>";
			$anchor_x = 43.7;
			$anchor_y = 56.6;

			$x_zoom = $frame->scl_x/100;
			$y_zoom = $frame->scl_y/100;
			$scl_x = floatval($x_zoom)*36.2/100 * $face_w;
			$scl_y = floatval($y_zoom)*39.5/100 * $face_h;
			$scl_d = sqrt($scl_x*$scl_x/4 + $scl_y*$scl_y/4);

			$scl_D = sqrt($anchor_x*$anchor_x*$x_zoom*$x_zoom + $anchor_y*$anchor_y*$y_zoom*$y_zoom);
			$diameter = abs($scl_D - $scl_d);   // 

			$base_angle = atan($scl_y/$scl_x);
			$base_img_rotate = 0/180 *pi(); // Caused by when generate data from AE
			$rt = floatval($frame->rt)/180 *pi();
			if($rt < 0) echo " rt: ". $frame->rt ."<br/>";
			$delta_rot = $base_angle + $rt + $base_img_rotate;

			$delta_x = $diameter * cos($delta_rot);
			$delta_y = $diameter * sin($delta_rot);

			// $face_d = abs(sqrt($face_h*$face_h/4 + $face_w*$face_w/4));

			$new_anchor_x = $frame->x + $delta_x;  // anchor point is in center of face image
			$new_anchor_y = $frame->y + $delta_y;  

			echo $diameter . "<br/>";
			echo "x: " . $anchor_x . " " . $delta_x . "<br/>";
			echo "y: " . $anchor_y . " " . $delta_y . "<br/>";
			// test 20, 21, 46.5, 29 (slash).

			// $delta_x = 29 * sin(pi() * (43.5-$frame->rt)/180);
			// $delta_y = 29 * cos(pi() * (43.5-$frame->rt)/180);

			$imgFace = transform(floatval($frame->rt), $scl_x, $scl_y);
			$shift_x = sin($frame->rt/180 * pi()) *$scl_y;  // X pos shift caused by rotate
			echo $frame->time. " : " . ($new_anchor_x) . " y " . $new_anchor_y . " shift x" .$shift_x. "<br/>";

			$imgBG->compositeImage($imgFace, $imgFace->getImageCompose(), intval($new_anchor_x-$shift_x), intval($new_anchor_y)); 
			// // $imgBG->compositeImage($imgFace, $imgFace->getImageCompose(), 30, 30); 
			$img_outp = "RESULT/frame_0". $frame->time. ".png";
			$imgBG->writeImage(''.$img_outp); 
		} else if((intval($frame->time) >= 377) && (intval($frame->time) <= 445)) { // part4
			$anchor_x = 3.8;
			$anchor_y = 9.6;

			$x_zoom = $frame->scl_x/100;
			$y_zoom = $frame->scl_y/100;

			$scl_x = $x_zoom*34/100 *$face_w;
			$scl_y = $y_zoom*34/100 *$face_h;
			$scl_d = sqrt($scl_x*$scl_x/4 + $scl_y*$scl_y/4);
			$base_angle = atan($scl_y/$scl_x);
			$base_img_rotate = 107.4/180 *pi(); // Caused by when generate data from AE
			$rt = floatval($frame->rt)/180 *pi();
			$delta_rot = $base_angle + $rt + $base_img_rotate;

			$delta_x = $scl_d * cos($delta_rot);
			$delta_y = $scl_d * sin($delta_rot);

			$new_anchor_x = $frame->x - $delta_x;  // anchor point is in center of face image
			$new_anchor_y = $frame->y - $delta_y;  

			echo $frame->time. " " .$diameter . "<br/>";
			echo "x: " . $anchor_x . " " . $delta_x . "<br/>" ."\n";
			echo "y: " . $anchor_y . " " . $delta_y . "<br/>". "\n";

			// $shift_x = sin(($frame->rt+107.4)/180 * pi()) *$scl_y;

			$imgFace = transform($frame->rt+107.4, $scl_x, $scl_y);
			echo $frame->time. " : " . ($new_anchor_x) . " y " . $new_anchor_y . " shift x" .$shift_x. "<br/>";
			$imgBG->compositeImage($imgFace, $imgFace->getImageCompose(), intval($new_anchor_x), intval($new_anchor_y)); 
			$img_outp = "result4/frame_0". $frame->time. ".png";
			$imgBG->writeImage(''.$img_outp); 
		}

		// $scale_out = "scaled_0$frame->time.png";
		// $imgDuc->writeImage("scaled_0$frame->time.png"); 
		// $imgMain->compositeImage($imgDuc, $imgDuc->getImageCompose(), 220, 170); 
		// $imgBG->compositeImage($imgDuc, $imgDuc->getImageCompose(), intval($frame->x +92.4 -191), intval($frame->y -20.8 -232)); 
		// $imgMain->compositeImage($imgBG, $imgBG->getImageCompose(), 640, 360); 

		//new image is saved as final.jpg 

		// die;

/*
		$img1 = "results/result_044.png";
		$img2 = "Frames/frame_0044.png";
		// $img2 = "Frames/frame_0044.png";

		$dest = imagecreatefrompng($img1);
		$src = imagecreatefrompng($img2);
		imagecolortransparent($src, imagecolorat($src, 0, 0));

		$src_x = imagesx($src);
		$src_y = imagesy($src);
		imagecopymerge($dest, $src, 0, 0, 0, 0, $src_x, $src_y, 100);

		// Output and free from memory
		header('Content-Type: image/png');
		imagegif($dest);

		imagedestroy($dest);
		imagedestroy($src);
		*/
	 // } // end flg test
	}

	function transform($rotate, $scale_x, $scale_y) {
		$bg = new ImagickPixel('none');
		$imgFace = new Imagick('AT4.png');
		// $imgFace2 = new Imagick();
		// $imgFace2->readImage('AT4.png');
		// $face_width = $imgFace2->getimagewidth();
		// $face_height = $imgFace2->getimageHeight();

		$scale_x = intval($scale_x);          
		$scale_y = intval($scale_y);

		$imgFace->scaleImage($scale_x, $scale_y, false);
		$imgFace->rotateImage($bg, $rotate); 
		return $imgFace;
	}

	// TODO
	function calc_position() {  // calculate transform position by scale, rotate and anchor point

	}
/*
AT1 44 -> 79
- pos: 92.4 -20.8
- scale: 242 242
- rotate: -2

AT2 80 -> 125
62.0  -32.3
242 242
-2 

AT3 132 -> 196
43.7 56.6
36.2 39.5

AT4 377 -> 445
3.8 9.6
34 34
107.4

dim: AT4: 191 x 232
*/





/*
$imgDuc->rotateImage($bg, -2); // intval($frame->rotate -2
			// $imgDuc->writeImage('duc_rotate3.png');
			$scale_x = intval($duc_width*2.42);          // fix me 242% scale
			$scale_y = intval($duc_height*2.42);

			// echo $scale_x . " ". $scale_y. " ". $frame->rotate; 
			// die;

			$imgDuc->scaleImage($scale_x, $scale_y, false);
*/
/*
copymerge
		// $image_1 = imagecreatefrompng('results/result_044.png');
		// $image_2 = imagecreatefrompng('Frames/frame_0044.png');
		// imagealphablending($image_1, true);
		// imagesavealpha($image_1, true);
		// imagecopy($image_1, $image_2, 0, 0, 0, 0, 100, 100);
		// imagepng($image_1, 'image_3.png');
*/

?>
