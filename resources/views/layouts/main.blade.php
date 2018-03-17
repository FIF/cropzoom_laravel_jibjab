<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="You can be BOATNYA! ダイナマイト ボートレース(Dynamite BOAT RACE)">
    <meta property="og:type" content="website">
    <meta property="og:description" content="『You can be BOATNYA!』では、ボートニャーレッドにあなたや友達の顔をあてはめて、オリジナルボートニャーダンス動画をFacebookやYoutubeに投稿できます。今すぐあなたもセクシーなボートニャーレッドになって、友達へシェア！">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content='{{ url("asset/img") }}/br_app_icon.png'>
    <meta property="og:site_name" content="You can be BOATNYA!">
    <meta property="og:email" content="info@dynamiteboatrace-fbapp.jp">
    <meta property="fb:app_id" content="871419956220400">
    <title>You can be BOATNYA! DYNAMITE BOAT RACE</title>
    <meta name="description" content="『You can be BOATNYA!』では、ボートニャーレッドにあなたや友達の顔をあてはめて、オリジナルボートニャーダンス動画をFacebookやYoutubeに投稿できます。今すぐあなたもセクシーなボートニャーレッドになって、友達へシェア！">
    <meta name="keywords" content="BOAT RACE,ボートレース,ボートニャー,オリジナルボートニャーダンス動画,BOATNYA,競艇,KYOTEI,CM,DYNAMITE BOAT RACE">
    {{ HTML::style('asset/css/main.css')}}
    {{ HTML::style('asset/css/style.css')}}
    {{ HTML::style('asset/css/mediaplayer/mediaelementplayer.css')}}
    {{ HTML::style('asset/css/tinyscrollbar.css')}}
    {{ HTML::script('asset/js/jquery.min.js') }}
    {{ HTML::script('asset/js/mediaelement-and-player.min.js') }}
    <style type="text/css">
                /* Start by setting display:none to make this hidden.
        Then we position it in relation to the viewport window
        with position:fixed. Width, height, top and left speak
        speak for themselves. Background we set to 80% white with
        our animation centered, and no-repeating */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255, .8) url('{{ url("asset/img") }}/loading.gif') 50% 50% no-repeat;
        }

        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .modal {
            display: block;
        }
    </style>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    @yield('head')
</head>

<body>

<div class="container">
    @if(Session::has('message'))
    <p class="alert">{{ Session::get('message') }}</p>
    @endif

    @yield('content')
</div>

<div class="modal"></div>
@yield('script')
</body>
</html>