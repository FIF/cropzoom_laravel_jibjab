@extends('layouts.main')

@section('content')

<div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="true" data-auto-logout-link="false"></div>
<div
    class="fb-like"
    data-send="true"
    data-width="450"
    data-show-faces="true">
</div>

<div id="album">
abc
</div>

@stop

@section('script')
<script type="text/javascript">
    $(function(){
        FB.api('/me', function(response) {
            $("#album").innerHTML(response);
        });
    })
</script>
@stop