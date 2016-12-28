<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
	use AuthenticatesUsers;
    public function index()
    {
    	return View('admin.index');
    }

    public function login()
    {
    	return View('admin.login');
    }

    public function logout()
    {
    	Auth::logout();
    	return redirect('admin/login');
    }

    public function postLogin(Request $request)
    {
    	if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
            // Authentication passed...
            if(Auth::user()->role === 'admin')
            	return redirect('admin');
            else return View('admin.login')->with('error', 'You are not Admin!');
        } else {
            return View('admin.login')->with('error', 'Email or Password incorrect!');
        }
    }

    public function getUsers()
    {   
        $data  = array();
        $users = DB::table('users')->get();
        foreach ($users as $value)
        {
            $user_id = $value->id;
            $total_tour = DB::table('tours')->where('user_id',$user_id)->count();
            array_push($data, array(
                'id' => $user_id,
                'name' => $value->full_name,
                'email' => $value->email,
                'address' => $value->address,
                'birthday' => $value->birthday,
                'gender' => $value->gender,
                'phone' => $value->phone,
                'total_tour' => $total_tour
                ));
        } 
    	return View('admin.users',['data'=>$data]);
    }

    public function getUserDetails($id)
    {
         $data  = array();
        $users = DB::table('users')
                                    ->where('id',$id)
                                    ->get();
        foreach ($users as $value)
        {
            $user_id = $value->id;
            $total_tour = DB::table('tours')->where('user_id',$user_id)->count();
            array_push($data, array(
                'id' => $user_id,
                'name' => $value->full_name,
                'email' => $value->email,
                'address' => $value->address,
                'birthday' => $value->birthday,
                'gender' => $value->gender,
                'phone' => $value->phone,
                'total_tour' => $total_tour
                ));
        } 
        return View('admin.users',['data'=>$data]);

    }
    public function getTourList($id)
    {
        $data = DB::table('tours')->where('user_id',$id)->get();

        return View('admin.tours',['data'=>$data]);
    }
     public function getTourDetails($tourId)
    {
        //get flight details
        $flights = array();

        $flight_round = DB::table('flight_round_trip')
                        ->select('id','price','number_of_seat','payment_id')
                        ->where('tour_id',$tourId)
                        ->get()
                        ->toArray();

        foreach ($flight_round as $key => $value)
        {
            $flight_place  = DB::table('flights')
                        ->select('origin_place','destination_place','departure_datetime','arrival_datetime')
                        ->where('round_trip_id',$value->id)
                        ->where('type', 'Outbound')
                        ->orderBy('index')
                        ->get();
            array_push($flights, array(
                'origin_place' => $flight_place[0]->origin_place,
                'destination_place' => $flight_place[count($flight_place) - 1]->destination_place,
                'departure_datetime' => $flight_place[0]->departure_datetime,
                'arrival_datetime' => $flight_place[count($flight_place) - 1]->arrival_datetime,
                'number_of_seat' => $value->number_of_seat,
                'payment_id' => $value->payment_id,
                'price' => $value->price
                ));
        }
        //return $flightsPayment;

        //get hotel details
        $hotels = DB::table('hotels')
                        ->select('id','name','price','check_in_date','check_out_date','guests','rooms','payment_id')
                        ->where('tour_id',$tourId)
                        ->get();

        //get carhire details
        $cars = DB::table('cars')
                        ->select('id','vehicle','price','pick_up_place','drop_off_place','pick_up_datetime','drop_off_datetime','payment_id')
                        ->where('tour_id',$tourId)
                        ->get();
        //get place details
         $places = DB::table('places')
                        ->select('id','name','address','place_type')
                        ->where('tour_id',$tourId)
                        ->get();
        return View('admin.tourdetails',['flights'=>$flights,'hotels' =>$hotels,'cars'=>$cars,'places'=>$places]);
    }

    public function getHotelList()
    {

        $hotels = DB::table('hotels')
                        ->select('id','name','price','check_in_date','check_out_date','guests','rooms','payment_id','tour_id','created_at')
                        ->get();

        $data = array();
        foreach ($hotels as $key => $value) 
        {
            $user_id = DB::table('tours')->select('user_id')
                                        ->where('id',$value->tour_id)
                                        ->first();
            $user_name = DB::table('users')->select('full_name')
                                        ->where('id',$user_id->user_id)
                                        ->first();
            array_push($data, array(
                'hotel'=>$value,
                'user_id'=>$user_id->user_id,
                'user_name'=>$user_name->full_name
                ));
        } 
        return View('admin.hotels',['data'=>$data]);  
    }

    public function getFlightList()
    {

        $flights = array();

        $flight_round = DB::table('flight_round_trip')
                        ->select('id','price','number_of_seat','payment_id','tour_id','created_at')
                        ->get()
                        ->toArray();

        foreach ($flight_round as $key => $value)
        {
            $flight_place  = DB::table('flights')
                        ->select('origin_place','destination_place','departure_datetime','arrival_datetime')
                        ->where('round_trip_id',$value->id)
                        ->where('type', 'Outbound')
                        ->orderBy('index')
                        ->get();
            $user_id = DB::table('tours')->select('user_id')
                                        ->where('id',$value->tour_id)
                                        ->first();
            $user_name = DB::table('users')->select('full_name')
                                        ->where('id',$user_id->user_id)
                                        ->first();
            array_push($flights, array(
                'origin_place' => $flight_place[0]->origin_place,
                'destination_place' => $flight_place[count($flight_place) - 1]->destination_place,
                'departure_datetime' => $flight_place[0]->departure_datetime,
                'arrival_datetime' => $flight_place[count($flight_place) - 1]->arrival_datetime,
                'number_of_seat' => $value->number_of_seat,
                'created_at' => $value->created_at,
                'payment_id' => $value->payment_id,
                 'user_id'=>$user_id->user_id,
                'user_name'=>$user_name->full_name,
                'price' => $value->price
                ));
        }
        return View('admin.flights',['data'=>$flights]);  
    }

    public function getCarList()
    {

        $cars = DB::table('cars')
                        ->select('id','vehicle','price','pick_up_place','drop_off_place','pick_up_datetime','drop_off_datetime','payment_id','tour_id','created_at')
                        ->get();

        $data = array();
        foreach ($cars as $key => $value) 
        {
            $user_id = DB::table('tours')->select('user_id')
                                        ->where('id',$value->tour_id)
                                        ->first();
            $user_name = DB::table('users')->select('full_name')
                                        ->where('id',$user_id->user_id)
                                        ->first();
            array_push($data, array(
                'car'=>$value,
                'user_id'=>$user_id->user_id,
                'user_name'=>$user_name->full_name
                ));
        } 
        return View('admin.cars',['data'=>$data]);  
    }

    public function getPlaceList()
    {

        $places = DB::table('places')
                        ->select('id','name','address','tour_id','place_type','created_at')
                        ->get();

        $data = array();
        foreach ($places as $key => $value) 
        {
            $user_id = DB::table('tours')->select('user_id')
                                        ->where('id',$value->tour_id)
                                        ->first();
            $user_name = DB::table('users')->select('full_name')
                                        ->where('id',$user_id->user_id)
                                        ->first();
            array_push($data, array(
                'place'=>$value,
                'user_id'=>$user_id->user_id,
                'user_name'=>$user_name->full_name
                ));
        } 
        return View('admin.places',['data'=>$data]);  
    }

    public function getPaymentList()
    {
        $data = array();
        $payments = DB::table('payments')
                        ->select('paypal_id','payer_name','payer_email','amount_total','amount_currency','user_id','created_at')
                        ->get();

        foreach ($payments as $key => $value) 
        {
            $user_name = DB::table('users')->select('full_name')
                                        ->where('id',$value->user_id)
                                        ->first();
            array_push($data, array(
                'payment'=>$value,
                'user_id'=>$value->user_id,
                'user_name'=>$user_name->full_name
                ));
        } 
        return View('admin.payments',['data'=>$data]);                
    }

    public function getPaymentDetails($paypal_id)
    {
        $data = array();
        $payments = DB::table('payments')
                        ->select('paypal_id','payer_name','payer_email','amount_total','amount_currency','user_id','created_at')
                        ->where('paypal_id',$paypal_id)
                        ->get();

        foreach ($payments as $key => $value) 
        {
            $user_name = DB::table('users')->select('full_name')
                                        ->where('id',$value->user_id)
                                        ->first();
            array_push($data, array(
                'payment'=>$value,
                'user_id'=>$value->user_id,
                'user_name'=>$user_name->full_name
                ));
        } 
        return View('admin.payments',['data'=>$data]);                
    }
}
