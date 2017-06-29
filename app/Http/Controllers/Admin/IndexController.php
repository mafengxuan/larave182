<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function getIndex(){
        return view('admin.index.index');
    }

    public function getAdd(){
    	echo 11;
    	return view('admin.index.add');
    }

    public function postInsert(Request $request){
    	echo true;
    }
}
