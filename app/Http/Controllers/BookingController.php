<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function getDetails(Request $request)
    {
    	return View('pages.flightbooking')->with('flightDetails', ((array) json_decode($request->flightdetails)));
    }
}
