<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Skyscanner\Transport\CarHire;

class CarHireController extends Controller
{
    public function getCarPrice(Request $request)
    {
    	$carhire_service = new CarHire('ab388326561270749029492042586956');
    	$params = array(
    		'currency' => 'VND',
    		'market' => 'VN',
    		'locale' => 'vi-VN',
    		'pickupplace' => $request->pickupplace,
    		'dropoffplace' => $request->dropoffplace,
    		'pickupdatetime' => $request->pickupdatetime,
    		'dropoffdatetime' => $request->dropoffdatetime,
    		'driverage' => '30',
    		'userip' => '192.168.238.184'
    		);
		$result = $carhire_service->getResult(CarHire::GRACEFUL, $params, array());

        $json = json_encode($result);
        $array = json_decode($json,true);

        $cars =  $array['parsed']['cars'];

        $websites = $array['parsed']['websites'];

        $images = $array['parsed']['images'];
        $car_classes = $array['parsed']['car_classes'];

        $carArray = array();
        $count = 0;
        foreach ($cars as $car) {

            //SIPP Code
            $sipp = $car['sipp'];

            //id của image xe
            $image_id = $car['image_id'];

            foreach ($images as $image)
            {

                if ($image_id == $image['id'])
                {
                    $image_url = $image['url']; 
                }
            }
            //Giá tất cả 
            $price_all_days = $car['price_all_days'];

            //Số chổ ngồi
            $seats = $car['seats'];

            //Số cửa 
            $doors = $car['doors'];

            //Số chổ bỏ hành lý
            $bags = $car['bags'];

            //Số bằng tay = true , số tự động = false
            $manual = $car['manual'];

            //điêu hòa nhiệt độ 
            $air_conditioning = $car['air_conditioning'];

            //Tài xế lái xe 
            $mandatory_chauffeur = $car['mandatory_chauffeur'];

            //Loại xe 
            $vehicle = $car['vehicle'];

            //Loại class xe
            $car_class_id = $car['car_class_id'];

            foreach ($car_classes as $car_class) 
            {
                if($car_class_id == $car_class['id'])
                {
                    $sort_order = $car_class['sort_order'];
                    $car_class_name = $car_class['name'];
                }
            }

            //địa điểm nhận xe 

            $pick_up_address = $car['location']['pick_up']['address'];

            //Khoảng cách đến vị trí nhận xe
            $distance_to_search_location_in_km = $car['location']['pick_up']['distance_to_search_location_in_km'];

            //Toạ độ nhận xe
            $geo_info = $car['location']['pick_up']['geo_info'];



           //chính sách thêm 
            if(array_key_exists("value_add", $car))
                $value_add = $car['value_add'];
            else
                $value_add = null;
            $fuel = array();
            if (array_key_exists("fuel", $value_add))
                $fuel = $value_add['fuel'];
          //  $fuel_type = $car['value_add']['fuel']['type'];
            if ($fuel)
            {
                 //Loại nhiên liêu
                if(array_key_exists("type", $fuel))
                    $fuel_type = $fuel['type'];
                else
                    $fuel_type = null;

                 //Chính sách nhiên liệu : full to full hỗ trợ nhiên liệu
                if(array_key_exists("policy", $fuel))
                    $fuel_policy = $fuel['policy'];
                else
                    $fuel_policy = null;
                 //Thái độ
                if(array_key_exists('fair', $fuel))
                   
                    $fair = $fuel['fair'];
                else
                    $fair = null;


            }
            else 
            {
                 $fuel_type = null;
                 $fuel_policy = null;
                 $fair = null;


            }
            //Bảo hiểm 
            
            if (array_key_exists("insurance",$value_add))
            {
                $insurance = $value_add['insurance'];
                //bảo hiểm chống trộm

                if (array_key_exists("theft_protection",$insurance))
                {
                    $theft_protection_insurance = $insurance['theft_protection']; 
                }
                else 
                     $theft_protection_insurance = null; 

                //bảo hiểm bên thứ 3    
                if (array_key_exists("third_party_cover",$insurance)){
                    $third_party_cover_insurance = $insurance['third_party_cover']; 
                }
                else 
                     $third_party_cover_insurance = null; 


                //bảo hiểm va chạm
                if (array_key_exists("free_collision_waiver",$insurance)){
                    $free_collision_waiver_insurance = $insurance['free_collision_waiver']; 
                }
                else 
                     $free_collision_waiver_insurance = null; 

                //Bảo hiểm hư hỏng
                if (array_key_exists("free_damage_refund",$insurance)){
                    $free_damage_refund_insurance = $insurance['free_damage_refund']; 
                }
                else 
                     $free_damage_refund_insurance = null;

            }
            else {

                 $theft_protection_insurance = null;
                 $third_party_cover_insurance = null; 
                 $free_collision_waiver_insurance = null;
                 $free_damage_refund_insurance = null; 

            }

            //Miễn phí huỷ đặt xe
            if(array_key_exists('free_cancellation',$value_add))
                $free_cancellation = $value_add['free_cancellation'];
            else
                $free_cancellation = null;

            //Hổ trợ hỏng xe 
            if(array_key_exists('free_breakdown_assistance',$value_add))
                $free_breakdown_assistance = $value_add['free_breakdown_assistance'];
            else
                $free_breakdown_assistance = null;

            //giới hạn số km
            if (array_key_exists('included_mileage', $value_add) )
            {
                $included_mileage = $value_add['included_mileage'];
                if (array_key_exists("unlimited", $included_mileage))
                    $unlimited = $included_mileage['unlimited'];
                else
                    $unlimited = null;
                if (array_key_exists("included", $included_mileage))
                    $included = $included_mileage['included'];
                else
                    $included = null;
                if (($included_mileage!=null) && array_key_exists("unit", $included_mileage))
                    $unit = $included_mileage['unit'];
                else
                    $unit = null;
            }
            else
            {
                $unlimited = null;
                $included = null;
                $unit = null;
            }


            $carArray["0".(string)$count] = array (
                'sipp' => $sipp,
                'price_all_days' => number_format($price_all_days, 0, '.', ''),
                'image_url' => $image_url,
                'seats' => $seats,
                'doors' => $doors,
                'bags'=>$bags,
                'manual'=>$manual,
                'air_conditioning'=>$air_conditioning,
                'mandatory_chauffeur'=>$mandatory_chauffeur,
                'sort_order' => $sort_order,
                'car_class_name' => $car_class_name,
                'vehicle' =>$vehicle,
                'pick_up_address'=>$pick_up_address,
                'distance_to_search_location_in_km' => $distance_to_search_location_in_km,
                'geo_info' =>$geo_info,
                'fair'=> $fair,
                'fuel_type' =>$fuel_type,
                 'fuel_policy'=>$fuel_policy,
                'theft_protection_insurance' => $theft_protection_insurance,
                'third_party_cover_insurance' => $third_party_cover_insurance, 
                'free_collision_waiver_insurance' => $free_collision_waiver_insurance,
                'free_damage_refund_insurance' => $free_damage_refund_insurance, 
                'free_cancellation'=>$free_cancellation,
                'free_breakdown_assistance'=>$free_breakdown_assistance,
                'unlimited' =>$unlimited,
                'included' =>$included,
                'unit' => $unit
                );
            $count++;
        }
		return $this->jsonResponse($carArray);
    }
}
