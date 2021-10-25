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

class CompanyController extends Controller
{
    // 会社登録ページ
    public function getCompanySignup() {
        $title = '会社登録';
        return view('praise.companySignup',[
            'title' => $title,
        ]);
    }
    
    // 会社新規登録
    public function postCompanySignup(Request $request) {
        // バリデーション
        $this->validate($request,[
            'companyName' => 'required|unique:companies,company_name',
            'password' => 'required|min:6',
        ]);
        
        // DBインサート
        $company = new Company([
            'company_name' => $request->input('companyName'),
            'password' => Hash::make($request->input('password')),
        ]);
        
        // 保存
        $company->save();
        
        // リダイレクト
        return redirect('/top')->with('success','登録しました');
    }
    
    /*
    // トップページに登録完了結果表示に変更
    // 会社登録完了ページ
    public function getCompanyRegister() {
        $title = '会社登録完了';
        return view('praise.companyRegister',[
            'title' => $title,
        ]);
    }
    */
}
