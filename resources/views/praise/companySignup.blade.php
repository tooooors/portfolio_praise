@extends('layouts.default')

@section('title',$title)

@section('content')
<div class="container text-center" style="width: 600px;">
    <h1>会社新規登録</h1>
    <p>任意の会社名とパスワードをご記入ください。</p>
    <form method="post" action="{{ url('/companySignup') }}">
        <div class="form-group mt-3 text-left">
            <label for="companyName">会社名</label>
            <input class="form-control" type="text" name="companyName" id="companyName">
        </div>
        <div class="form-group mt-3 text-left">
            <label for="companyPassword">パスワード</label>
            <input class="form-control" type="password" name="password" id="companyPassword">
        </div>
        <input type="submit" class="btn mt-3" value="新規登録">
        {{ csrf_field() }}
    </form>
</div>
@endsection