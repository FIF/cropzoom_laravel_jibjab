@extends('layouts.main')

@section('content')

<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
    </header>
    <div id="body">
        <main id="main">
            <video width="320" height="240" src="{{ Session::get('final_video') }}">
            </video>
            <div class="btn_block">
                <ul>
                    <li><a class="btn btn_back_02" href="{{ url('screens/screen07') }}">back</a></li>
                    <li><a class="btn btn_next-S" href="{{ url('screens/screen10post') }}">next</a></li>
                </ul>
            </div>
        </main><!-- #main -->
    </div><!-- #body -->
</div><!-- #all -->

@stop

@section('script')

<script>
    // using jQuery
    $('video,audio').mediaelementplayer(/* Options */);
</script>

@stop