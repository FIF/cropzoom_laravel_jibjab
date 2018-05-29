<?php

ini_set('error_reporting', E_ALL);
ini_set('max_execution_time', 0);

class Processing {
    protected $source = './Transform_data_pampers.xml';
    protected $xmlstr;
    protected $xmlcont;
    protected $bg;

    //$face_name     = $_GET['face_name']; 
    public $face_name = "rod.png";
    public $face_dir;
    public $dirname;
    public $ruta;

    // For debuging
    protected $face_transformed_dir = '';
    protected $composed_output_dir = '';
    protected $frame_error_corrections = [];

    protected $frameStart = 1; // Frame number for start - video has frames from 0 to 1485
    protected $frameEnd = 10; // rame number to end - video has frames from 0 to 1485 
    protected $frameQT; // Frame quantity to process in ffmpeg exec

    protected $face;
    protected $face_w;
    protected $face_h;

    protected $ratio = 1; // in your code was: $ratio_800_1280

    function __construct() {
        $this->xmlstr = file_get_contents($this->source);
        $this->xmlcont = simplexml_load_string($this->xmlstr);

        $this->bg = new ImagickPixel('none');

        $this->dirname = ''; //dirname($_SERVER["SCRIPT_FILENAME"]);
        $this->face_dir = basename($this->face_name, ".png");
        $this->ruta = $this->dirname . "/" . $this->face_dir;

        $this->frameQT = $this->frameEnd - $this->frameStart;;

        $this->new_working_dir($this->face_dir);
        $this->face = new Imagick();
        $this->face->readImage("./faces/" . $this->face_name);
        $this->face_w = $this->face->getImageWidth();
        $this->face_h = $this->face->getImageHeight();
    }

    protected function setFace($face) {
        $this->face_name = $face;
    }

    public function setStartEnd($start, $end) {
        $this->frameStart = $start;
        $this->frameEnd = $end;
    }

    protected function transform($rotate, $new_width, $new_height, $face) {
        $new_width = intval($new_width);
        $new_height = intval($new_height);
        $bg = new ImagickPixel('none');
        $face->scaleImage($new_width, $new_height, false);
        $face->rotateImage($bg, $rotate);

        return $face;
    }

    // PHP setGravity seem not work, so we have to shift Anchor point to correction Top Left
    // Output filename contain meta data like width x height, compose position, scale ...
    public function final_compose() {
        $xmlcont = $this->xmlcont;

        foreach ($xmlcont as $frame) {
            if ((intval($frame->time) >= $this->frameStart) && (intval($frame->time) <= $this->frameEnd)) {
                $imgFace = clone $this->face;
                // $scale = $frame->scl_x/100;
                
                $imgFace = $this->transform(floatval($frame->rt), $this->face_w, $this->face_h, $imgFace); // edited by rod
                $new_anchor_x = round($frame->x - $imgFace->getImageWidth()/2); // ratio if needed
                $new_anchor_y = round($frame->y - $imgFace->getImageHeight()/2);

                $face_outp = "./Face_transformed/final_translate/face_". $frame->time." x ".$new_anchor_x. " y ". $new_anchor_y. " rt ".$frame->rt. " scl x ". $frame->scl_x. " zoom ". ".png";
                $imgFace->writeImage(''.$face_outp); 

                $imgBG = new Imagick("frames_1920/frame_" . $frame->time . ".png");
                $imgBG->compositeImage($imgFace, imagick::COMPOSITE_DIFFERENCE, $new_anchor_x, $new_anchor_y);

                $img_outp = "./final_all/frame_" . $frame->time.".png";
                $this->loging($frame->time." x \t".$new_anchor_x." y \t".$new_anchor_y." rt \t".$frame->rt ." scl x \t".$frame->scl_x. " zoom \t". "\n", 'final_translate');
                $imgBG->writeImage('' . $img_outp);
        
                echo "$img_outp  >  OK \n";

                exec("/usr/bin/ffmpeg -y -start_number $this->frameStart -i  $this->ruta/frame_%04d.png -vframes $this->frameQT $this->ruta/video.mp4", $o, $v); // render video
        print_r( $o);print_r( $v);
                echo "/usr/bin/ffmpeg -y -start_number $this->frameStart -i  $this->ruta/frame_%04d.png -vframes $this->frameQT $this->ruta/video.mp4"; // render video

                flush();
            }
        }
    }

