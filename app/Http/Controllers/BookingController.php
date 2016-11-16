<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cache;

class BookingController extends Controller
{
    public function redirectToBookingFlight(Request $request)
    {
    	return View('pages.flightbooking')->with('flightDetails', $request->details)->with('tourId', $request->tourId);
    }

    public function redirectToBookingHotel(Request $request)
    {
    	return View('pages.hotelbooking')->with('hotelDetails', $request->details)->with('tourId', $request->tourId);;
    }

    public function postBookingFlight(Request $request)
    {
    	$flight_details = (array) json_decode($request->flightdetails);    
        $input = $flight_details['input'];
        $flights = $flight_details['flight'];
        echo 'a'.$request->tourId;
        // create flight round trip
        $id = DB::table('flight_round_trip')->insertGetId(
            ['cabin_class' => $input->cabinClass,
             'number_of_seat' => $input->adults,
             'price' => $flights->Price,
             'full_name' => $request->full_name,
             'phone' => $request->phone,
             'email' => $request->email,
             'gender' => 'other',
             'tour_id' => $request->tourId,
             ]
        );	

        // create flight
        foreach ($flights as $key => $flight) {
            if($key === 'Price') continue;
            else
            foreach ($flight->segment as $index => $segment) {
                DB::table('flights')->insert(
                    ['origin_place' => $segment->originName,
                     'destination_place' => $segment->destinationName,
                     'origin_code' => $segment->originCode,
                     'destination_code' => $segment->destinationCode,
                     'departure_datetime' => new \DateTime($segment->departureDate.' '.$segment->departureTime),
                     'arrival_datetime' =>  new \DateTime($segment->arrivalDate.' '.$segment->arrivalTime),
                     'flight_number' => $segment->flightCode.$segment->flightNumber,
                     'carrier_logo' => $segment->imageUrl,
                     'carrier_name' => $segment->imageName,
                     'type' => $key,
                     'index' => $index,
                     'round_trip_id' => $id,
                     ]
                );  
            }
        }

        return redirect('/report/1');
    }

    public function postBookingHotel(Request $request)
    {
    	print_r((array) json_decode($request->hoteldetails));
    }
}
