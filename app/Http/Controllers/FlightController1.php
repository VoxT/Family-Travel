<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Skyscanner\Transport\Flights;
use App\Skyscanner\Transport\FlightsCache;
class FlightController extends Controller
{

    public function getPlace(array $places,$id)
    {
        foreach($places as $place)
            {  
                //Lấy tên và code 
                if($place['Id'] == $id )
                {
                    $code = $place['Code'];
                    $name = $place['Name'];
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
        $flights_service = new Flights('ab388326561270749029492042586956');
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
            'pageindex' => 0,
            'pagesize' => 10);
        $result = $flights_service->getResult(Flights::GRACEFUL,$params, $addParams);
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
        $Segments = $array['parsed']['Segments'];
       //
        
        $flightArray = array();

        $flightsResult = array();

        $countId = 0;

        $input = array(
            'Adults' => $Query['Adults'],
            'Children'=>$Query['Children'],
            'Infants' =>$Query['Infants'],
            'OutboundDate' => $Query['OutboundDate'],
            'InboundDate' => $Query['InboundDate'],
            'CabinClass' => $Query['CabinClass']
            );

        foreach ($Itineraries as $result) 
        {

            $segment_outbound_list = array();

            $segment_inbound_list = array();
           //Id chuyến bay đi
            $OutboundLegId = $result['OutboundLegId'];
             //Id chuyến bay đến
            $InboundLegId  = $result['InboundLegId'];
             //Giá
            $PricingOptions = $result['PricingOptions'];
            $price = $PricingOptions[0]['Price'];
            
            $outbound = $this->getItineraries($Legs,$Places,$Carriers,$OutboundLegId);
            
            $inbound = $this->getItineraries($Legs,$Places,$Carriers,$InboundLegId);

            $outbound_segmentIds = $outbound['segmentIds'];

            $inbound_segmentIds = $inbound['segmentIds'];

            foreach ($outbound_segmentIds as $segmentId) 
            {
                $segment_oubount = $this->getSegment($Segments,$Places,$Carriers,$segmentId);
                array_push($segment_outbound_list, $segment_oubount);

            }
            foreach ($inbound_segmentIds as $segmentId) 
            {
                $segment_inbound = $this->getSegment($Segments,$Places,$Carriers,$segmentId);
                array_push($segment_inbound_list, $segment_inbound);

            }

            $flightArray["0".(string)$countId] = array(
                    'Outbound' => array(
                        'overall' =>$outbound['overall'],
                        'segment' =>$segment_outbound_list
                        ) ,
                    'Inbound' => array(
                        'overall' => $inbound['overall'],
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
        //printf('<pre>Poll Data  %s</pre>', print_r($array, true));
        //printf('<pre>Poll Data  %s</pre>', print_r($flightArray, true));
        return $this->jsonResponse($flightsResult);

    }

    
    
}