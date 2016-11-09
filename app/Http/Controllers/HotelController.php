<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Skyscanner\Transport\Hotels;


class HotelController extends Controller
{
    public function getHotelPrice(Request $request)
    {
    	$hotels_service = new Hotels('prtl6749387986743898559646983194');
    	$params = array(
            'currency' => 'VND',
    		'market' => 'VN',
            'locale' =>'vi-VN',
            'entityid' =>"27546329",
            'checkindate'=>"2016-11-15",
            'checkoutdate'=> "2016-11-18",
            'guests'=> "1",
            'rooms' => '1'
        );

    	$result = $hotels_service->getResult(Hotels::GRACEFUL,$params);
    	$json = json_encode($result);
    	$array = json_decode($json,true);
       // printf('<pre>Poll Data  %s</pre>', print_r($array, true));

        //danh sách khách sạn
        $hotels = $array['parsed']['hotels'];

        $total_hotels = $array['parsed']['total_hotels'];

        $total_available_hotels = $array['parsed']['total_available_hotels'];
        
        $hotel_array  = array();

        $url = 'http://partners.api.skyscanner.net/' . $array['parsed']['urls']['hotel_details'];

       
        foreach ($hotels as $ht) 
        {
            //Id khách sạn
            $hotel_id = $ht['hotel_id'];
            //Lấy chi tiết của 1 khách sạn
            $hotel_details = $hotels_service->getResultHotelDetails(Hotels::GRACEFUL,$url,array('hotelIds'=>$hotel_id));
            $json1 = json_encode($hotel_details);
            $hotel_details = json_decode($json1,true);
            //printf('<pre>Poll Data  %s</pre>', print_r($hotel_details, true));
            $hotels_prices = $hotel_details['parsed']['hotels_prices'][0];
            
            $amenities_data = $hotel_details['parsed']['amenities'];
            //printf('<pre>Poll Data  %s</pre>', print_r($amenities_data, true));
            $amenities = array();

            $amenities_details = array();
            
            $agent_prices = $hotels_prices['agent_prices'];

            if ($agent_prices != null)
            {
                $agent_prices = $agent_prices[0];
                $price_per_room_night = $agent_prices['price_per_room_night'];

                $price_total = $agent_prices['price_total'];

                $room_offers = $agent_prices['room_offers'][0];

                if(array_key_exists('meal_plan',$room_offers))
                    $meal_plan = $room_offers['meal_plan'];
                else
                    $meal_plan = null;
                $policy_dto = $room_offers['policy_dto'];

                if (array_key_exists('cancellation', $policy_dto))
                {
                    $cancellation_policy = $policy_dto['cancellation'];
                }
                else
                   $cancellation_policy = null; 

                $rooms =   $room_offers['rooms'][0];
                $type_room = $rooms['type'];
                $available = $room_offers['available'];
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
            $reviews = $hotels_prices['reviews'];

            $reviews_count = $reviews['count'];

            $summary = $reviews['summary'];

            $guest_types = $reviews['guest_types'];

            $categories = $reviews['categories'];



            //Chi tiết hotel
            $hotel = $hotel_details['parsed']['hotels'][0];

            $name = $hotel['name'];

            $description = $hotel['description'];

            $address = $hotel['address'];

            $district  = $hotel['district'];

            $number_of_rooms = $hotel['number_of_rooms'];

            $popularity = $hotel['popularity'];

            $popularity_desc = $hotel['popularity_desc'];

            $amenities_id = $hotel['amenities'];

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

            $latitude = $hotel['latitude'];

            $longitude = $hotel['longitude'];

            $images = $hotel['images'];

            $image_host_url = $hotel_details['parsed']['image_host_url'];

            //$image_background = $ht['image_urls'][0];
            //print($image_background);


            $image_url = array();

            foreach ($images as $key => $value) {
                
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

            $hotel_array['0'.(string) $hotel_id] =
                array(
                'price_per_room_night' => $price_per_room_night,
                'price_total' => $price_total,
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


        }
        return $this->jsonResponse($hotel_array);

    }
}   