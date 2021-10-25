@extends('layouts.default')

@section('title',$title)

@section('content')
<div class="container text-center" style="width: 600px;">
    <h1>ユーザー新規登録</h1>
    <form method="post" action="{{ url('/userSignup') }}">
        <h2 class="mt-5 text-left">ユーザー情報</h2>
        <p class="text-left">任意のユーザー名とパスワードをご記入ください。</p>
        <div class="form-group mt-3 text-left">
            <label for="userName">ユーザー名</label>
            <input class="form-control" type="text" id="userName" name="userName">
        </div>
        <div class="form-group mt-3 text-left">
            <label for="userPassword">ユーザーパスワード</label>
            <input class="form-control" type="password" id="userPassword" name="userPassword">
        </div>
        <h2 class="mt-3 text-left">会社情報</h2>
        <p class="text-left">会社から指定されたものをご記入ください。</p>
        <div class="form-group mt-3 text-left">
            <label for="companyName">会社名</label>
            <input class="form-control" type="text" id="companyName" name="companyName">
        </div>
        <div class="form-group mt-3 text-left">
            <label for="companyPassword">会社パスワード</label>
            <input class="form-control" type="password" id="companyPassword" name="companyPassword">
        </div>
        <input type="submit" class="btn mt-3" value="新規登録">
        {{ csrf_field() }}
    </form>
</div>
@endsection