@extends('layouts.default')

@section('title',$title)

@section('content')
<div class="container text-center">
    <h1>会社登録完了</h1>
    <p class="mt-3　h4">ユーザー名: {{ old('userName') }}</p>
    <p class="mt-3　h4">会社名: {{ old('companyName') }}</p>
    <a class="btn mt-5" href="{{ url('/top') }}">トップページに戻る</a>
</div>
@endsection