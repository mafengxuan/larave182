<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
class TypeController extends Controller
{
    public function getIndex(Request $request){

        $count = $request -> input('count',10);
        $search = $request -> input('search','');
        $all = $request -> all();

        $data = DB::table('type') ->where('tname','like','%'.$search.'%')-> paginate($count);
      
        return view('admin.type.index',['data'=>$data,'request'=>$all]);

    }

    public function getAdd(){


        return view('admin.type.add');

    }

    public function postInsert(Request $request){

        $this -> validate($request, [
            'tname' => 'required',
         
            

        ],[
            'tname.required' => '类型名必填',
        
        ]);

        $data = $request -> except('_token');

        $res = DB::table('type')->insert($data);

        if($res){
            return redirect('/admin/type/index') -> with('success','添加成功');
        }else{
            return back() -> with('error','添加失败');
        }

    }

    public function getEdit($id){

        $arr = DB::table('type')->where('id',$id)->first();
        return view('admin.type.edit',['arr'=>$arr]);

    }

    public function postUpdate(Request $request){

        $data = $request -> only(['tname']);
        $id = $request -> input('id');
        $res = DB::table('type')->where('id',$id)->update($data);
        
        if($res){
            return redirect('/admin/type/index') -> with('success','修改成功');
        }else{
            return back() -> with('error','修改失败');
        }

    }

    public function getDelete($id){

        $res = DB::table('type')->delete($id);

        if($res){
            return redirect('/admin/type/index') -> with('success','删除成功');
        }else{
            return back() -> with('error','删除失败');
        }

       

    }
}
