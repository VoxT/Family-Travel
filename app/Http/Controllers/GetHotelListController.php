<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Skyscanner\Transport\Hotels;


class GetHotelListController extends Controller
{

    protected $sessionKey;

    protected $apiKey ;
    protected $hotels_service ;


    public function __construct()
    {
        $this->apiKey = 'prtl6749387986743898559646983194';

        $this->hotels_service = new Hotels($this->apiKey);

    }
    //Request

    //entityid
    //checkindate
    //checkoutdate
    //guests
    //rooms
    public function getHotelList(Request $request)
    {
    	$params = array(
            'currency' => 'VND',
    		'market' => 'VN',
            'locale' =>'vi-VN',
            'entityid' => $request->entityid,
            'checkindate'=> $request->checkindate,
            'checkoutdate'=> $request->checkoutdate,
            'guests'=> $request->guests,
            'rooms' => $request->rooms
        );
        $addParams = array(
            'sortColumn' => 'rating',
            'sortorder' =>'asc',
            'pageindex' => 0,
            'pagesize' => 10);
        
    	$result = $this->hotels_service->getResult(Hotels::GRACEFUL,$params,$addParams);
    	$json = json_encode($result);
    	$array = json_decode($json,true);
       // printf('<pre>Poll Data  %s</pre>', print_r($array, true));
        //danh sách khách sạn
        $sessionUrl  = $this->hotels_service->getSessionUrl();
        $data = $this->responseData($array,$sessionUrl);

        return $this->jsonResponse($data);

    }


    //Request

    //hotel_id
    //url
    public function getHotelDetails(Request $request)
    {

        $hotel_id = $request->hotel_id;

        $url = $request->url;

        //Lấy chi tiết của 1 khách sạn
        $hotel_details = $this->hotels_service->getResultHotelDetails(Hotels::GRACEFUL,$url,array('hotelIds'=>$hotel_id));
        $json = json_encode($hotel_details);

        $hotel_details = json_decode($json,true);

        if (array_key_exists('hotels_prices', $hotel_details['parsed']))
            $hotels_prices = $hotel_details['parsed']['hotels_prices'][0];
        else
            $hotels_prices = array();
        if (array_key_exists('amenities', $hotel_details['parsed']))
            $amenities_data = $hotel_details['parsed']['amenities'];
        else
            $amenities_data = array();

        $amenities = array();

        $amenities_details = array();
        
        if (array_key_exists('agent_prices', $hotels_prices))
            $agent_prices = $hotels_prices['agent_prices'];
        else
            $agent_prices = array();
        if ($agent_prices != null)
        {
            $agent_prices = $agent_prices[0];
             if (array_key_exists('price_per_room_night', $agent_prices))
                $price_per_room_night = $agent_prices['price_per_room_night'];
            else
                $price_per_room_night = null;
            if (array_key_exists('price_total', $agent_prices))
                $price_total = $agent_prices['price_total'];
            else
                $price_total = null;
            if (array_key_exists('room_offers', $agent_prices) && $agent_prices['room_offers'] != null)
                $room_offers = $agent_prices['room_offers'][0];
            else
                 $room_offers = array();
            if(array_key_exists('meal_plan',$room_offers))
                $meal_plan = $room_offers['meal_plan'];
            else
                $meal_plan = null;
            if (array_key_exists('policy_dto', $room_offers))
                $policy_dto = $room_offers['policy_dto'];
            else
                $policy_dto = array();

            if (array_key_exists('cancellation', $policy_dto))
 
                $cancellation_policy = $policy_dto['cancellation'];

            else
               $cancellation_policy = null; 
            if ($room_offers['rooms'] != null)
            {
                $rooms =   $room_offers['rooms'][0];
                $type_room = $rooms['type'];
                $available = $room_offers['available'];
            }
            else
            {
                $type_room = null;
                $available = null;

            }
        }
        else
        {
            $price_per_room_night = null;
            $price_total = null;
            $meal_plan = null;
            $cancellation_policy = null;
            $type_room = null;
            $available = null;

        }
        if (array_key_exists('reviews', $hotels_prices))
        {
            $reviews = $hotels_prices['reviews'];
        
            if (array_key_exists('count', $reviews))
                $reviews_count = $reviews['count'];
            else
                $reviews_count = null;

            if(array_key_exists('summary', $reviews))
                $summary = $reviews['summary'];
            else
                $summary = null;

            if (array_key_exists('guest_types', $reviews))
                $guest_types = $reviews['guest_types'];
            else
                $guest_types = null;

            if (array_key_exists('categories', $reviews))
                $categories = $reviews['categories'];
            else
                $categories = null;
        }   
        else
        {
            $reviews_count = null;
            $summary = null;
            $guest_types = null;
            $categories = null;
        }


        //Chi tiết hotel
        if (array_key_exists('hotels', $hotel_details['parsed']))
        {
            if ($hotel_details['parsed']['hotels'] != null)
                $hotel = $hotel_details['parsed']['hotels'][0];

            if (array_key_exists('name',$hotel))
                $name = $hotel['name'];
            else
                $name = null;

            if (array_key_exists('description',$hotel))
                $description = $hotel['description'];
            else
                $description = null;

            if (array_key_exists('address',$hotel))
                $address = $hotel['address'];
            else
                $address = null;

            if (array_key_exists('district',$hotel))
                $district  = $hotel['district'];
            else
                $district = null;

            if (array_key_exists('number_of_rooms', $hotel))
                $number_of_rooms = $hotel['number_of_rooms'];
            else
                $number_of_rooms = null;

            if (array_key_exists('popularity', $hotel))
                $popularity = $hotel['popularity'];
            else
                $popularity = null;

            if (array_key_exists('popularity_desc', $hotel))
                $popularity_desc = $hotel['popularity_desc'];
            else
                $popularity_desc = null;
            
            if (array_key_exists('amenities', $hotel))
                $amenities_id = $hotel['amenities'];
            else
                $amenities_id = null;
            if ($amenities_id != null)
            {
                foreach ($amenities_data as $data) 
                {
                    if(array_key_exists('image',$data))
                    {
                        $amenities_details = array();
                        $check = true;
                        foreach ($amenities_id as $value) 
                        {
                            $id = $value ;  

                            foreach ($amenities_data as $data1) 
                            {
                                if($id == $data1['id'])
                                {
                                    if($data['id'] == $data1['parent'])
                                    {
                                        if($amenities_details != null)
                                        {
                                            foreach ($amenities_details as $key)
                                            {
                                               if($key['name'] == $data1['name'])
                                                   $check = false;
                                            }
                                            if ($check == true)
                                                array_push($amenities_details,array(
                                                    'name'=>$data1['name']
                                                )); 
                                        }
                                        else
                                            array_push($amenities_details,array(
                                                    'name'=>$data1['name']
                                                ));
                                    }   
                                }
                            }                

                        }

                        array_push($amenities,array(
                            'id'=>$data['id'],
                            'name'=>$data['name'],
                            'image_url'=>$data['image'],
                            'amenities_details' => $amenities_details
                            ));
                    }

               
                }
            }
            else
                $amenities = null;
        }
        else
        {
            $name = null;
            $description = null;
            $address = null;
            $district = null;
            $number_of_rooms = null;
            $popularity = null;
            $popularity_desc = null;
            $$amenities = null;

        }
        if (array_key_exists('latitude', $hotel))
            $latitude = $hotel['latitude'];
        else
            $latitude = null;

        if (array_key_exists('longitude', $hotel))
            $longitude = $hotel['longitude'];
        else
            $longitude = null;

        if (array_key_exists('images', $hotel))
            $images = $hotel['images'];
        else
            $images = null;

        $image_host_url = $hotel_details['parsed']['image_host_url'];

        $image_url = array();
        if ($images != null)
        {
            foreach ($images as $key => $value)
            {
                
                $url_1 = $key;
                $width = 0;
                foreach ($value as $url_key => $size) {
                    if ($url_key != 'provider' && $url_key != 'order')
                    {
                        if ($size[0] > $width )
                        {
                            $width = $size[0];
                            $url_2 = $url_key;
                        }
                    }

                }
                array_push($image_url,array(
                    'url'=>$image_host_url . $url_1 . $url_2
                    ));

            }
        }
        else
            $image_url = null;
        $hotel_array[(string) $hotel_id] =
            array(
            'price_per_room_night' => number_format($price_per_room_night, 0, '.', ''),
            'price_total' => number_format($price_total, 0, '.', ''),
            'policy' => array(
                'meal_plan' => $meal_plan,
                'cancellation' => $cancellation_policy
                ),
            'room' => array(
                'type_room' => $type_room
                ),
            'available' => $available,
            'reviews' => array(
                'reviews_count' => $reviews_count,
                'summary' => $summary,
                'guest_types'  => $guest_types,
                'categories' => $categories
                ),
            'hotel' => array(
                'name' => $name,
                'description' => $description,
                'address' => $address,
                'district' => $district,
                'number_of_rooms'=> $number_of_rooms,
                'popularity' => $popularity,
                'popularity_desc' => $popularity_desc,
                'amenities' => $amenities,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'image_url' => $image_url
                ),
            );
        return $this->jsonResponse($hotel_array);

    }
    //Request

