@extends('layouts.main')

@section('content')
{{ Form::open(array('url' => url('facebook/upload-videos'), 'id' => 'fbForm')) }}
    <div id="all">
        <header id="header">
            <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
        </header>
        <div id="body">
            <main id="main">
                <div class="visual"><img src="{{ Session::get('final_thumbnail') }}" alt=""></div>
                <div class="select">
                    <select name="scopesetting" id="scopesetting" class="select__scopesetting">
                            <option value="0" disabled selected>▼Open scope：</option>
                            @foreach ($optionPrivacy as $option)
                                <option value="{{ $option['value'] }}">{{ $option['text'] }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="input bgwhite">
                    <p class="input__detail-wrap"><textarea name="comment" class="textarea"></textarea></p>
                </div>
                <div class="btn_block vertical margin_s">
                    <ul>
                        <li><a class="btn btn_fb-post" id="fbProcess" href="#">facebook post</a></li>
                        <li><a class="btn btn_play-again_02" href="{{ url('screens/screen09') }}">PLAY AGAIN</a></li>
                    </ul>
                </div>
            </main><!-- #main -->
        </div><!-- #body -->
    </div><!-- #all -->
{{ Form::close() }}
@stop

@section('script')

<script type="text/javascript">
    $(function(){
        $("#fbProcess").click(function(){
            if ($("#scopesetting").val() != null) {
                $('#fbForm').submit();
            }
        });
    })
</script>

@stop