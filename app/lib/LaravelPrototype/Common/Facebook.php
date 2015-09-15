<?php

namespace LaravelPrototype\Common;

use Facebook\FacebookSession;
use Illuminate\Support\Facades\Session;
use Facebook\FacebookRedirectLoginHelper;

class Facebook {

    public static function getAppId(){
        return '1474767046095270'; // boatrace.local.nal
    }

    public static function getAppSecret(){
        return '00e128afd58ce3faa4485c438a70fae1'; // boatrace.local.nal
    }

    public static function getCallBackUrl(){
        return "http://boatrace.local.nal/facebook/callback"; // boatrace.local.nal
    }

    private static function _getFacebookSessionId(){
        return 'lara_fb_token';
    }

    public static function setDefaultApplication()
    {
        FacebookSession::setDefaultApplication(self::getAppId(), self::getAppSecret());
    }

    public static function getFacebookSession()
    {
        return new FacebookSession(Session::get(self::_getFacebookSessionId()));
    }

    public static function setFacebookSession(){
        $f_redirect = new FacebookRedirectLoginHelper(self::getCallBackUrl());
        $short_session = $f_redirect->getSessionFromRedirect();
        $long_session = $short_session->getLongLivedSession(self::getAppId(), self::getAppSecret());
        Session::set(self::_getFacebookSessionId(), $long_session->getToken());
    }

    public static function checkFacebookSession(){
        return Session::has(self::_getFacebookSessionId());
    }

    public static function fqlQuery($q) {
            // Run fql query
            $fql_query_url = 'https://graph.facebook.com'
                . '/fql?q='. urlencode($q)
                . '&access_token=' . Session::get(self::_getFacebookSessionId());
            $fql_query_result = file_get_contents($fql_query_url);


            $length = strlen(PHP_INT_MAX);
            $fql_query_result = preg_replace('/"(user_id)":(\d{' . $length . ',})/', '"\1":"\2"', $fql_query_result);

            return json_decode($fql_query_result, true);
    }

    public static function getPrivacyOption(){
        $choosePrivacyArr = self::fqlQuery("SELECT value FROM privacy_setting WHERE name='default_stream_privacy'");
        $choosePrivacy = $choosePrivacyArr["data"][0]["value"];
        $optionPrivacy = array();
        switch ($choosePrivacy){
            case "EVERYONE":
            case "CUSTOM":
                $optionPrivacy[] = array("value" => "EVERYONE", "text" => "公開");
                $optionPrivacy[] = array("value" => "ALL_FRIENDS", "text" => "友達");
                $optionPrivacy[] = array("value" => "SELF", "text" => "自分のみ");
                break;
            case "FRIENDS_OF_FRIENDS":
            case "ALL_FRIENDS":
                $optionPrivacy[] = array("value" => "ALL_FRIENDS", "text" => "友達");
                $optionPrivacy[] = array("value" => "SELF", "text" => "自分のみ");
                break;
            case "SELF":
                $optionPrivacy[] = array("value" => "SELF", "text" => "自分のみ");
                break;
        }
        return $optionPrivacy;
    }
}