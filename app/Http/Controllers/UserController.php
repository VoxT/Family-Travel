<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function userInfo()
    {
    	$id = Auth::id();

    	$data = DB::table('users')->where('id',$id)->get()->first();
    	return view('pages.userInfo',['data'=>$data]);
    }
}
