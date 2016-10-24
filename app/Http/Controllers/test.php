<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

use App\Skyscanner\Transport\Flights;

class test extends Controller
{
    public function GetLiveFlightPrice()
    {
    	$flights_service = new Flights('ba664649448657318087191341360709');
    	$params = array(
		    'country' => 'UK',
		    'currency' => 'GBP',
		    'locale' => 'en-GB',
		    'originplace' => 'SIN-sky',
		    'destinationplace' => 'KUL-sky',
		    'outbounddate' => '2016-10-22',
		    'inbounddate' => '2016-10-27',
		    'adults' => 1);
    	$result = $flights_service->getResult(Flights::GRACEFUL, $params);
    	return json_decode(json_encode($result), true);
    }

    public function welcome()
    {
    	return view('welcome');
    }

    public function map()
    {
        return view('pages.searchResult')->with([
                'request' => Input::get()
            ]);
    }
}
