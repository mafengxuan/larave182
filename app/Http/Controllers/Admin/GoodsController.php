<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class GoodsController extends Controller
{
    public function getIndex(Request $request){

        $count = $request -> input('count',10);
        $search = $request -> input('search','');
        $all = $request -> all();

        $data = DB::table('goods') ->where('gname','like','%'.$search.'%')-> paginate($count);
      
        return view('admin.goods.index',['data'=>$data,'request'=>$all]);

    }

    public function getAdd(){


        return view('admin.goods.add');

    }

    public function postInsert(Request $request){

        $this -> validate($request, [
            'gname' => 'required',
            'content' => 'required',
            'num' => 'required',
            'price' => 'required',
            

        ],[
            'gname.required' => '商品名必填',
            
            'content.required' => '商品描述必填',
            'num.required' => '商品数量必填',
            'price.required' => '商品价格必填',
           
        ]);

        $data = $request -> except('_token');

        $res = DB::table('goods')->insert($data);

        if($res){
            return redirect('/admin/goods/index') -> with('success','添加成功');
        }else{
            return back() -> with('error','添加失败');
        }

    }

    public function getEdit($id){

        $arr = DB::table('goods')->where('id',$id)->first();
        return view('admin.goods.edit',['arr'=>$arr]);

    }

    public function postUpdate(Request $request){

        $data = $request -> only(['content','num','price']);
        $id = $request -> input('id');
        $res = DB::table('goods')->where('id',$id)->update($data);
        
        if($res){
            return redirect('/admin/goods/index') -> with('success','修改成功');
        }else{
            return back() -> with('error','修改失败');
        }

    }

    public function getDelete($id){

        $res = DB::table('goods')->delete($id);

        if($res){
            return redirect('/admin/goods/index') -> with('success','删除成功');
        }else{
            return back() -> with('error','删除失败');
        }

       

    }

}
