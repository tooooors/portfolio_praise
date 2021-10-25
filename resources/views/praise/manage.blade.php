@extends('layouts.default')

@section('title',$title)

@section('content')
<div class="container">
    <div class="offset-2 col-8">
        <h1 class="mb-3">社員一覧</h1>
        <p>ポイント数の昇順です。</p>
        <p>管理者：{{ $countManage }}名</p>
        <h2 class="h3">社員検索</h2>
        <form class="form-inline" action="{{ url('/manage') }}">
            <div class="form-group mr-2">
                <input type="text" name="keyword" class="form-control" style="width: 300px;" placeholder="名前を入力してください">
            </div>
            <input type="submit" value="検索" class="btn search_btn">
        </form>
        @foreach($users->all() as $user)
        <div class="mt-3 row border-bottom mx-0 pt-1" style="border-color: #ddd; background-color: #eee; width: 750px;">
            <div class="col-4">
                <p>{{ $user->name }}</p>
            </div>
            <div class="col-3">
                <p>{{ $user->point }}ポイント</p> 
            </div>
            <div class="col-5 text-right">
                <form method="post" action="{{ url('/manage') }}">
                    <input type="hidden" name="userId" value="{{ $user->id }}">
                    @if ( $user->manage !== 1 )
                    <input type="submit" class="btn add_btn" value="管理者にする">
                    @else
                    @if ( $countManage !== 1 && $user->id !== Auth::id())
                    <input type="submit" class="btn dropdown_btn" value="管理者権限を無くす">
                    @endif
                    @endif
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection