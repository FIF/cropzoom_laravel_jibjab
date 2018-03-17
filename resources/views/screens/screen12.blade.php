@extends('layouts.main')

@section('content')

<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
    </header>
    <div id="body">
        <main id="main">
            <div class="btn_block vertical finish">
                <p class="finish__message">Youtube post to the list is complete<br/>(Please wait for about 5 minutes to reflect posting)</p>
                <p class="finish__message"><a class="openwindow" href="https://www.youtube.com/" target="_blank">Youtubeで投稿内容を確認する</a></p>
                <ul>
                    <li><a class="btn btn_play-again_02" href="{{ url('screens/screen09') }}">PLAY again</a></li>
                    <li><a id="btnMakeAnother" class="btn btn_makeanother" href="#">MAKE ANOTHER</a></li>
                </ul>
                <p class="finish__message">Posting by posting account:<br><br>
                    ［&nbsp;<a href="{{ url('youtube/logout') }}">Youtube log out</a>&nbsp;］<br><br>
                    ※ move to the posting screen
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
            if (confirm("When you press OK, the created composite video is deleted.")){
                location.href = "{{ url('screens/screen04') }}";
            }
        });
    })
</script>

@stop
