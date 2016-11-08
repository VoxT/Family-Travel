<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Skyscanner\Utils\NetworkUtils;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }
    
    public function searchResult()
    {
        return view('pages.searchResult')->with('request', json_encode(Input::get()));
    }

    public function getDataByRequestURL(Request $request) 
    { 
        return NetworkUtils::getJSONStr(NetworkUtils::httpRequest($request->url.'&key'.$request->key));
    }
}
