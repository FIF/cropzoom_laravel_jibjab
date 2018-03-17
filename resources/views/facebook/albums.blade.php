@extends('layouts.main')

@section('content')

<div id="all">
    <header id="header">
        <h1 class="app_name"><a href="{{ url('/') }}">You can be BOATNYA!</a></h1>
    </header>
    <div id="body">
        <main id="main">
            <h2 class="title__fb">Facebookから選ぶ</h2>
            <div class="select_lists">
                @if ($albums)
                    @foreach ($albums as $album)
                        <div class="list">
                            <a href="{{ url('facebook/album') }}/{{ $album['id'] }}">
                                <p class="img">{{ $album['img'] }}</p>
                                <table>
                                    <tr>
                                        <td>{{ $album['name'] }}</td>
                                        <td>{{ $album['count'] }}</td>
                                    </tr>
                                </table>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div><!-- .select_lists -->
            <div class="btn_block vertical margin_s">
                <ul>
                    <li><a class="btn btn_back-L" href="{{ url('screens/screen04') }}">写真選択へ戻る</a></li>
                </ul>
            </div>
        </main><!-- #main -->
    </div><!-- #body -->
</div><!-- #all -->


@stop