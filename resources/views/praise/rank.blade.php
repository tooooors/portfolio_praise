@extends('layouts.default')

@section('title',$title)

@section('content')
<div class="container">
    <div class="offset-2 col-8">
        <h1>ポイントランキング</h1>
        <p class="mb-3">沢山褒めて上位を目指しましょう！</p>
        @foreach($users->all() as $user)
        <p class="mt-3">{{ $user->rank }}位</p>
        <div class="row border-bottom mx-0 py-3" style="border-color: #ddd; background-color: #eee; width: 600px;">
            <div class="col-9">
                <p class="mb-0">{{ $user->name }}さん</p>
            </div>
            <div class="col-3">
                <p class="mb-0">{{ $user -> point }}ポイント</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection