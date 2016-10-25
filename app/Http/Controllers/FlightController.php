<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Skyscanner\Transport\Flights;
use App\Skyscanner\Transport\FlightsCache;


class FlightController extends Controller
{
    public function getLivePriceFlight(Request $request)
    {
    	$flights_service = new Flights('ab388326561270749029492042586956');
    	$arrayName = array(
    		'country'=>'VN',
   			'currency'=>'VND',
   			'locale'=>'vi-VN',
    		'originplace'=> $request->originplace,
    		'destinationplace'=>$request->destinationplace,
    		'outbounddate'=> $request->outbounddate,
    		'inbounddate'=>$request->inbounddate,
    		'adults'=>$request->adults ,
    		'GroupPricing' =>true);
    	$result = $flights_service->getResult(Flights::GRACEFUL,$arrayName);
    	$json = json_encode($result);
    	$array = json_decode($json,true);

    	
        $SessionKey = $array['parsed']['SessionKey'];
        $Query =    $array['parsed']['Query'];
        $Status = $array['parsed']['Status'];
        $Itineraries =  $array['parsed']['Itineraries'];
        $Legs = $array['parsed']['Legs'];
        $Carriers  = $array['parsed']['Carriers'];
        $Agents = $array['parsed']['Agents'];
        $Places= $array['parsed']['Places'];
        $Currencies = $array['parsed']['Currencies'];
       //
        
        $flightArray = array();

        foreach ($Itineraries as $result) 
        {
           //Id chuyến bay đi
            $OutboundLegId = $result['OutboundLegId'];

             //Id chuyến bay đến
            $InboundLegId  = $result['InboundLegId'];

             //Giá
            $PricingOptions = $result['PricingOptions'];

            $price = $PricingOptions[0]['Price'];

            $LinkBooking = $PricingOptions[0]['DeeplinkUrl'];

            foreach($Legs as $r1)
            {
                if($r1['Id'] == $OutboundLegId)
                {
                    //Id Điểm đi
                    $IdOriginStation = $r1['OriginStation'];
                    //Id Điểm đến
                    $IdDestinationStation = $r1['DestinationStation'];
                    //Thời gian đi
                    $Departure = substr($r1['Departure'],11,18);
                    //Thời gian đến
                    $Arrival = substr($r1['Arrival'],11,18);
                    //Thời gian bay
                    $Duration = $r1['Duration'];
                    $h = round(intval($Duration)/60);
                    $min = intval($Duration)%60;
                    //Id hảng máy bay
                    $IdCarriers = $r1['Carriers'][0];

                }

                if($r1['Id'] == $InboundLegId)
                {
                    //Id Điểm đi
                    $IdOriginStation1 = $r1['OriginStation'];
                    //Id Điểm đến
                    $IdDestinationStation1= $r1['DestinationStation'];
                    //Thời gian đi
                    $Departure1 = substr($r1['Departure'],11,18);
                    //Thời gian đến
                    $Arrival1 = substr($r1['Arrival'],11,18);
                    //Thời gian bay
                    $Duration1 = $r1['Duration'];
                    $h1 = round(intval($Duration)/60);
                    $min1 = intval($Duration)%60;
                    //Id hảng máy bay
                    $IdCarriers1 = $r1['Carriers'][0];
                }
            }
            foreach($Carriers as $r2)
            {
                //Lấy src của hảng máy bay đi
                if($r2['Id'] == $IdCarriers)
                {
                    $Name = $r2['Name'];
                    $src = $r2['ImageUrl'];
                }
                //Lấy src của hảng máy bay về
                if($r2['Id'] == $IdCarriers1)
                {
                    $Name1 = $r2['Name'];
                    $src1 = $r2['ImageUrl'];
                }
            }
            foreach($Places as $r3)
            {  
                //Lấy tên và code điểm đi
                if($r3['Id'] == $IdOriginStation )
                {
                    $CodeOrigin = $r3['Code'];
                    $TypeOrigin = $r3['Type'];
                    $NameOrigin = $r3['Name'];
                }   
                //Lấy tên và code điểm đến
                if($r3['Id'] == $IdDestinationStation )
                {
                    $CodeDestination = $r3['Code'];
                    $TypeDestination = $r3['Type'];
                    $NameDestination = $r3['Name'];
                }   
                //Lấy tên và code điểm đi
                if($r3['Id'] == $IdOriginStation1 )
                {
                    $CodeOrigin1 = $r3['Code'];
                    $TypeOrigin1 = $r3['Type'];
                    $NameOrigin1 = $r3['Name'];
                }   
                //Lấy tên và code điểm đến
                if($r3['Id'] == $IdDestinationStation1 )
                {
                    $CodeDestination1 = $r3['Code'];
                    $TypeDestination1 = $r3['Type'];
                    $NameDestination1 = $r3['Name'];
                }   
            }

            array_push($flightArray,array(
                    'Outbound' => array(
                        'NameOrigin' => $NameOrigin,
                        'CodeOrigin' => $CodeOrigin,
                        'NameDestination' => $NameDestination,
                        'CodeDestination' => $CodeDestination,
                        'Departure' => $Departure,
                        'Arrival' => $Arrival,
                        'ImageUrl' => $src,
                        'ImageName' => $Name,
                        'Duration_h' => $h,
                        'Duration_m' =>$min
                        ) ,
                    'Inbound' => array(
                        'NameOrigin' => $NameOrigin1,
                        'CodeOrigin' => $CodeOrigin1,
                        'NameDestination' => $NameDestination1,
                        'CodeDestination' => $CodeDestination1,
                        'Departure' => $Departure1,
                        'Arrival' => $Arrival1,
                        'ImageUrl' => $src1,
                        'ImageName' => $Name1,
                        'Duration_h' => $h1,
                        'Duration_m' =>$min1
                        ),
                    'Price' => $price
                    )
                );
        }
    	
        //printf('<pre>Poll Data  %s</pre>', print_r($array, true));
        //printf('<pre>Poll Data  %s</pre>', print_r($flightArray, true));
        return $this->jsonResponse($flightArray);
    }

    public function jsonResponse($data = null, $status = 200)
    {
        return response()->json([
                'data' => $data
            ], $status);
    }
    
}