    //index

    //url = SessionUrl

    public function getHotelListByIndex(Request $request)
    {
        $addParams = array(
            'sortColumn' => 'rating',
            'sortorder' =>'asc',
            'pageindex' => $request->index,
            'pagesize' => 10);

        $sessionUrl = $request->url;

        $result = $this->hotels_service->getResultWithSession(Hotels::GRACEFUL,$sessionUrl,$addParams);
        $json = json_encode($result);
        $array = json_decode($json,true);

       // printf('<pre>Poll Data  %s</pre>', print_r($array, true));
        //danh sách khách sạn
       
        $data = $this->responseData($array,$sessionUrl);

        return $this->jsonResponse($data);


    }

    public function responseData(array $array,$sessionUrl)
    {
        if ($array != null)
        {
            $hotels = $array['parsed']['hotels'];

            $total_hotels = $array['parsed']['total_hotels'];

            $total_available_hotels = $array['parsed']['total_available_hotels'];
            
            $hotel_list  = array();

            $hotel_array  = array();

            $url = 'http://partners.api.skyscanner.net/' . $array['parsed']['urls']['hotel_details'];

            foreach ($hotels as $ht) 
            {
                $hotel_id  = $ht['hotel_id'];

                $hotel_array[(string) $hotel_id] = array(
                    'url'=> $url
                    );

            }
            $hotel_list =  array(
                'Hotels' =>$hotel_array,
                'SessionUrl' => $sessionUrl
                );   
       }
       else
       {
            $hotel_list  = array();
       }
        return $hotel_list;
    }
}   