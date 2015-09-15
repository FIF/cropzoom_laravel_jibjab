<?php

class YoutubeController extends BaseController {

	public function getOAuth2callback(){
		if (!isset($_GET['code']))
        {
            return Redirect::to('youtube/get-access-token');
        }
        $accessToken = Youtube::authenticate(Input::get('code'));
        Session::put('ytAccessToken', $accessToken);
        return View::make('screens.screen10yt');
	}

	public function getAccessToken(){
		$authUrl = Youtube::createAuthUrl();
        return View::make('screens.screen10yt')->with(compact('authUrl'));
	}

	public function getMaxResult($maxResults){
		if (!Session::has('ytAccessToken'))
        {
            return Redirect::to('youtube/get-access-token');
        }
        return Response::json(Youtube::getUploads($maxResults));
	}

	public function postVideos(){
        $videoDetail = Input::all();
		$rules = array(
            'title' => 'required',
            'status' => 'required|in:public,private,unlisted',
            'video' => 'required',
        );

        $message = array(
            'title.required' => '※タイトルを入力してください',
            'status.required' => '※公開範囲を選択してください',
        );

        $input = array(
            'title' => $videoDetail['title'],
            'description' => $videoDetail['description'],
            'status' => isset($videoDetail['scope']) ? $videoDetail['scope'] : "",
            'video' => Session::has("final_video_src") ? new \Symfony\Component\HttpFoundation\File\UploadedFile(Session::get("final_video_src"), basename(Session::get("final_video_src")), 'video/mp4', null, null, false) : ""
        );

        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails())
        {
            return Redirect::to('screens/screen10yt')->withErrors($validator);
        }
        try {
            $youtubeVideoId = Youtube::upload($input);
            Session::put('youtubeVideoId', $youtubeVideoId);
            return Redirect::to('screens/screen12');
        } catch (Exception $e) {
            $msg = "";
            if (strpos($e->getMessage(), "(401) Unauthorized"))
                $msg = "Youtube channel was not created. Make sure create new channel before processing";
            return Redirect::to('screens/screen10yt')->withMessage($msg);
        }
	}

    public function getLogout(){
        $site_url = url("screens/screen10post");
        $url = 'https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=' . $site_url;
        Session::forget("ytAccessToken");
        return Redirect::away($url);
    }
}
