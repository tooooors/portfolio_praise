@extends('layouts.default')

@section('title',$title)

@section('content')
<div class="container">
    <div class="offset-2 col-8">
        <h1>マイページ</h1>
        @if (count($messages) === 0)
        <p class="mt-3 text-denger">{{ Auth::user()->name }}さんへの褒め言葉は0件です。</p>
        @else
        <p class="mt-3">{{ Auth::user()->name }}さんに届いた褒め言葉です。</p>
        @foreach($messages->all() as $message)
        <div class="mt-3 border-bottom mx-0 p-2" style="border-color: #ddd; background-color: #eee; width: 600px;">
            <div class="row">
                <div class="col-10 mt-1">
                    <p>{{ $message->message }}</p>
                </div>
                <div class="col-2 mt-1 px-1">
                    <a class="btn report_btn" href="#" data-toggle="modal" data-target="#report">通報</a>
                </div>
            </div>
            <p class="mt-1 text-right mb-0">{{ $message->created_at }}</p>
        </div>
        <div class="modal fade" id="report">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <button class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>        
                    </div>
                    <div class="modal-body">
                        <p>褒め言葉：{{ $message->message }} <br>本当に通報しますか？</p>
                        <div class="d-flex justify-content-end">
                            <a data-dismiss="modal" class="text-right mr-2 btn cancel_btn">キャンセル</a>    
                            <form method="post" class="text-right" action="{{ url('/report') }}">
                                <input type="hidden" name="id" value="{{ $message->id }}">
                                <input type="submit" class="btn report_btn" value="通報">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection