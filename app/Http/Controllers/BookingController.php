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
    	return View('pages.hotelbooking')->with('hotelDetails', $request->details)->with('tourId', $request->tourId);
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

        return redirect('/report'.'/'.$request->tourId);
    }

    public function postBookingHotel(Request $request)
    {

        $hoteldetails = (array)json_decode($request->hoteldetails);  
        (object)$input = $hoteldetails['input'];
        (object)$hotel = $hoteldetails['hotel'];
        $reviews = json_encode($hotel->reviews);

        
         DB::table('hotels')->insert(
            [
                'check_in_date' => $input->checkindate,
                'check_out_date' => $input->checkoutdate,
                'guests' => $input->guests,
                'rooms' => $input->rooms,
                'price' => $hotel->price_total,
                'policy' => json_encode($hotel->policy),
                'room_type' =>$hotel->room->type_room,
                'reviews' => $reviews,
                'name' => $hotel->hotel->name,
                'description' => $hotel->hotel->description,
                'location' => $hotel->hotel->address,
                'popularity' => $hotel->hotel->popularity,
                'amenities' => json_encode($hotel->hotel->amenities),
                'latitude' => $hotel->hotel->latitude,
                'longitude' =>$hotel->hotel->longitude,
                'star_rating' => $hotel->hotel->star_rating,
                'image_url' => json_encode($hotel->hotel->image_url),
                'full_name' => $request->full_name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
                'gender' => 'other',
                'tour_id' => $request->tourId
            ]);
        return redirect('/report'.'/'.$request->tourId);
    }
}
