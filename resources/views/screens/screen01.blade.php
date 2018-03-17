@extends('layouts.main')

@section('head')
<script type="text/javascript">
    function show_alert() {
      setTimeout(function() {
            alert("The browsing environment in use does not guarantee the operation. Please enjoy "You can be BOATNYA!" Application with the latest device.");
      }, 30);     
    };
    function getInternetExplorerVersion()
    // Returns the version of Windows Internet Explorer or a -1
    // (indicating the use of another browser).
    {
       var rv = -1; // Return value assumes failure.
       if (navigator.appName == 'Microsoft Internet Explorer')
       {
          var ua = navigator.userAgent;
          var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
          if (re.exec(ua) != null)
             rv = parseInt( RegExp.$1 );
       }
       return rv;
    }
    window.onload = function() { if((getInternetExplorerVersion() <= 9) && (getInternetExplorerVersion() > 0)) show_alert(); };
</script>
@stop
@section('content')

<div id="all">
    <header id="header" class="index">

    </header>
    <div class="btn_block index01">
        <ul>
            <li><a class="btn btn_fb-login_01" href="{{ $loginUrl }}">Login and start!!</a></li>
        </ul>
    </div>
    <div id="body">
        <main id="main">
            <section class="about">
                <div class="system">With this content you can post your original CM video to Facebook and Youtube by applying your or your friends face to Boat Mey red.<br>
                    You now become sexy boat meow red and share it to your friends!</div>
                <div class="img"><img src="{{ url('asset/img/index') }}/img_01.jpg" alt=""></div>
                <div class="movie">
                    <p class="movie__txt">【Sample Video CHECK!】</p>
                    <div class="video-container">
                         <iframe width="853" height="480" src="//www.youtube.com/embed/5hE-1TWjwKQ?rel=0" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="btn_block index02">
                    <ul>
                        <li><a class="btn btn_fb-login_01" href="{{ $loginUrl }}">Login and start!!</a></li>
                    </ul>
                </div>
                <div class="policy_table">
                    <table>
                        <tr>
                            <td><a href="{{ url('screens/screen13') }}">Terms of service</a></td>
                            <td><a href="{{ url('screens/screen15') }}">Recommended environment</a></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="width100p"><a href="{{ url('screens/screen14') }}" target="_blank">個人情報保護方針</a></td>
                        </tr>
                    </table>
                </div>
                <div>BOATRACE<br><br>
                    <span>Copyright ©Your Company Official Web All rights reserved.</span></div>
            </section>
        </main><!-- #main -->
    </div><!-- #body -->
</div><!-- #all -->
@stop

@section('script')
<script type="text/javascript">
    $(function(){
        checkAgent();
    });

    function getAgent() {
        return navigator.userAgent;
    }

    function checkAgent() {
        var android = getAndroidVersion();
        var ios = getiOSVersion();

        if((parseInt(android) <= 2) && (android !== false)) show_alert();
        if(typeof ios[0] != 'undefined') {
            if(ios[0] <= 6) show_alert();
        }
    }

    function getAndroidVersion(ua) {
        var ua = ua || navigator.userAgent; 
        var match = ua.match(/Android\s([0-9\.]*)/);
        return match ? match[1] : false;
    }

    function getiOSVersion() {
        if (/iP(hone|od|ad)/.test(navigator.platform)) {
            // supports iOS 2.0 and later: <http://bit.ly/TJjs1V>
            var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/);
            return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)];
        }
    }
</script>
@stop