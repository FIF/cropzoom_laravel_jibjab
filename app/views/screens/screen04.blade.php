@extends('layouts.main')

@section('content')
<div style="position:absolute; top:0; left:-3000px;">
    {{ Form::open(array('url' => 'screens/screen06', 'files' => true, 'class' => 'form-horizontal')) }}
        {{ Form::hidden('name', null) }}
        <input type="file" capture accept="image/*" id="cameraInput" name="cameraInput">
        <input type="file" id="galleryInput" name="galleryInput" title="Select From Gallery" accept="image/*">
        <div>
            <a class="file-input-wrapper btn btn-default" href="{{ url('facebook/albums') }}">
                <span>Select From Facebook</span>
            </a>
        </div>
    {{ Form::close() }}
</div>

<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
    </header>
  <div id="body">
    <main id="main">
      <div class="before_img">
        <img id="select_fb" src="{{ url('/asset/img') }}/img_before-composite.jpg" alt="">
      </div>
      <div class="btn_block vertical select_photo">
        <ul>
<!--          <li><a id="btnCamera" class="btn btn_take-photo" href="#">写真を撮る</a></li>-->
          <li><a id="btnAlbum" class="btn btn_select-img" href="#">画像を選ぶ</a></li>
          <li><a class="btn btn_fb-select" href="{{ url('facebook/albums') }}">Facebookから選ぶ</a></li>
        </ul>
        <p class="finish message">※Facebookアルバムの特性上、一部読み込めない画像がありますのでご了承ください</p>
      </div>
    </main><!-- #main -->
  </div><!-- #body -->
</div><!-- #all -->
@stop

@section('script')
<script type="text/javascript">
    $(function(){
        $('#btnCamera').click(function(){
            $('#cameraInput').click();
        });

        $('#btnAlbum').click(function(){
            $('#galleryInput').click();
        });
        $('input[type=file]').change(function(){
            if ($(this).val() != '') {
                $('input[name=name]').val(this.id);
                if (this.files[0].size != null && this.files[0].size >= 5120000){
                    setTimeout(function() {
                        alert("画像サイズがオーバーしています。5MB以内に収めてください。");
                    }, 30);
                }
                else
                    $('form').submit();
            }
        });
    })
</script>
@if (Session::has('S6Error'))
<script type="text/javascript">
    alert('{{ Session::get('S6Error') }}');
</script>
@endif

@stop