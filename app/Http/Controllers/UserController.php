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
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // トップページ
    public function getTop() {
        $title = 'トップページ';
        return view('praise.top',[
            'title' => $title,
        ]);
    }
    
    // ログイン
    public function signin(Request $request) {
        // バリデーション
        $this->validate($request,[
            'name' => 'required',
            'password' => 'required',
        ]);
        
        if(Auth::attempt(['name' => $request->input('name'), 'password' => $request->input('password')])){
            return redirect('/mypage');
        }
        return redirect()->back();
    }
    
    // ユーザー登録ページ
    public function getUserSignup() {
        $title ='ユーザー登録';
        return view('praise.userSignup',[
            'title' => $title,
        ]);
    }
    
    // ユーザー登録
    public function postUserSignup(Request $request) {
        $hashedPassword = \App\Models\Company::select('password')->where('company_name', $request->input('companyName'))->first();
        if (Hash::check($request->input('companyPassword'), $hashedPassword['password'])) {
        
            // バリデーション
            $this->validate($request,[
                'userName' => 'required|unique:users,name',
                'userPassword' => 'required|min:6',
            ]);
            
            $company = \App\Models\Company::where('company_name', $request->input('companyName'))->get();
            // その会社で初めて登録する場合はmanage=1とする
            if (\App\Models\User::where('company_id', $company[0]['id'])->exists()) {
                // DBインサート
                $user = new User([
                    'name' => $request->input('userName'),
                    'password' => bcrypt($request->input('userPassword')),
                    'company_id' => $company[0]['id'],
                ]);
            
            } else {
                // DBインサート
                $user = new User([
                    'name' => $request->input('userName'),
                    'password' => bcrypt($request->input('userPassword')),
                    'company_id' => $company[0]['id'],
                    'manage' => 1,
                ]);
            }
            
            // 保存
            $user->save();
            
            // リダイレクト
            return redirect('/top')->with('success','登録しました');
        
        } else {
            return back()->with('error', '会社名または会社パスワードが異なります。');
        }
        
    }
    
    /*
    // トップページに登録完了結果を表示へ変更
    // ユーザー登録完了ページ
    public function getUserRegister() {
        $title = 'ユーザー登録完了';
        return view('praise.userRegister',[
            'title' => $title,
        ]);
    }
    */
    
    
    
    
    // ログアウト
    public function getLogout() {
        Auth::logout();
        return redirect('/top');
    }
    
    
    
    // 社員一覧ページ
    public function getList(Request $request) {
        $title = '社員一覧';
        $user = Auth::user();
         
        if(!empty($request->input('keyword'))){
            $keyword = $request->input('keyword');
            $users = DB::table('users')
                    ->leftjoin('messages','receive_user_id', '=','users.id')
                    ->where('users.id', '!=', Auth::id())
                    ->where('company_id', $user['company_id'])
                    ->where('name', 'like', '%'.$keyword.'%')
                    ->orderBy(DB::raw('count(IFNULL(receive_user_id, 0))'))
                    ->groupBy('name')
                    ->get();
        } else {
        
            $users = DB::table('users')
                        ->leftjoin('messages','receive_user_id', '=','users.id')
                        ->where('users.id', '!=', Auth::id())
                        ->where('company_id', $user['company_id'])
                        ->orderBy(DB::raw('count(IFNULL(receive_user_id, 0))'))
                        ->groupBy('name')
                        ->get();
        }
        
        return view('praise.list',[
            'title' => $title,
            'users' => $users,
        ]);
        
        
    }
    
    // ランキングページ
    public function getRank() {
        $title = 'ランキング';
        // ポイント上位5人について取得
        $users = \App\Models\User::
                    select(
                        'name',
                        'point',
                        DB::raw('RANK() OVER(ORDER BY point DESC) AS rank')
                    )
                    ->orderBy('point', 'DESC')
                    ->where('company_id', Auth::user()->company_id)
                    ->take(5)
                    ->get();

        return view('praise.rank',[
            'title' => $title,
            'users' => $users,
        ]);
    }
    
    // 管理者用ページ
    public function getManage(Request $request) {
        // 管理者でなければマイページへリダイレクト
        if (Auth::user()->manage !== 1) {
            return redirect('/mypage');
        } else {
            $title = '管理者用ページ';
            // 管理者人数カウント
            $countManage = \App\Models\User::where('manage', 1)->where('company_id', Auth::user()->company_id)->count();
            // 検索された場合
            if  (!empty($request->input('keyword'))){
                $keyword = $request->input('keyword');
                $users = \App\Models\User::select('id','name', 'point', 'manage')
                                            ->where('company_id', Auth::user()->company_id)
                                            ->where('name', 'like', '%'.$keyword.'%')
                                            ->orderBy('point')
                                            ->get();
            } else {
                $users = \App\Models\User::select('id','name', 'point', 'manage')
                                            ->where('company_id', Auth::user()->company_id)
                                            ->orderBy('point')
                                            ->get();
            }
            return view('praise.manage',[
                'title' => $title,
                'users'=> $users,
                'countManage' => $countManage,
            ]);
        } 
    }
    
    // 管理者権限の変更
    public function postManage(Request $request) {
        // バリデーション
        $this -> validate($request,[
            'userId' => 'required|integer'
        ]);
        $userId = $request -> input('userId');
        $user = \App\Models\User::select('manage')->find($userId);
        if ($user['manage'] === 1) {
            \App\Models\User::where('id', $userId)->update(['manage' => 0]);
        } elseif($user['manage'] === 0) {
            \App\Models\User::where('id', $userId)->update(['manage' => 1]);
        } 
        
        return back()->with('success', '管理者権限を変更しました');
    }
    
}