    public function test_final_compose() {
        $xmlcont = $this->xmlcont;

        $this->setFaceTransformedOutpDir('test_final');
        $this->setComposedOutputDir('test_final');

        // Only process error frame.
        $frame_errors = [1269, 1270, 1308, 1309, 1310, 1311, 1312];  // Debug error frame only
        $this->setFrameErrorCorrection($frame_errors);

        $this->setStartEnd(143, 1485);
        // $this->cleanDir('test_final');
        // $this->cleanDir('./Face_transformed/test_final');
        $face_pos_y_err_correction = 20; // XML After Effect position data seem shift 20 px

        foreach ($xmlcont as $frame) {
            // if( in_array(intval($frame->time), $this->frame_error_corrections) ) {

            if ((intval($frame->time) >= $this->frameStart) && (intval($frame->time) <= $this->frameEnd)) {
                $imgFace = clone $this->face;
                $imgFace = $this->transform(floatval($frame->rt), $this->face_w, $this->face_h, $imgFace); // edited by rod
                $new_anchor_x = round($frame->x - $imgFace->getImageWidth()/2); // ratio if needed
                $new_anchor_y = round($frame->y - $imgFace->getImageHeight()/2) + $face_pos_y_err_correction;

                $face_outp = "./Face_transformed/". $this->face_transformed_dir. "/face_". $frame->time." x ".$new_anchor_x. " y ". $new_anchor_y. " rt ".$frame->rt. " scl x ". $frame->scl_x. " enlarged \t ". $imgFace->getImageWidth() . " x ". $imgFace->getImageHeight(). ".png";
                $imgFace->writeImage(''.$face_outp); 

                $imgBG = new Imagick("frames_1920/frame_" . $frame->time . ".png");
                $imgBG->compositeImage($imgFace, imagick::COMPOSITE_DIFFERENCE, $new_anchor_x, $new_anchor_y);

                $img_outp = $this->composed_output_dir. "/frame_" . $frame->time." x ".$new_anchor_x." y ".$new_anchor_y." rt ".$frame->rt ." scl_x ".$frame->scl_x. " zoom ". ".png";

                $this->loging($frame->time." x \t".$new_anchor_x." y \t".$new_anchor_y." rt \t".$frame->rt ." scl x \t".$frame->scl_x. " zoom \t"." enlarged \t ". $imgFace->getImageWidth() . " \t x \t". $imgFace->getImageHeight(). "\n", 'final_translate');
                $imgBG->writeImage('' . $img_outp);
                echo "$img_outp  >  OK \n";

                flush(); 
            }
        }
    }

    protected function new_working_dir($dir_name)
    {
        exec("mkdir -p $dir_name 2>&1", $o, $v);
        print_r($v);
    }

    protected function annotate() {
        "convert dragon.gif   -background Orange  label:'Faerie Dragon' \ +swap  -gravity Center -append    anno_label2.jpg";
    }

    public function loging($data, $filename) {
        if($filename) {
            $logfile = './logs/'.$filename;
        } else {
            $logfile = './logs/log.txt';
        }

        file_put_contents( $logfile, $data, FILE_APPEND );
    }

    protected function setFaceTransformedOutpDir($face_transformed_dir) {
        $this->face_transformed_dir = $face_transformed_dir;

        $face_transformed_dir = "Face_transformed/". $face_transformed_dir;
        $this->new_working_dir($face_transformed_dir);
    }

    protected function setComposedOutputDir($composed_output_dir) {
        $this->composed_output_dir = $composed_output_dir;
        $this->new_working_dir($composed_output_dir);
    }
    protected function cleanDir($target) {
        $target .= "/*";
        exec("rm -r $target 2>&1", $o, $v);
    }
    protected function setFrameErrorCorrection($frame_errors) {
        $this->frame_error_corrections = $frame_errors;
    }

}

$process = new Processing();
$process->final_compose();
//$process->test_final_compose();

//

echo "\nDone\n";
exit;