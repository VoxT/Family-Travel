<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Skyscanner\Transport\Flights;
use App\Skyscanner\Transport\FlightsCache;
class FlightController extends Controller
{

    protected $sessionKey;

    protected $flights_service;

    protected $apiKey;


    public function getPlace(array $places,$id)
    {
        foreach($places as $place)
            {  
                //Lấy tên và code 
                if($place['Id'] == $id )
                {
                    $code = $place['Code'];
                    $name = $place['Name'];
                    break;
                }   
            }
        return array(
            'code' => $code,
            'name' => $name
            );
    }
    //Lấy thông tin tổng thể của chuyến bay đi hoặc về
    public function getItineraries(array $legs,$places,$carriers,$id)
    {
        foreach($legs as $leg)
        {
            if($leg['Id'] == $id)
            {
                //Id Điểm đi
                $originStationId = $leg['OriginStation'];
                //Id Điểm đến
                $destinationStationId = $leg['DestinationStation'];
                //Thời gian đi
                $departure = substr($leg['Departure'],11,15);
                //Thời gian đến
                $arrival = substr($leg['Arrival'],11,15);
                //Thời gian bay
                $duration = $leg['Duration'];
                $hour = round(intval($duration)/60);
                $min = intval($duration)%60;
                //Id hảng máy bay
                $carriersId = $leg['Carriers'][0];

                $segmentIds = $leg['SegmentIds'];
                break;
            }
        }
        $originplace = $this->getPlace($places,$originStationId);

        $destinationplace = $this->getPlace($places,$destinationStationId);

        $carrier = $this->getCarrier($carriers,$carriersId);

        return array(
            'overall'=> array(
                'originName' => $originplace['name'],
                'originCode' => $originplace['code'],
                'destinationName' =>$destinationplace['name'],
                'destinationCode' =>$destinationplace['code'],
                'departure' => $departure,
                'arrival' => $arrival,
                'duration_h' => $hour,
                'duration_m'=> $min,
                'imageUrl' => $carrier['src'],
                'imageName' => $carrier['name'],
                'flightCode' => $carrier['flightCode']
                ),
            'segmentIds' =>$segmentIds
            );

    }

    public function getCarrier(array $carriers,$id)
    {
        foreach($carriers as $value)
        {
            //Lấy src,name,code của hảng máy bay 
            if($value['Id'] == $id)
            {
                $name = $value['Name'];
                $src = $value['ImageUrl'];
                $flightCode = $value['Code'];
                break;
            }
        }
        return array(
            'name'=> $name,
            'src' => $src,
            'flightCode' => $flightCode
            );

    }

    public function getSegment(array $segments,$places,$carriers,$id)
    {
        foreach ($segments as $segment) 
        {
           if($segment['Id'] == $id)
           {
                //Id Điểm đi
                $originStationId = $segment['OriginStation'];
                //Id Điểm đến
                $destinationStationId = $segment['DestinationStation'];
                //Thời gian đi
                $departure = substr($segment['DepartureDateTime'],11,15);
                //Thời gian đến
                $arrival = substr($segment['ArrivalDateTime'],11,15);
                //Thời gian bay
                $duration = $segment['Duration'];
                $hour = round(intval($duration)/60);
                $min = intval($duration)%60;
                //Id hảng máy bay
                $carriersId = $segment['Carrier'];

                $flightNumber = $segment['FlightNumber'];

                break;

           }
        }
        $originplace = $this->getPlace($places,$originStationId);

        $destinationplace = $this->getPlace($places,$destinationStationId);

        $carrier = $this->getCarrier($carriers,$carriersId);

        return array(
                'originName' => $originplace['name'],
                'originCode' => $originplace['code'],
                'destinationName' =>$destinationplace['name'],
                'destinationCode' =>$destinationplace['code'],
                'departure' => $departure,
                'arrival' => $arrival,
                'duration_h' => $hour,
                'duration_m'=> $min,
                'imageUrl' => $carrier['src'],
                'imageName' => $carrier['name'],
                'flightNumber' => $flightNumber
                );
    }
    public function getLivePriceFlight(Request $request)
    {
        $this->apiKey = 'ab388326561270749029492042586956';
        $this->flights_service = new Flights($this->apiKey);
        $params = array(
            'country'=>'VN',
            'currency'=>'VND',
            'locale'=>'vi-VN',
            'originplace'=> $request->originplace,
            'destinationplace'=>$request->destinationplace,
            'outbounddate'=> $request->outbounddate,
            'adults'=>$request->adults,
            'children' => $request->children,
            'infants' => $request->infants,
            'cabinclass' => $request->cabinclass,
            'GroupPricing' =>true);
        if($request->inbounddate != null) $params['inbounddate'] = $request->inbounddate;
        
        $addParams = array(
            'sorttype' => 'price',
            'sortorder' =>'asc',
            'pageindex' => 0,
            'pagesize' => 10);

        $result = $this->flights_service->getResult(Flights::GRACEFUL,$params, $addParams);

        $json = json_encode($result);

        $array = json_decode($json,true);

        $data  = $this->responeData($array);
        //printf('<pre>Poll Data  %s</pre>', print_r($array, true));
        //printf('<pre>Poll Data  %s</pre>', print_r($flightArray, true));
        return $this->jsonResponse($data);

    }  

