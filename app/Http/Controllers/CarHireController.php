<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Skyscanner\Transport\CarHire;

class CarHireController extends Controller
{
    public function getCarPrice()
    {
    	$carhire_service = new CarHire('ab388326561270749029492042586956');
    	$params = array(
    		'currency' => 'GBP',
    		'market' => 'UK',
    		'locale' => 'en-GB',
    		'pickupplace' => 'LHR-sky',
    		'dropoffplace' => 'LHR-sky',
    		'pickupdatetime' => '2016-11-02T12:00',
    		'dropoffdatetime' => '2016-11-03T18:00',
    		'driverage' => '30',
    		'userip' => '42.118.54.167'
    		);
		$result = $carhire_service->getResult(CarHire::GRACEFUL, $params, array());

		return $this->jsonResponse($result);
    }
}
