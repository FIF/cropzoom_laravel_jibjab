@extends('layouts.main')

@section('content')

<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
    </header>
    <div id="body">
        <main id="main">
            <h2 class="title__fb">画像を選択</h2>
            <div id="scrollbar1">
                <div class="scrollbar pc" style="width: 0px;"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                <div class="viewport">
                    <div class="overview select_lists choosing sp">
                        @if ($photos)
                            @foreach ($photos as $photo)
                                <a href="{{ url('screens/screen06-from-fb') }}/{{ $photo['id'] }}"><img style="background-image:url('{{ $photo['img'] }}')" alt="" class="uiThumb"></a>
                            @endforeach
                        @endif
                    </div><!-- .overview -->
                </div><!-- .viewport -->
            </div><!-- .select_lists -->
            <div class="btn_block vertical margin_s">
                <ul>
                    <li><a class="btn btn_prev-album" href="{{ url('facebook/albums') }}">アルバム一覧へ戻る</a></li>
                </ul>
            </div>
        </main><!-- #main -->
    </div><!-- #body -->
</div><!-- #all -->

@stop

@section('script')
{{ HTML::script('asset/js/jquery.tinyscrollbar.min.js') }}
<script type="text/javascript">
    if ((navigator.userAgent.indexOf('iPhone') > 0 && navigator.userAgent.indexOf('iPad') == -1) || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0) {
        $(".select_lists.choosing").css({
            'overflow-y': 'scroll',
            'width': 300,
            'height': 300
        });
    } else {
        $(document).ready(function(){
            $('#scrollbar1').tinyscrollbar();
        });
    }
</script>

@stop