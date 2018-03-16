@extends('layouts.main')

@section('content')
<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
    </header>
    <div id="body">
        <main id="main" style="padding: 1em 1em 60px;">
            <p style="padding-top: 30px;font-size: 132%;">Recommended environment</p><br><br>

            ■smartphone<br>
            ・iOS 7.0以降<br>
            ・Android 4.0以降<br>
            ※OS Browser applications other than the default browser are deprecated
            <br><br>

            ■PC<br>
            Chrome, Firefox, Safari 各最新版<br>
            Internet Explorer 10 以降<br>
            ※HTML5/CSS3 Browsers that officially support
            <br><br>

        </main><!-- #main -->
    </div><!-- #body -->
</div><!-- #all -->
@stop