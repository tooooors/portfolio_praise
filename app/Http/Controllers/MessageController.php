<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    // マイページ
    public function getMypage() {
        $title = 'マイページ';
        $messages = \App\Models\Message::where('receive_user_id', Auth::id())->where('status', 0)->get();
        //return var_dump(count($messages));
        
        return view('praise.mypage',[
            'title' => $title,
            'messages' => $messages,
        ]);
        
        
        
    }
    
    // 褒め言葉通報
    public function postReport(Request $request) {
        // バリデーション
        $this->validate($request,[
            'id' => 'required|integer',
        ]);
        
        //ステータスを1にする（非表示にする） 
        \App\Models\Message::where('id', $request->input('id'))->update(['status' => 1]);
        $id = (int)$request->input('id');
        // 送信者のIDを得る
        $send_user = \App\Models\Message::find($id);
        $send_user_id = $send_user['send_user_id'];
        
        // 送信者のポイントを-1する
        \App\Models\User::where('id', $send_user_id)->decrement('point',1);
        
        // リダイレクト
        return back()->with('success', '通報完了しました');
    
    }
    
    // 褒め言葉登録ページ
    public function getPraise(Request $request) {
        if (isset($_GET['userName'])) {
        $title = '褒め言葉登録';
        $receiveUser = \App\Models\User::where('name', $request->input('userName'))->get();
        return view('praise.praise',[
            'title' => $title,
            'receiveUser' => $receiveUser[0],
        ]);
        } else {
            return redirect('/list');
            exit;
        }
    }
    
    // 褒め言葉登録
    public function postPraise(Request $request) {
        // バリデーション
        $this->validate($request,[
            'message' => 'required',
            'receiveUserId' => 'required',
        ]);
        
        
        //$point = \App\Models\Message::selectRaw('RANK() OVER(ORDER BY count(receive_user_id) DESC) as point')->where('receive_user_id', $request->input('receiveUserId'));
       
        $counter = \App\Models\Message::select(DB::raw('COUNT(*) AS count'))->where('receive_user_id','=',$request->input('receiveUserId'))->/*groupBy('receive_user_id')->*/get();
        $counter = (int)$counter[0]->count;
        if($counter === false){
            $point = ceil(10 / sqrt($counter));
        }else{
            $point = 10;
        }
        
        // DBインサート
        $message = new Message([
            'message' => $request->input('message'),
            'send_user_id' => Auth::id(),
            'receive_user_id' => $request->input('receiveUserId'),
        ]);
        
        //$user = new User;
        //$user -> where('id', Auth::id())->increment('point', $point);
        
        // 保存
        $message->save();
        //$user->save();
        $user = Auth::User();
        $user->point += $point;
        $user->update();
        
        // リダイレクト
        return redirect('/list')->with('success','褒め言葉を送信しました。');
        
    }
}
