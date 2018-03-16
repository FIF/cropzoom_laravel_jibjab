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
                <p>If you enjoy moving pictures outside this app</p>
                <div class="btn_block vertical margin_s">
                    <ul>
                        <li><a class="btn btn_fb-post" href="{{ url('screens/screen10') }}">Facebook post</a></li>
                        <li><a class="btn btn_yt-post_02" href="{{ url('screens/screen10yt') }}">Youtube post</a></li>
                    </ul>
                </div>
            </div>
            <div class="btn_block vertical margin_s">
                <ul>
                    <li><a id="btnMakeAnother" class="btn btn_makeanother" href="#">MAKE ANOTHER</a></li>
                </ul>
                <p class="btn_block__stxt">※If you do not post it, the generated video is not retained.</p>
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
