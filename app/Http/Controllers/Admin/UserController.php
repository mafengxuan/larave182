<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Hash;


class UserController extends Controller
{
    // 添加用户
    public function getAdd(){
        return view('admin.user.add');
    }

    public function postInsert(Request $request){
        // 手动验证 用户是否必填
        // if($request -> has($data['username'])){
        //     return back() -> withInput();
        // }

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
            return redirect('/admin/user/index') -> with('success','添加成功');
        }else{
            return back() -> with('error','添加失败');
        }
    }

    //用户主页面
    public function getIndex(Request $request){
        //获取值
        $count = $request -> input('count',10);
        $search = $request -> input('search','');
        $all = $request -> all();
        // 把所有的数据获取到  并且分页分配到主页面
        $data = DB::table('userinfo') ->where('username','like','%'.$search.'%')-> paginate($count);
      
        return view('admin.user.index',['data'=>$data,'request'=>$all]);
    }
    //用户删除
    public function getDelete($id){
        $res = DB::table('userinfo')->where('id',$id)->delete();
        if($res){
            return redirect('/admin/user/index') -> with('success','删除成功');
        }else{
            return back() -> with('error','删除失败');
        }
    
    }

    //修改页面
    public function getEdit($id){
        //获取一条数据
        $arr = DB::table('userinfo')->where('id',$id)->first();
        // 加载修改页面
        return view('admin.user.edit',['arr'=>$arr]);
    }

    //修改操作
    public function postUpdate(Request $request){
        //修改数据
        $arr = $request -> only(['age','phone','email']);
        $id = $request -> input('id');
        //修改
        $res = DB::table('userinfo')->where('id',$id)->update($arr);
        if($res){
            return redirect('/admin/user/index') -> with('success','修改成功');
        }else{
            return back() -> with('error','修改失败');
        }
    }
}
