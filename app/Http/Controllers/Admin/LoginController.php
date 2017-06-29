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

    //注册页面

    public function getAdd()
    {
        return view('admin.login.add');
    }

    //添加用户
    public function postInsert(Request $request)
    {
        //自动验证
        $this -> validate($request, [
            'username' => 'required',
            'password' => 'required',
            'repassword' => 'required|same:password',
            'age' => 'required',
            'phone' => 'required',
            'email' => 'required|email',

        ],[
            'username.required' => '用户名必填',
            'password.required' => '密码必填',
            'repassword.required' => '确认密码必填',
            'repassword.same' => '确认密码不一致',
            'age.required' => '年龄必填',
            'phone.required' => '手机号必填',
            'email.required' => '邮箱必填',
            'email.email' => '邮箱格式不正确',
        ]);

        //接收用户提交的值
        $data = $request -> except('_token','repassword');
        $data['password'] = Hash::make($data['password']);
        //注册时间
        $data['ctime'] = time();
        //token
        $data['token'] = str_random(50); //随即一个长度为50位字符串

        //将结果存在数据库
        $res = DB::table('userinfo') -> insert($data);

        if($res){
            return redirect('/admin/login/login') -> with('success','注册成功');
        }else{
            return back() -> with('error','注册失败');
        }
    }
}
