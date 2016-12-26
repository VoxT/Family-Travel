<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
	use AuthenticatesUsers;
    public function index()
    {
    	return View('admin.index');
    }

    public function login()
    {
    	return View('admin.login');
    }

    public function logout()
    {
    	Auth::logout();
    	return redirect('admin/login');
    }

    public function postLogin(Request $request)
    {
    	if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
            // Authentication passed...
            if(Auth::user()->role === 'admin')
            	return redirect('admin');
            else return View('admin.login')->with('error', 'You are not Admin!');
        } else {
            return View('admin.login')->with('error', 'Email or Password incorrect!');
        }
    }

    public function getUsers()
    {
    	return View('admin.users');
    }
}
