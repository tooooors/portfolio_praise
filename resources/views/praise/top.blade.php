@extends('layouts.default')

@section('title',$title)

@section('content')
<div class="container text-center" style="width: 600px;">
    <h1>ほめほめ社内SNS</h1>
    <p>褒めて褒められプラスのコミュニケーションがとれる社内SNSです。</p>
    <h2 class="mt-5">ログイン</h2>
    <form method="post" action="{{ url('/signin') }}">
        <div class="form-group mt-3 text-left">
            <label for="name">ユーザー名</label>
            <input class="form-control" type="text" id="name" name="name">
        </div>
        <div class="form-group mt-3 text-left">
            <label for="password">パスワード</label>
            <input class="form-control" type="password" id="password" name="password">
        </div>
        <input type="submit" class="btn mt-3" value="ログイン">
        {{ csrf_field() }}
    </form>
    <h3 class="mt-5">はじめての方はコチラから</h3>
    <a class="btn mt-3" href="{{ url('/userSignup') }}">ユーザー登録</a><br>
    <a class="btn mt-3" href="{{ url('/companySignup') }}">会社登録</a>
</div>
@endsection