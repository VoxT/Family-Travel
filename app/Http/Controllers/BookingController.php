<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Carbon\Carbon;

use Illuminate\Support\Facades\Cache;

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

    public function redirectToBookingCar(Request $request)
    {
    	return View('pages.carbooking')->with('carDetails', $request->details);
    }

    public function postBookingFlight()
    { 
        $flight_details = (array) json_decode(\Session::get('flightDetails'));
        $tourId = Cache::get('tourId');

        if($tourId == '') {
            $tourId = $this->createTour();
        }

        $input = $flight_details['input'];
        $flights = $flight_details['flight'];

        // create flight round trip
        $id = DB::table('flight_round_trip')->insertGetId(
            ['cabin_class' => $input->cabinClass,
             'number_of_seat' => $input->adults,
             'price' => $flights->Price,
             'full_name' => \Session::get('user_name'),
             'phone' => \Session::get('user_phone'),
             'email' => \Session::get('user_email'),
             'gender' => 'other',
             'tour_id' => $tourId,
             'payment_id' => \Session::get('paypal_payment_id')
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
    }

    public function postBookingHotel()
    {

        $hoteldetails = (array)json_decode(\Session::get('hotelDetails')); 

        $tourId = Cache::get('tourId');
        if($tourId == '') {
            $tourId = $this->createTour();
        }

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
                'full_name' => \Session::get('user_name'),
                'email' => \Session::get('user_email'),
                'address' => \Session::get('address'),
                'phone' => \Session::get('user_phone'),
                'gender' => 'other',
                'payment_id' => \Session::get('paypal_payment_id'),
                'tour_id' =>  $tourId
            ]);
    }

    public function postBookingCar()
    {
        $cardetails = json_decode(\Session::get('carDetails')); 

        $tourId = Cache::get('tourId');
        if($tourId == '') {
            $tourId = $this->createTour();
        }

        DB::table('cars')->insert(
            [
                'pick_up_place' => $cardetails->pick_up_address,
                'drop_off_place' => $cardetails->pick_up_address,
                'pick_up_datetime' => '2016-11-25 12:00:00',
                'drop_off_datetime' => '2016-11-27 12:00:00',
                'price' => $cardetails->price_all_days,
                'image' =>$cardetails->image_url,
                'seats' => $cardetails->seats,
                'doors' => $cardetails->doors,
                'bags' => $cardetails->bags,
                'manual'=> $cardetails->manual,
                'air_conditioning' => $cardetails->air_conditioning,
                'mandatory_chauffeur' => $cardetails->mandatory_chauffeur,
                'car_class_name' => $cardetails->car_class_name,
                'vehicle' => $cardetails->vehicle,
                'distance_to_search_location_in_km' => $cardetails->distance_to_search_location_in_km,
                'geo_info' => json_encode($cardetails->geo_info),
                'fuel_type' => $cardetails->fuel_type,
                'fuel_policy' => $cardetails->fuel_policy,
                'theft_protection_insurance' => $cardetails->theft_protection_insurance,
                'third_party_cover_insurance' => $cardetails->third_party_cover_insurance,
                'free_collision_waiver_insurance' => $cardetails->free_collision_waiver_insurance,
                'free_damage_refund_insurance' => $cardetails->free_damage_refund_insurance,
                'free_cancellation' => $cardetails->free_cancellation,
                'free_breakdown_assistance' => $cardetails->free_breakdown_assistance,
                'unlimited' => $cardetails->unlimited,
                'included' =>$cardetails->included,
                'unit' => $cardetails->unit,
                'full_name' => \Session::get('user_name'),
                'email' => \Session::get('user_email'),
                'address' => \Session::get('address'),
                'phone' => \Session::get('user_phone'),
                'gender' => 'other',
                'payment_id' => \Session::get('paypal_payment_id'),
                'tour_id' =>  $tourId
            ]);
    }

    public function postPlace(Request $request)
    {
        $tourId = Cache::get('tourId');
        if($tourId == '') {
            $tourId = $this->createTour();
        }

        $place = $request->place;
        array_key_exists('phone', $place)? $phone = $place['phone'] : $phone = '';
        array_key_exists('website', $place)? $website = $place['website'] : $website = '';
        array_key_exists('rates', $place)? $rates = $place['rates'] : $rates = 0;

        DB::table('places')->insert([
                'name' => $place['name'],
                'address' => $place['address'],
                'place_type' => $place['place_type'],
                'place_id' => $place['place_id'],
                'images' => json_encode($place['images']),
                'location' => json_encode($place['location']),
                'reviews' => json_encode($place['reviews']),
                'rates' =>  $rates,
                'phone' => $phone,
                'website' => $website,
                'tour_id' => $tourId
            ]);
        
        return response(['place_id' => $place['place_id']]);
    }

    public function createTour()
    {
        $user = Auth::user();
        if(!$user) return jsonResponse();

        $tourId = DB::table('tours')->insertGetId(
                ['origin_place' => Cache::get('originplace'),
                'destination_place' => Cache::get('destinationplace'),
                'outbound_date' => Cache::get('outbounddate'),
                'inbound_date' => Cache::get('inbounddate'),
                'adults' => Cache::get('adults'),
                'children' => Cache::get('children'),
                'infants' => Cache::get('infants'),
                'user_id' => $user->id
                ]
            );
        $tour = App\Tours::where('id', $tourId)->get()->first();

        $expiresAt = Carbon::now()->endOfDay();
        Cache::put('tourId', $tour->id , $expiresAt);
        \Session::put('tourID', $tourId);

        return $tourId;
    }

    public function bookingFlight(Request $request)
    {
        $this->storeSession($request);
        \Session::put('flightDetails', $request->flightdetails);
        $this->postBookingFlight();
        $this->forgetSession('flightDetails');
        $url = 'report/'.Cache::get('tourId');
        return redirect($url);
    }

    public function bookingHotel(Request $request)
    {
        $this->storeSession($request);
        \Session::put('hotelDetails', $request->hoteldetails);
        $this->postBookingHotel();
        $this->forgetSession('hotelDetails');
        $url = 'report/'.Cache::get('tourId');
        return redirect($url);
    }

    public function bookingCar(Request $request)
    {
        $this->storeSession($request);
        \Session::put('carDetails', $request->cardetails);
        $this->postBookingCar();
        $this->forgetSession('carDetails');
        $url = 'report/'.Cache::get('tourId');
        return redirect($url);
    }

    public function storeSession($request)
    {
        \Session::put('user_name', $request->full_name);
        \Session::put('user_phone', $request->phone);
        \Session::put('user_email', $request->email);
        \Session::put('address',$request->address);
        \Session::put('tourID', Cache::get('tourId'));
    }

    public function forgetSession($details)
    {
        \Session::forget($details);
        \Session::forget('user_name');
        \Session::forget('user_phone');
        \Session::forget('user_email');
        \Session::forget('paypal_payment_id');
        \Session::forget('tourID');
    }
}
