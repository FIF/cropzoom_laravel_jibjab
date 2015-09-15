@extends('layouts.main')

@section('content')

<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
    </header>
    <div id="body">
        <main id="main">
            @if (isset($authUrl))
            <div class="btn_block accesstoken vertical">
                <ul>
                    <li><a class="btn btn_apply" href="{{ $authUrl }}">Youtube承認画面へ</a></li>
                </ul>
            </div>
            @elseif (isset($accessToken))
            The access token has been added to your database: <b>{{ $accessToken }}</b> now <a href="/videos">try an upload</a>
            @else
            {{ Form::open(array('url' => 'youtube/videos', 'id' => 'ytForm')) }}
            <div class="visual"><img src="{{ url('asset/img') }}/main-visual_yt.png" alt=""></div>
            <div class="input">
                <p class="input__title-wrap"><input type="text" name="title" class="input__title-area" placeholder="タイトルを入力してください。"><?php if($errors) echo $errors->first('title'); ?></p>
                <p class="input__detail-wrap"><textarea name="description" class="textarea info" placeholder="説明"></textarea></p>
                <div class="input__scopesetting-wrap bgwhite">
                    <table class="input__scopesetting">
                        <col style="width: 30px;">
                        <col>
                        <tr>
                            <th><input type="radio" id="public" name="scope" value="public"></th>
                            <td><label for="public">公開<br><span>誰でも検索と再生ができます</span></label></td>
                        </tr>
                        <tr>
                            <th><input type="radio" id="limited" name="scope" value="unlisted"></th>
                            <td><label for="limited">限定公開<br><span>リンクを知っている人が再生可能</span></label></td>
                        </tr>
                        <tr>
                            <th><input type="radio" id="secret" name="scope" value="private"></th>
                            <td><label for="secret">非公開<br><span>指定した人のみ再生可能</span></label></td>
                        </tr>
                    </table>
                </div>
                <?php if($errors) echo $errors->first('status'); ?>
            </div>
            <div class="btn_block vertical margin_s">
                <ul>
                    <li><a class="btn btn_yt-post_02" href="#" id="btnYtUpload">Youtubeに投稿</a></li>
                </ul>
            </div>
            {{ Form::close() }}
            @endif
        </main><!-- #main -->
    </div><!-- #body -->
</div><!-- #all -->

@stop

@section('script')

<script type="text/javascript">
    $(function(){
        $("#btnYtUpload").click(function(){
            $("#ytForm").submit();
        });
    })
</script>

@stop