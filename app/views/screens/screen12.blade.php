@extends('layouts.main')

@section('content')

<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
    </header>
    <div id="body">
        <main id="main">
            <div class="btn_block vertical finish">
                <p class="finish__message">Youtubeへの投稿が完了しました。<br/>（投稿反映まで5分程お待ちください）</p>
                <p class="finish__message"><a class="openwindow" href="https://www.youtube.com/" target="_blank">Youtubeで投稿内容を確認する</a></p>
                <ul>
                    <li><a class="btn btn_play-again_02" href="{{ url('screens/screen09') }}">もう一度PLAY</a></li>
                    <li><a id="btnMakeAnother" class="btn btn_makeanother" href="#">MAKE ANOTHER</a></li>
                </ul>
                <p class="finish__message">アカウントを切替えて投稿する場合：<br><br>
                    ［&nbsp;<a href="{{ url('youtube/logout') }}">Youtubeをログアウト</a>&nbsp;］<br><br>
                    ※投稿画面に移動します
                </p>
            </div>
        </main><!-- #main -->
    </div><!-- #body -->
</div><!-- #all -->

@stop

@section('script')

<script type="text/javascript">
    $(function(){
        $("#btnMakeAnother").click(function(){
            if (confirm("OKを押すと、作成した合成動画が消去されます。")){
                location.href = "{{ url('screens/screen04') }}";
            }
        });
    })
</script>

@stop
