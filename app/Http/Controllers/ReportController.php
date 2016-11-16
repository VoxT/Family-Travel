<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ReportController extends Controller
{
	//  return all flight belong to a tour and group by flight round trip
    public function flightsRespone($tourId)
    {
    	$roundTrip = App\FlightRoundTrip::where('tour_id', $tourId)->get();

    	$flightsRespone = array();
    	foreach ($roundTrip as $key => $value) {
    		$temp = $this->renderFlightResponse($value->id);
    		$temp['Round'] = array('price' => $value->price,
    								'cabinClass' => $value->cabin_class,
    								'seats' => $value->number_of_seat,
    								'fullName' => $value->full_name,
    								'email' => $value->email,
    								'created' => $value->created_at
    							);
    		array_push($flightsRespone, $temp);
    	}

    	return $flightsRespone;
    }

    // return all flight belong to a flight round trip
    public function renderFlightResponse($flightRoundTripId)
    {
    	$outbound = App\Flights::where('round_trip_id', $flightRoundTripId)
    							->where('type', 'Outbound')
    							->orderBy('index')
    							->get();

    	$inbound = App\Flights::where('round_trip_id', $flightRoundTripId)
    							->where('type', 'Inbound')
    							->orderBy('index')
    							->get();
    	$respone = array();
    	$oSegment = array();
    	foreach ($outbound as $key => $value) {
    		$arrival = new \DateTime($value->arrival_datetime);
    		$departure = new \DateTime($value->departure_datetime);
    		$duration = $arrival->getTimestamp() - $departure->getTimestamp();
    		array_push($oSegment, array(
                'originName' => $value->origin_place,
                'originCode' => $value->origin_code,
                'destinationName' =>$value->destination_place,
                'destinationCode' =>$value->destination_code,
                'departureDate' => $departure->format('Y-m-d'),
                'arrivalDate' => $arrival->format('Y-m-d'),
                'departureTime' => $departure->format('H:i'),
                'arrivalTime' => $arrival->format('H:i'),
                'duration_h' => floor($duration/3600),
                'duration_m'=> floor($duration/60%60),
                'imageUrl' => $value->carrier_logo,
                'imageName' => $value->carrier_name,
                'flightNumber' => $value->flight_number
                ));
    	}

    	$dSegment = array();
    	foreach ($inbound as $key => $value) {
    		$arrival = new \DateTime($value->arrival_datetime);
    		$departure = new \DateTime($value->departure_datetime);
    		$duration = $arrival->getTimestamp() - $departure->getTimestamp();
    		array_push($dSegment, array(
                'originName' => $value->origin_place,
                'originCode' => $value->origin_code,
                'destinationName' =>$value->destination_place,
                'destinationCode' =>$value->destination_code,
                'departureDate' => $departure->format('Y-m-d'),
                'arrivalDate' => $arrival->format('Y-m-d'),
                'departureTime' => $departure->format('H:i'),
                'arrivalTime' => $arrival->format('H:i'),
                'duration_h' => floor($duration/3600),
                'duration_m'=> floor($duration/60%60),
                'imageUrl' => $value->carrier_logo,
                'imageName' => $value->carrier_name,
                'flightNumber' => $value->flight_number
                ));
    	}

    	return array('Outbound' => $oSegment, 'Inbound' => $dSegment, 'Payment' => array());
    }

    public function getReport($tourId)
    {
    	$user = Auth::user();
    	if(!$user) return redirect('/');

    	$tour = App\Tours::where('id', $tourId)
    						->where('user_id', $user->id)->get();
    	if(!$tour) return $this->jsonResponse(null);

    	return view('pages.report')->with(
    			'data', array('flights' => $this->flightsRespone($tourId))
    		);
    }

    // api: get available tours
    public function postTour(Request $request)
    {
        $user = Auth::user();
        if(!$user) return jsonResponse();

        $tourId = DB::table('tours')->insertGetId(
                ['origin_place' => $request->originName,
                'destination_place' => $request->destinationName,
                'outbound_date' => $request->startDate,
                'inbound_date' => $request->endDate,
                'adults' => $request->adults,
                'children' => $request->children,
                'infants' => $request->infants,
                'user_id' => $user->id
                ]
            );
        $tour = App\Tours::where('id', $tourId)->get()->first();

        $expiresAt = Carbon::now()->endOfDay();
        Cache::put('tourId', $tour->id , $expiresAt);

        return $this->jsonResponse($tour);
    }
}
