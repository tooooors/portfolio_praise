@extends('layouts.default')

@section('title',$title)

@section('content')
<div class="container">
    <div class="offset-2 col-8">
        <h1>社員一覧</h1>
        <p class="mb-3">表示が上の人を褒めるほどポイントアップします。</p>
        <h2 class="h3">社員検索</h2>
        <form class="form-inline" action="{{ url('/list') }}">
            <div class="form-group mr-2">
                <input type="text" name="keyword" class="form-control" style="width: 300px;" placeholder="名前を入力してください">
            </div>
            <input type="submit" value="検索" class="btn search_btn">
        </form>
        @foreach($users->all() as $user)
        <div class="mt-3 row border-bottom mx-0" style="border-color: #ddd; background-color: #eee; width: 600px;">
            <div class="col-10 mt-1">
                <p>{{ $user->name }}</p>
            </div>
            <div class="col-2 mt-1">
                <form method="get" action="{{ url('/praise') }}">
                    <input type="hidden" name="userName" value="{{ $user->name }}">
                    <input type="submit" class="btn praise_btn" value="褒める">
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection