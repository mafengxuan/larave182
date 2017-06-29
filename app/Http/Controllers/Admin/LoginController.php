<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Hash;


class LoginController extends Controller
{   
    /*
        login 加载登录页面
    */
    public function getLogin()
    {
        //加载模板
        return view('admin.login.login');
    }

    /*
        验证登录
    */

    public function postDologin(Request $request)
    {
        // 验证码
        $code = session('code');

        $code2 = $request -> input('code');

        if($code != $code2){
            return back() -> with('error','验证码错误');
            exit;

        }

        $data = $request -> except('_token','code');

        //查询
        $res = DB::table('userinfo')->where('username',$data['username'])->first();
        if(!$res){
            return back() -> with('error','用户名不存在');

        }else{
            //用户名存在 检测密码
            if(Hash::check($data['password'],$res['password'])){
                session(['user_admin'=>$res]);
                //跳转到后台主页面
                return redirect('/admin/index/index');
            }else{
                return back() -> with('error','用户名或密码错误');
            }
        }

    }
}
