<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="{{ asset('css/app.css')}}" rel="stylesheet">
        <link href="css/default.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <script src="{{asset('js/app.js')}}"></script>
        <title>@yield('title')</title>
    </head>
    <body>
        <div class="container-fluid p-1">
            <nav class="navbar navbar-expand navbar-light bg-light fixed-top border-bottom">
                <a href="{{ url('/mypage') }}" class="navbar-brand"><img src="/img/logo.png"></a>
                <ul class="navbar-nav">
                    @if(Auth::check())
                    <li class="nav-item"><a href="{{ url('/mypage') }}" class="nav-link">マイページ</a></li>
                    <li class="nav-item"><a href="{{ url('/list') }}" class="nav-link">社員一覧</a></li>
                    <li class="nav-item"><a href="{{ url('rank') }}" class="nav-link">ランキング</a></li>
                    @if(Auth::user()->manage === 1)
                    <li class="nav-item"><a href="{{ url('/manage') }}" class="nav-link">管理者用ページ</a></li>
                    @endif
                    @else
                    <li class="nav-item"><a href="{{ url('/top') }}" class="nav-link">トップ</a></li>
                    <li class="nav-item"><a href="{{ url('/userSignup') }}" class="nav-link">ユーザー登録</a></li>
                    <li class="nav-item"><a href="{{ url('/companySignup') }}" class="nav-link">会社登録</a></li>
                    @endif
                </ul>
                @if(Auth::check())
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><div class="nav-link" style="pointer-events: none;">{{ Auth::User()->name }}さん　現在{{ Auth::User()->point }}ポイント</div></li>
                    <li class="nav-item"><a href="{{ url('/logout') }}" class="nav-link">ログアウト</a></li>
                </ul>
                @endif
            </nav>
        </div>
        <div class="pb-5" style="padding-top: 150px; color: #706c62;">
            @if(session()->exists('success'))
                <p class="text-center mx-auto mb-5 p-2" style="background-color: #d2fadf; width: 600px;">{{ session('success') }}</p>
            @endif
            @if(session()->exists('error'))
                <p class="text-center mx-auto mb-5 p-2" style="background-color: #fad2d2; width: 600px;">{{ session('error') }}</p>
            @endif
            @if(isset($errors))
            <div class="mb-5">
            @foreach($errors->all() as $error)
            <p class="text-center mx-auto p-2" style="background-color: #fad2d2; width: 600px;">{{ $error }}</p>
            @endforeach
            </div>
            @endif
        @yield('content')
        </div>
        <script>$('[data-toggle="tooltip"]').tooltip()</script>
    </body>
</html>