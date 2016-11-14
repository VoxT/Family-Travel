<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function redirectToBookingFlight(Request $request)
    {
    	return View('pages.flightbooking')->with('flightDetails', ((array) json_decode($request->details)));
    }

    public function redirectToBookingHotel(Request $request)
    {
    	return View('pages.hotelbooking')->with('hotelDetails', ((array) json_decode($request->details)));
    }

    public function postBookingFlight(Request $request)
    {
    	
    }

    public function postBookingHotel(Request $request)
    {

    }
}
