<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
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
		    'outbounddate' => '2016-10-20',
		    'inbounddate' => '2016-10-30',
		    'adults' => 1);
    	$result = $flights_service->getResult(Flights::GRACEFUL, $params);
    	return view('welcome', ['result' => json_decode(json_encode($result, JSON_PRETTY_PRINT), true)]);
    }

    public function test()
    {
    	return view('welcome');
    }

    public function map(Request $request)
    {
        return view('pages.searchResult')->with([
                'request' => $request
            ]);
    }
}
