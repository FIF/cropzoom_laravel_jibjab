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
                ▼STEP 1.【Adjustment of position】<br>
                1）Select an image by tapping (Click) and display it in front of the frame.<br>
                2）Adjust the position by moving the image up, down, left and right. Release the tap (Click) to return to the preview screen.<br><br>
                ▼STEP 2.【Size adjustment】<br>
                You can zoom in / out by sliding the right bar up and down.<br><br>
                ▼STEP 3.【角度の調整】<br>
                You can adjust the angle by sliding the left bar up and down.<br><br>
                When adjustment is completed, please push the following [>] button.
            </div>
            <div class="btn_block">
                <ul>
                    <li><a class="btn btn_back_02" href="{{ url('screens/screen04') }}">back</a></li>
                    <li><a class="btn btn_composite" href="#" id="btnCrop">Crop</a></li>
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
    // The width and height of the sample face is hard coded.
    // TODO This ratio should be set to standard config For different videos and face.

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