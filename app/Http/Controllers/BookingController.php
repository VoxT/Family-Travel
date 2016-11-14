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
    	print_r((array) json_decode($request->flightdetails));    	
    }

    public function postBookingHotel(Request $request)
    {
    	print_r((array) json_decode($request->hoteldetails));
    }
}
