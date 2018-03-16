@extends('layouts.main')

@section('content')


<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
    </header>
    <div id="body">
      <main id="main">
        <div class="composite preview">
            <div class="composite__img"><img src="{{ Session::get('faceImgC') }}" alt="" style="height:205px; width:auto"></div>
        </div><!-- #composite -->
        <div class="btn_block finish">
            <p class="finish__message"> 【Save PHOTO】<br>
        Touch the image and press and hold "Save Image".</p>
          <ul>
            <li><a class="btn btn_back-L" href="{{ url('screens/screen07') }}">back</a></li>
          </ul>
        </div>
      </main><!-- #main -->
    </div><!-- #body -->
</div><!-- #all -->

@stop