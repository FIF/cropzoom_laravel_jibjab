<?php
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Expires: Sat, 26 Jul 2007 05:00:00 GMT"); 

    $source = 'Transform_data.xml';

    $xmlstr = file_get_contents($source);
    $xmlcont = @simplexml_load_string($xmlstr); 

    // print_r($xmlcont);
    // var_dump($xmlcont); die;

    $bg = new ImagickPixel('none');
    $face = new Imagick();
    $face->readImage('demo_face.png');
    $face_w = $face->getimagewidth();
    $face_h = $face->getimageHeight();

    // For sample video, we use resolution 800 instead of original 1280 for faster process.
    $ratio_800_per_1280 = 0.625; //(800/1280);

    foreach($xmlcont as $frame) 
    {
        // $imgBG = new Imagick("bg.png");
        // echo $frame->time . " <br/>" ; 

        // Using Imagemagick or you could use getimagesize()
        // $convert = exec("convert -composite $frame  $head -geometry  +{$url->x}+{$url->y} result/result_00{$url->time}.png");
        // echo "convert -composite $frame  $head -geometry  +{$url->x}+{$url->y} result/result_00{$url->time}.png";
        // print_r($convert);

        if((intval($frame->time) >= 44) && (intval($frame->time) <= 79)) { // part1
            $imgFace = transform(-2, 2.42*$face_w * $ratio_800_per_1280, 2.42*$face_h*$ratio_800_per_1280);
            // $imgBG->compositeImage($imgFace, $imgFace->getImageCompose(), intval($frame->x +92.4 -241), intval($frame->y -20.8 -277)); 
            $frm = new Imagick("frames_800/frame_0".$frame->time. ".png");
            $face = new Imagick("RESULT/frame_0".$frame->time. ".png");
            // $imgBG->compositeImage($imgFace, imagick::COMPOSITE_DSTATOP , intval($frame->x +92.4 -241), intval($frame->y -20.8 -277));
            // $imgFace->compositeImage($frm, imagick::COMPOSITE_DSTATOP , 640, 720);
            $face->compositeImage($frm, imagick::COMPOSITE_DSTATOP , 0, 0);
            // $img_outp = "RESULT/frame_0". $frame->time. ".png";
            $img_outp2 = "/var/www/Hannibal/cropzoom_laravel_jibjab2/resources/material/RST/frame_0". $frame->time. ".png";
            // $imgBG->writeImage(''.$img_outp); 
            $face->writeImage(''.$img_outp2); 
        } else if((intval($frame->time) >= 80) && (intval($frame->time) <= 125)) { // part2
            $imgFace = transform(-2, 2.42*$face_w*$ratio_800_per_1280, 2.42*$face_h*$ratio_800_per_1280);
            $frm = new Imagick("frames_800/frame_0".$frame->time. ".png");
            $face = new Imagick("RESULT/frame_0".$frame->time. ".png");
            // $frm = new Imagick("Frames/frame_0".$frame->time. ".png");
            // $imgBG->compositeImage($imgFace, $imgFace->getImageCompose(), intval($frame->x +62 -241), intval($frame->y -32.3 -277)); 
            $face->compositeImage($frm, imagick::COMPOSITE_DSTATOP , 0, 0);
            // $img_outp = "RESULT/frame_0". $frame->time. ".png";
            $img_outp2 = "RST/frame_0". $frame->time. ".png";
            // $imgBG->writeImage(''.$img_outp2); 
            $face->writeImage(''.$img_outp2); 
        } else if((intval($frame->time) >= 132) && (intval($frame->time) <= 196)) { // part3  132 (196)
            $anchor_x = 43.7;
            $anchor_y = 56.6;

            $x_zoom = $frame->scl_x/100;
            $y_zoom = $frame->scl_y/100;
            // Magic numbers
            // ratio from Sample face 
            $scl_x = floatval($x_zoom)*36.2/100 * $face_w;
            $scl_y = floatval($y_zoom)*39.5/100 * $face_h;
            $scl_d = sqrt($scl_x*$scl_x/4 + $scl_y*$scl_y/4);

            $scl_D = sqrt($anchor_x*$anchor_x*$x_zoom*$x_zoom + $anchor_y*$anchor_y*$y_zoom*$y_zoom);
            $diameter = abs($scl_D - $scl_d);   // 

            $base_angle = atan($scl_y/$scl_x);
            $base_img_rotate = 0/180 *pi(); // Caused by when generate data from AE
            $rt = floatval($frame->rt)/180 *pi();
            // if($rt < 0) echo " rt: ". $frame->rt ."<br/>";
            $delta_rot = $base_angle + $rt + $base_img_rotate;

            $delta_x = $diameter * cos($delta_rot);
            $delta_y = $diameter * sin($delta_rot);

            // $face_d = abs(sqrt($face_h*$face_h/4 + $face_w*$face_w/4));

            $new_anchor_x = $frame->x + $delta_x;  // anchor point is in center of face image
            $new_anchor_y = $frame->y + $delta_y;  

            // echo $diameter . "<br/>";
            // echo "x: " . $anchor_x . " " . $delta_x . "<br/>";
            // echo "y: " . $anchor_y . " " . $delta_y . "<br/>";
            // test 20, 21, 46.5, 29 (slash).

            // $delta_x = 29 * sin(pi() * (43.5-$frame->rt)/180);
            // $delta_y = 29 * cos(pi() * (43.5-$frame->rt)/180);

            $imgFace = transform(floatval($frame->rt), $scl_x, $scl_y);
            $shift_x = sin($frame->rt/180 * pi()) *$scl_y;  // X pos shift caused by rotate
            $shift_y = sin($frame->rt/180 * pi()) *$scl_x;

            // echo $frame->time. " : " . ($new_anchor_x) . " y " . $new_anchor_y . " shift x" .$shift_x. " shift_y :" . $shift_y . "<br/>";

            // rotate < 0 --> shift y
            // $frm = new Imagick("Frames/frame_0".$frame->time. ".png");
            $frm = new Imagick("frames_800/frame_0".$frame->time. ".png");
            $face = new Imagick("RESULT/frame_0".$frame->time. ".png");
            $face->compositeImage($frm, imagick::COMPOSITE_DSTATOP , 0, 0);

            // if($frame->rt > 0) {
                // $imgBG->compositeImage($imgFace, $imgFace->getImageCompose(), intval($new_anchor_x-$shift_x), intval($new_anchor_y)); 
            // } else {
                // $imgBG->compositeImage($imgFace, $imgFace->getImageCompose(), intval($new_anchor_x), intval($new_anchor_y +$shift_y)); 
            // }
            // // $imgBG->compositeImage($imgFace, $imgFace->getImageCompose(), 30, 30); 
            // $img_outp = "RESULT/frame_0". $frame->time. ".png";
            $img_outp2 = "RST/frame_0". $frame->time. ".png";
            // $imgBG->writeImage(''.$img_outp2); 
            $face->writeImage(''.$img_outp2); 
        } else if((intval($frame->time) >= 377) && (intval($frame->time) <= 455)) { // part4
            $x_zoom = $frame->scl_x/100;
            $y_zoom = $frame->scl_y/100;
            $scl_x = floatval($x_zoom)*36.2/100 * $face_w;
            $scl_y = floatval($y_zoom)*39.5/100 * $face_h;
            $scl_d = sqrt($scl_x*$scl_x/4 + $scl_y*$scl_y/4);
            $diameter = $scl_d;

            $base_angle = atan($scl_y/$scl_x);
            $rt = floatval($frame->rt)/180 *pi();
            // if($rt < 0) echo "<br/>: ************* **********<br/> rt: ". $frame->rt ."<br/>";
            // echo " scale: x= ".$scl_x . " scl_y =".$scl_y. "<br/>";
            $delta_rot = $base_angle + $rt;

            $delta_x = $diameter * cos($delta_rot);
            $delta_y = $diameter * sin($delta_rot);

            $new_anchor_x = $frame->x - $delta_x;  // anchor point is in center of face image
            $new_anchor_y = $frame->y - $delta_y;  

            // echo $diameter . "<-- dim. <br/> delta x,y: <br/>";
            // echo "x: " . $delta_x . "<br/>";
            // echo "y: " . $delta_y . "<br/>";
            // echo "base pos: ".$frame->x. " base_y: ".$frame->y. "<br/>";

            $imgFace = transform(floatval($frame->rt), $scl_x, $scl_y); //floatval($frame->rt)
            $shift_x = sin($frame->rt/180 * pi()) *$scl_y;  // X pos shift caused by rotate
            $shift_y = sin($frame->rt/180 * pi()) *$scl_x;

            // echo $frame->time. " : " . ($new_anchor_x) . " y " . $new_anchor_y . " shift x" .$shift_x. " shift_y :" . $shift_y . "<br/>";
            // $frm = new Imagick("Frames/frame_0".$frame->time. ".png");

            $frm = new Imagick("frames_800/frame_0".$frame->time. ".png");
            $face = new Imagick("RESULT/frame_0".$frame->time. ".png");
            $face->compositeImage($frm, imagick::COMPOSITE_DSTATOP , 0, 0);

            // if($frame->rt > 0) {
            //  $imgBG->compositeImage($imgFace, $imgFace->getImageCompose(), intval($new_anchor_x-$shift_x+5), intval($new_anchor_y-5)); 
            // } else {
            //  $imgBG->compositeImage($imgFace, $imgFace->getImageCompose(), intval($new_anchor_x+5), intval($new_anchor_y +$shift_y-5)); 
            // }
            // $img_outp = "RESULT/frame_0". $frame->time. ".png";
            $img_outp2 = "RST/frame_0". $frame->time. ".png";
            // $imgBG->writeImage(''.$img_outp2); 
            $face->writeImage(''.$img_outp2); 
        }

        // $scale_out = "scaled_0$frame->time.png";
        // $imgDuc->writeImage("scaled_0$frame->time.png"); 
        // $imgMain->compositeImage($imgDuc, $imgDuc->getImageCompose(), 220, 170); 
        // $imgBG->compositeImage($imgDuc, $imgDuc->getImageCompose(), intval($frame->x +92.4 -191), intval($frame->y -20.8 -232)); 
        // $imgMain->compositeImage($imgBG, $imgBG->getImageCompose(), 640, 360); 

        //new image is saved as final.jpg 

        // die;
    }

    function transform($rotate, $scale_x, $scale_y) {
        $bg = new ImagickPixel('none');
        $imgFace = new Imagick('demo_face.png');
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

    function compose() {
        exec("ffmpeg -framerate 30 -i frame_0%03d.png -s:v 1280x720 -c:v libx264 -profile:v high -crf 23 -pix_fmt yuv420p -r 30 -vb 12M  movies.mp4 ");
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

dim: AT4: 191 x 232
*/
?>