    public function getLivePriceFlightByIndex($index)
    {
        $addParams1 = array(
            'apiKey' => $this->apiKey,
            'sorttype' => 'price',
            'sortorder' =>'asc',
            'pageindex' => $index,
            'pagesize' => 10);
        $url = 'http://partners.api.skyscanner.net/apiservices/pricing/v1.0/' . $this->sessionKey;
        $r = $this->flights_service->getResultWithSession(Flights::GRACEFUL,$url,$addParams1);

        $json = json_encode($r);

        $array = json_decode($json,true);

        $data = $this->responeData($array);

        return $this->jsonResponse($data);
    }

    public function responeData(array $array)
    {
        if ($array != null)
        {
            $SessionKey = $array['parsed']['SessionKey'];

            $this->sessionKey = $SessionKey;

            $Query =    $array['parsed']['Query'];

            $Status = $array['parsed']['Status'];

            $Itineraries =  $array['parsed']['Itineraries'];

            $Legs = $array['parsed']['Legs'];

            $Carriers  = $array['parsed']['Carriers'];

            $Agents = $array['parsed']['Agents'];

            $Places= $array['parsed']['Places'];

            $Currencies = $array['parsed']['Currencies'];

            $Segments = $array['parsed']['Segments'];
           //
            
            $flightArray = array();

            $flightsResult = array();

            $countId = 0;

            $adults = $Query['Adults'];

            $children = $Query['Children'];

            $infants = $Query['Infants'];

            $outboundDate = $Query['OutboundDate'];
            if (array_key_exists('InboundDate', $Query))
                $inboundDate = $Query['InboundDate'];
            else
                $inboundDate = null;
            $cabinClass = $Query['CabinClass'];
            $input = array(
                'adults' => $adults,
                'children'=>$children,
                'infants' => $infants,
                'outboundDate' => $outboundDate,
                'inboundDate' => $inboundDate,
                'cabinClass' => $cabinClass
                );

            foreach ($Itineraries as $result) 
            {

                $segment_outbound_list = array();

                $segment_inbound_list = array();

                $inbound_overall = array();

                $outbound_overall = array();

                  //Giá
                $PricingOptions = $result['PricingOptions'];

                $price = $PricingOptions[0]['Price'];
              
               
                 //Id chuyến bay về
                if (array_key_exists('InboundLegId',$result))
                {
                    $InboundLegId  = $result['InboundLegId'];

                    $inbound = $this->getItineraries($Legs,$Places,$Carriers,$InboundLegId);

                    $inbound_segmentIds = $inbound['segmentIds'];

                    foreach ($inbound_segmentIds as $segmentId) 
                    {
                        $segment_inbound = $this->getSegment($Segments,$Places,$Carriers,$segmentId);
                        array_push($segment_inbound_list, $segment_inbound);
                    }

                    $inbound_overall = $inbound['overall'];
                }

                else 
                {
                    $inbound_overall = array();

                    $segment_inbound_list = array();
                }
                //Id chuyến bay đi
                if (array_key_exists('OutboundLegId', $result))
                {
                    $OutboundLegId = $result['OutboundLegId'];

                    $outbound = $this->getItineraries($Legs,$Places,$Carriers,$OutboundLegId);

                    $outbound_segmentIds = $outbound['segmentIds'];

                    foreach ($outbound_segmentIds as $segmentId) 
                    {
                        $segment_oubount = $this->getSegment($Segments,$Places,$Carriers,$segmentId);
                        array_push($segment_outbound_list, $segment_oubount);

                    }
                    
                    $outbound_overall = $outbound['overall'];
                }
                else
                {
                    $outbound_overall = array();

                    $segment_outbound_list = array();
                }

                $flightArray["0".(string)$countId] = array(
                        'Outbound' => array(
                            'overall' =>$outbound_overall,
                            'segment' =>$segment_outbound_list
                            ) ,
                        'Inbound' => array(
                            'overall' => $inbound_overall,
                            'segment' => $segment_inbound_list
                            ),
                        'Price' => $price
                        );
                $countId++;
            }
            
            $flightsResult = array(
                'input' => $input,
                'flight' => $flightArray,
                );
        }
        else
           $flightsResult = array();
        return $flightsResult ;
    }
}