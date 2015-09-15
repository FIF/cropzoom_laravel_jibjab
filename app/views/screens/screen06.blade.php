@extends('layouts.main')

@section('head')

{{ HTML::style('asset/css/jquery-ui-1.10.3.custom.min.css') }}
{{ HTML::style('asset/css/jquery.cropzoom.css') }}
{{ HTML::script('asset/js/jquery-ui-1.10.3.custom.min.js') }}
{{ HTML::script('asset/js/jquery.cropzoom.js') }}
{{ HTML::script('asset/js/script.js') }}

@stop

@section('content')

<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
    </header>
    <div id="body">
        <main id="main">
            <div class="PostContent">
                <div class="boxes">
                    <div id="crop_container" style="margin-left: 17px !important"></div>
                    <div class="cleared"></div>
                </div>
                <br />
            </div>
            <div style="padding: 1em 1em 2em;">
                ▼STEP 1.【位置の調整】<br>
                1）画像をタップ（Click）で選択し、フレームの手前に表示させます。<br>
                2）画像を上下左右に移動させて位置を調整。タップ（Click）を放すとプレビュー画面に戻ります。<br><br>
                ▼STEP 2.【大きさの調整】<br>
                右のバーを上下にスライドさせることで、拡大／縮小できます。<br><br>
                ▼STEP 3.【角度の調整】<br>
                左のバーを上下にスライドさせることで、角度を調整することができます。<br><br>
                調整が完了したら、下記【合成 >】ボタンを押してください。
            </div>
            <div class="btn_block">
                <ul>
                    <li><a class="btn btn_back_02" href="{{ url('screens/screen04') }}">back</a></li>
                    <li><a class="btn btn_composite" href="#" id="btnCrop">合成</a></li>
                </ul>
            </div>
        </main><!-- #main -->
    </div><!-- #body -->
</div><!-- #all -->
@stop


@section('script')

<script type="text/javascript">
    
$(document).ready(function(){

    var objImage = new Image();
    objImage.src='{{ $file }}';

    var scale = parseFloat({{ $width/280 > $height/205 ? $width/280 : $height/205 }});
    // alert(scale);

    var cropzoom = $('#crop_container').cropzoom({
        width:280,
        height:205,
        bgColor: 'transparent',
        enableRotation:true,
        enableZoom:true,
        zoomSteps:5,
        rotationSteps:5,
        selector:{
            centered:false,
            borderColor:'blue',
            borderColorHover:'red',
            showPositionsOnDrag:true,
            showDimetionsOnDrag:true,
            aspectRatio:true,
            w:134,
            h:162,
            x:81,
            y:11
        },
        image:{
            rotation: 0,
            source:'{{ $file }}',
            width:{{ $width }},
            height:{{ $height }},
            minZoom:30,
            maxZoom:250,
            x:138 -{{ $width }}/(2*scale),
            y:102 -{{ $height }}/(2*scale)
        }
    });
    
    $('#btnCrop').click(function(){
        $("body").addClass("loading");
        cropzoom.send('{{ url("resize_and_crop") }}','POST',{},function(rta){
            $("body").removeClass("loading");
            location.href = '{{ url("screens/screen07") }}';
        });
    });

    $("img.ui-draggable").css("z-index", -99);
    $("img.ui-draggable").parent().find('#img-bg').css('z-index', 0);

    $("img.ui-draggable").mouseout(function() {
        $(this).css("z-index", -99);
        $(this).parent().find('#img-bg').css('z-index', 0);
    });
    $("img.ui-draggable").mouseup(function() {
        $(this).css("z-index", -99);
        $(this).parent().find('#img-bg').css('z-index', 0);
    });

    $("#img-bg").click(function() {
        $(this).css('z-index', -99);
        $(this).parent().find('img.ui-draggable').css('z-index', 0);
    });

    $('#img-bg').on('dragstart', function(event) { return false; });
    // $('#img-bg').on('click', function(event) { return false; });

    // $("img.ui-draggable").touchmove(function() {
    // });

    // $("img.ui-draggable").bind('touchstart touchmove click', function() {
    // })

    // $("#img-bg").mousedown(function() {
    //     $(this).css('z-index', -99);
    //     $(this).parent().find('img.ui-draggable').css('z-index', 0);
    // })
    
    });

</script>

@stop