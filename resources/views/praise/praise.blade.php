@extends('layouts.default')

@section('title',$title)

@section('content')
<div class="container text-center" style="width: 600px;">
    <h1>{{ $receiveUser->name }}さんを褒める</h1>
    <form method="post" action="/praise">
        <div class="form-group mt-5">
            <textarea class="form-control" name="message" col=250 row=20></textarea>
        </div>
        <input type="hidden" name="receiveUserId" value="{{ $receiveUser->id }}"> 
        <input type="submit" class="btn mt-3" value="送信">
        {{ csrf_field() }}
    </form>
</div>
@endsection