<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function redirectToBookingFlight(Request $request)
    {
    	return View('pages.flightbooking')->with('flightDetails', $request->details);
    }

    public function redirectToBookingHotel(Request $request)
    {
    	return View('pages.hotelbooking')->with('hotelDetails', $request->details);
    }

    public function postBookingFlight(Request $request)
    {
    	$flight_details = (array) json_decode($request->flightdetails);    
        $input = $flight_details['input'];
        $flight = $flight_details['flight'];

        // create flight round trip
        $id = DB::table('flight_round_trip')->insertGetId(
            ['cabin_class' => $input->cabin_class,
             'number_of_seat' => $input->adults,
             'price' => $flight->Price,
             'full_name' => $request->full_name,
             'phone' => $request->phone,
             'email' => $request->email,
             'gender' => 'other',
             'tour_id' => '1',
             ]
        );	

        // create flight
        $id = DB::table('flights')->insertGetId(
            ['cabin_class' => $input->cabin_class,
             'number_of_seat' => $input->adults,
             'price' => $flight->Price,
             'full_name' => $request->full_name,
             'phone' => $request->phone,
             'email' => $request->email,
             'gender' => 'other',
             'tour_id' => '1',
             ]
        );  
    }

    public function postBookingHotel(Request $request)
    {
    	print_r((array) json_decode($request->hoteldetails));
    }
}
