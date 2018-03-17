@extends('layouts.main')

@section('content')

<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
    </header>
    <div id="body">
        <main id="main">
            <div class="btn_block vertical finish">
                <p class="finish__message">Facebooks post has been completed.</p>
                <p class="finish__message"><a class="openwindow" href="https://www.facebook.com/" target="_blank">Facebook Confirm posting content with</a></p>
                <ul>
                    <li><a class="btn btn_play-again_02" href="{{ url('screens/screen09') }}">PLAY again</a></li>
                    <li><a id="btnMakeAnother" class="btn btn_makeanother" href="#">MAKE ANOTHER</a></li>
                </ul>
                <p class="finish__message">Posting by posting account:<br><br>
                    ［&nbsp;<a href="{{ url('facebook/logout') }}">FacebookLog out</a>&nbsp;］<br><br>
                    ※It will be reset to the start screen
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
