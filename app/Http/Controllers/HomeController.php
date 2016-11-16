<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Skyscanner\Utils\NetworkUtils;
use Carbon\Carbon;
use App;
use Illuminate\Support\Facades\Cache;

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
        return view('pages.searchResult')->with('request', json_encode(Input::get()))
                                            ->with('tourId', $this->getTourId() );
    }

    public function getDataByRequestURL(Request $request) 
    { 
        return NetworkUtils::getJSONStr(NetworkUtils::httpRequest($request->url.'&key'.$request->key));
    }

    public function getTourId()
    {
        $expiresAt = Carbon::now()->endOfDay();
        $tourId = '';

        if (Cache::has('tourId')) {
            foreach(Input::get() as $key => $value){
                if(Cache::get($key) != $value){
                    $tourId = ''; break;
                }
                $tourId = Cache::get('tourId');
            }
        }

        Cache::put('tourId', $tourId, $expiresAt);
         foreach(Input::get() as $key => $value){
            Cache::put($key, $value, $expiresAt);
        }

        if($tourId != ''){
            $tour = App\Tours::where('id', $tourId)->get();

            if(count($tour) != 0)
                $tourId = $tour->first()->id;
            else $tourId = '';
        }
        
        return $tourId;
    }

}
