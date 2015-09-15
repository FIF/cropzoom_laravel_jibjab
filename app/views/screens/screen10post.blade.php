@extends('layouts.main')

@section('content')
<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
    </header>
    <div id="body">
        <main id="main">
            <div class="visual"><img src="{{ Session::get('final_thumbnail') }}" alt=""></div>
            <div class="social_block">
                <p>動画をこのアプリ以外で楽しむなら</p>
                <div class="btn_block vertical margin_s">
                    <ul>
                        <li><a class="btn btn_fb-post" href="{{ url('screens/screen10') }}">Facebookに投稿</a></li>
                        <li><a class="btn btn_yt-post_02" href="{{ url('screens/screen10yt') }}">Youtubeに投稿</a></li>
                    </ul>
                </div>
            </div>
            <div class="btn_block vertical margin_s">
                <ul>
                    <li><a id="btnMakeAnother" class="btn btn_makeanother" href="#">MAKE ANOTHER</a></li>
                </ul>
                <p class="btn_block__stxt">※投稿していない場合、生成した動画は保持されません。</p>
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
