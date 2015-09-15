<?php

use Facebook\FacebookRedirectLoginHelper;

class ScreensController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function getIndex()
    {
        return View::make('screens.home');
    }

    public function getScreen01()
    {
        Facebook::setDefaultApplication();
        $helper = new FacebookRedirectLoginHelper(Facebook::getCallBackUrl());
        $loginUrl = $helper->getLoginUrl(array('publish_actions', 'user_photos'));
        return View::make('screens.screen01', compact('loginUrl'));
    }

    public function getScreen04()
    {
        // if ( ! Facebook::checkFacebookSession())
        //     return Redirect::to('screens/screen01');
        
        return View::make('screens.screen04');
    }

    public function getScreen06()
    {
        if (! Session::has('OrgPic'))
            return Redirect::to('screens/screen01');

        $file = Session::get('OrgPic');
        list($width, $height) = getimagesize($file);
        $file = url('images/tmp') . '/' . basename($file);
        return View::make('screens.screen06', compact("file", "width", "height"));
    }

    public function getScreen06FromFb($id)
    {
        $fbController = new FacebookController();
        $img = $fbController->getPhoto($id);
        $imgArr = explode(".",$img);
        $ext = end($imgArr);
        if (strpos($ext, "?")){
            $ext = explode("?", $ext)[0];
        }
        $image = new Imagick($img);
        $filename = str_random(6) . '_upload.' . $ext;
        $file = url('images/tmp') . '/' . $filename;
        $fileSrc = Config::get('contants.public_path') . '/images/tmp/' . $filename;
        $image->writeImage($fileSrc);
        Session::set('OrgPic',$fileSrc);
        list($width, $height) = getimagesize($fileSrc);
        return View::make('screens.screen06', compact("file", "width", "height"));
    }

    public function postScreen06()
    {
        $name = Input::get('name');
        $filename = "";
        if (Input::hasFile($name))
        {
            $file = Input::file($name);
            if ($file->getSize() >= 5120000){
                return Redirect::to("screens/screen04")->with("S6Error", "Your file is exceed allow size. Please try again.");
            }
            $extension = $file->getClientOriginalExtension();
            $destinationPath = Config::get('contants.public_path') . '/images/tmp/';
            $prefix = str_random(6) . '_upload.';
            $filename = $prefix . $extension;
            $uploadSuccess = $file->move($destinationPath, $filename);
        }

        if ($uploadSuccess){
            $image = new Imagick($destinationPath . $filename);
            $orien = $image->getImageOrientation();
            $iOSOriented = 6;
            $androidOriented = 8;
            $revertNoOrientation = 0;
            if($orien == $iOSOriented || $orien == $androidOriented) {
                $bg = new ImagickPixel('none');
                if ($orien == $iOSOriented)
                {
                    $image->rotateImage($bg, 90);
                    $image->setImageOrientation($revertNoOrientation);
                }
                else
                {
                    $image->rotateImage($bg, -90);
                    $image->setImageOrientation($revertNoOrientation);
                }
                $image->writeImage($destinationPath . $filename);
            }
            if ($extension != "jpg"){
                $image->setImageFormat('jpeg');
                $image->setImageCompressionQuality(90);
                $filename = $prefix . 'jpg';
                $image->writeImage($destinationPath . $filename);
                $image->clear();
                $image->destroy();
            }

            $file = url('images/tmp') . '/' . $filename;
            $fileSrc = Config::get('contants.public_path') . '/images/tmp/' . $filename;
            Session::set('OrgPic', $fileSrc);

            list($width, $height) = getimagesize($fileSrc);

            return View::make('screens.screen06', compact("file", "width", "height"));
        }
    }

    public function getScreen07()
    {
        if (! Session::has('faceImgC'))
            return Redirect::to('screens/screen01');
        return View::make('screens.screen07');
    }

    public function getScreen08()
    {
        return View::make('screens.screen08');
    }

    public function getVideoProcess()
    {
        $videoProcessing = new \LaravelPrototype\Common\VideoProcessing();
        $videoProcessing->Processing(Session::get('faceImgSrc'));
        return Redirect::to('screens/screen09');
    }

    public function getScreen09()
    {
        if (! Session::has('final_video'))
            return Redirect::to('screens/screen01');
        return View::make('screens.screen09');
    }

    public function getScreen10()
    {
        if (! Session::has('final_video'))
            return Redirect::to('screens/screen01');
        $optionPrivacy = Facebook::getPrivacyOption();
        return View::make('screens.screen10', compact("optionPrivacy"));
    }

    public function getScreen10post()
    {
        if (! Session::has('final_video'))
            return Redirect::to('screens/screen01');
        return View::make('screens.screen10post');
    }

    public function getScreen10yt()
    {
        if (! Session::has('final_video'))
            return Redirect::to('screens/screen01');
        if (!Session::has('ytAccessToken'))
        {
            return Redirect::to('youtube/get-access-token');
        }

        return View::make('screens.screen10yt');
    }

    public function getScreen11()
    {
        if (! Session::has('final_video'))
            return Redirect::to('screens/screen01');
        return View::make('screens.screen11');
    }

    public function getScreen12()
    {
        if (! Session::has('final_video'))
            return Redirect::to('screens/screen01');
        return View::make('screens.screen12');
    }

    public function getScreen13()
    {
        return View::make('screens.screen13');
    }

    public function getScreen14()
    {
        return View::make('screens.screen14');
    }

    public function getScreen15()
    {
        return View::make('screens.screen15');
    }

    public function getCamera(){
        return View::make('screens.camera');
    }

    public function getPicDownload(){
        $file= Session::get('faceImgCSrc');
        $headers = array(
            'Content-Type: application/octet-stream',
        );
        return Response::download($file, basename($file), $headers);
    }
} 