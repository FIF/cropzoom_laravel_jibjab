@extends('layouts.main')

@section('content')


<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
        <p class="save_photo"><a href="#">合成PHOTOをアルバムに保存</a></p>
    </header>
    <div id="body">
      <main id="main">
        <div class="composite">
            <div class="composite__img"><img src="{{ Session::get('faceImgC') }}" alt="" style="height:205px; width:auto"></div>
        </div><!-- #composite -->
        <div class="btn_block">
          <ul>
            <li><a class="btn btn_back_02" href="{{ url('screens/screen06') }}">back</a></li>
            <li><a class="btn btn_play" href="#" id="btnVideoProcess">合成</a></li>
          </ul>
        </div>
      </main><!-- #main -->
    </div><!-- #body -->
</div><!-- #all -->


@stop

@section('script')

<script type="text/javascript">
    $(function(){
        $("#btnVideoProcess").click(function(){
            $("body").addClass("loading");
            $.get("{{ url('screens/video-process') }}", function(data){
                $("body").removeClass("loading");
                location.href = '{{ url("screens/screen09") }}';
            });
        });

        $(".save_photo").click(function(){
            if(detectmob() === true) {
//                closeOnLoad('{{ url("screens/pic-download") }}');
                location.href = '{{ url("screens/screen08") }}';
            } else {
                location.href = '{{ url("screens/pic-download") }}';
            }
        });
    })

    function detectmob() { 
     if( navigator.userAgent.match(/Android/i)
         || navigator.userAgent.match(/webOS/i)
         || navigator.userAgent.match(/iPhone/i)
         || navigator.userAgent.match(/iPad/i)
         || navigator.userAgent.match(/iPod/i)
         || navigator.userAgent.match(/BlackBerry/i)
         || navigator.userAgent.match(/Windows Phone/i)
     ){
        return true;
      }
     else {
        return false;
      }
    }
    function closeOnLoad(myLink) {
      var newWindow = window.open(myLink);
      setTimeout(
                 function()
                 {
                   newWindow.close();
                 },
                 5000
                );
      };
</script>

@stop