<?php
session_start();
use Facebook\FacebookRequestException;
use Facebook\FacebookRequest;

class FacebookController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |	Route::get('/', 'HomeController@showWelcome');
    |
    */

    public function getCallback()
    {
        Facebook::setDefaultApplication();
        Facebook::setFacebookSession();
        return Redirect::to('screens/screen04');
    }

    public function postUploadVideos()
    {
        Facebook::setDefaultApplication();
        $session = Facebook::getFacebookSession();
        $input = Input::all();
        if ($session)
        {
            try
            {
                // Upload to a user's profile. The photo will be in the
                // first album in the profile. You can also upload to
                // a specific album by using /ALBUM_ID as the path
                $response = (new FacebookRequest(
                    $session, 'POST', '/me/videos', array(
                        'source'      => "@" . Session::get('final_video_src'),
                        'description' => $input['comment'],
                        'privacy'     => "{'value':'" . $input['scopesetting'] . "'}"
                    )
                ))->execute()->getGraphObject();
                if (isset($input['youtubeUpload']))
                    return Redirect::to('screens/screen10yt');
                else
                    return Redirect::to('screens/screen11');
            }
            catch (FacebookRequestException $e)
            {
                echo "Exception occured, code: " . $e->getCode();
                echo " with message: " . $e->getMessage();
            }
        }
    }



    public function getAlbums(){
        Facebook::setDefaultApplication();
        $session = Facebook::getFacebookSession();

        if ($session)
        {
            try
            {
                /* make the API call */
                $request = new FacebookRequest(
                    $session,
                    'GET',
                    '/me/albums'
                );
                $response = $request->execute();
                $graphObject = $response->getGraphObject();
                /* handle the result */
                $albums = [];
                /* thumb image for no cover */
                $thumb = url('/asset/img/fb_mobile_up_icon.png');
                $thumb = $this->_imageRender($thumb, 58);
                if (isset($graphObject->asArray()['data']))
                {
                    foreach ($graphObject->asArray()['data'] as $album)
                    {
                        if (isset($album->count))
                        {
                            $item = array();
                            $item["id"] = $album->id;
                            $item["name"] = $album->name;
                            if($item["name"] == "Mobile Uploads") {
                                $item["name"] = "携帯アップロード";
                            }
                            $item["count"] = $album->count;
                            $item["img"] = (isset($album->cover_photo) ? $this->_getImgObject($album->cover_photo) : $thumb);
                            if(($item["name"] != "Timeline Photos") && ($item["name"] != "タイムラインの写真")) { // TODO need check languages 
                                $albums[] = $item;
                            }
                        }
                    }
                }
                return View::make("facebook.albums", compact("albums"));
            }
            catch (FacebookRequestException $e)
            {
                echo "Exception occured, code: " . $e->getCode();
                echo " with message: " . $e->getMessage();
            }
        }
    }

    public function getAlbum($id){
        Facebook::setDefaultApplication();
        $session = Facebook::getFacebookSession();

        if ($session)
        {
            try
            {
                /* make the API call */
                $request = new FacebookRequest(
                    $session,
                    'GET',
                    '/' . $id . '/photos' .'?limit=1000'
                );
                $response = $request->execute();
                $graphObject = $response->getGraphObject();
                $photos = array();
                /* handle the result */
                if (isset($graphObject->asArray()['data']))
                {
                    foreach ($graphObject->asArray()['data'] as $photo)
                    {
                        $item = array();
                        $item["id"] = $photo->id;
                        $item["img"] = $photo->source;
                        $photos[] = $item;
                    }
                }
                return View::make("facebook.album", compact("photos"));
            }
            catch (FacebookRequestException $e)
            {
                echo "Exception occured, code: " . $e->getCode();
                echo " with message: " . $e->getMessage();
            }
        }
    }

    public function getPhoto($id){
        Facebook::setDefaultApplication();
        $session = Facebook::getFacebookSession();

        if ($session)
        {
            try
            {
                /* make the API call */
                $request = new FacebookRequest(
                    $session,
                    'GET',
                    '/' . $id
                );
                $response = $request->execute();
                $graphObject = $response->getGraphObject();

                /* handle the result */
                return $graphObject->asArray()['source'];
            }
            catch (FacebookRequestException $e)
            {
                echo "Exception occured, code: " . $e->getCode();
                echo " with message: " . $e->getMessage();
            }
        }
    }

    public function getLogout(){
        $site_url = url("/");
        $token = Session::get(Facebook::_getFacebookSessionId());
        $url = 'https://www.facebook.com/logout.php?next=' . $site_url .
            '&access_token='.$token;
        Session::forget(Facebook::_getFacebookSessionId());
        return Redirect::away($url);
    }

    private function _getImgObject($id){
        return $this->_imageRender($this->getPhoto($id), 58);
    }

    private function _imageRender($source, $width){
        return "<img style=\"background-image:url('" . $source . "'); width: 58px; height: 58px;\" class='uiThumb' />";
    }

}
