<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Input;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Swap\Builder;

class PaypalController extends Controller
{
    private $_api_context;
    private $paymentResult;
    private $bookingService;

    public function __construct(BookingController $bookingService)
    {
    	$this->bookingService = $bookingService;
        // setup PayPal api context
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function postFlightPayment(Request $request)
	{
		$this->storeSession($request);

		\Session::put('flightDetails', $request->flightdetails);

        $flight_details = (array) json_decode($request->flightdetails); 
        $input = $flight_details['input'];
        $flights = $flight_details['flight'];

        $price = $flights->Price / \Currency::conv($from = 'USD', $to = 'VND', $value = 1, $decimals = 2);

	    $item = new Item();
	    $item->setName($flights->Outbound->overall->originName.' - '.$flights->Outbound->overall->destinationName) // item name
	        ->setCurrency('USD')
	        ->setQuantity(1)
	        ->setPrice($price); // unit price

	    // add item to list
	    $item_list = new ItemList();
	    $item_list->setItems(array($item));
	    $amount = new Amount();
	    $amount->setCurrency('USD')
	        ->setTotal($price);

	    $transaction = new Transaction();
	    $transaction->setAmount($amount)
	        ->setItemList($item_list)
	        ->setDescription('Your transaction description');

	    return $this->Payment($transaction, 'payment.status.flight');
	}

	 public function postHotelPayment(Request $request)
	{
		$this->storeSession($request);

		\Session::put('hotelDetails', $request->hoteldetails);

        $hotel_details = (array) json_decode($request->hoteldetails); 
        $input = $hotel_details['input'];
        $hotel = $hotel_details['hotel'];

        $price = $hotel->price_total / \Currency::conv($from = 'USD', $to = 'VND', $value = 1, $decimals = 2);

	    $item = new Item();
	    $item->setName($hotel->hotel->name) // item name
	        ->setCurrency('USD')
	        ->setQuantity(1)
	        ->setPrice($price); // unit price

	    // add item to list
	    $item_list = new ItemList();
	    $item_list->setItems(array($item));
	    $amount = new Amount();
	    $amount->setCurrency('USD')
	        ->setTotal($price);

	    $transaction = new Transaction();
	    $transaction->setAmount($amount)
	        ->setItemList($item_list)
	        ->setDescription('Your transaction description');

	    return $this->Payment($transaction, 'payment.status.hotel');
	}

	 public function postCarPayment(Request $request)
	{
		$this->storeSession($request);

		\Session::put('carDetails', $request->cardetails);

        $car_details = json_decode($request->cardetails); 
 
        $price = $car_details->price_all_days / \Currency::conv($from = 'USD', $to = 'VND', $value = 1, $decimals = 2);

	    $item = new Item();
	    $item->setName($car_details->vehicle) // item name
	        ->setCurrency('USD')
	        ->setQuantity(1)
	        ->setPrice($price); // unit price

	    // add item to list
	    $item_list = new ItemList();
	    $item_list->setItems(array($item));
	    $amount = new Amount();
	    $amount->setCurrency('USD')
	        ->setTotal($price);

	    $transaction = new Transaction();
	    $transaction->setAmount($amount)
	        ->setItemList($item_list)
	        ->setDescription('Your transaction description');

	    return $this->Payment($transaction, 'payment.status.car');
	}

	 public function postTourPayment($flights,$hotels,$cars)
	{
 		$exchange_rate = \Currency::conv($from = 'USD', $to = 'VND', $value = 1, $decimals = 2);
 		$flight_price = 0;
 		$hotel_price = 0;
 		$car_price = 0;
 		$items = array();
 		$flights_list_id = array();
 		$hotels_list_id = array();
 		$cars_list_id = array();
 		//print_r($flights);
        foreach ($flights as $key => $value)
        {
        	$p = $value['price'] / $exchange_rate;
	   		$item = new Item();
	    	$item->setName($value['origin_place'] . "-" . $value['destination_place']) // item name
	        	->setCurrency('USD')
	        	->setQuantity(1)
	       		->setPrice($p); // unit price
	       	array_push($items, $item);
	       	$flight_price = $flight_price + (float)$p;
	       	array_push($flights_list_id, array(
	       		'id' => $value['id']));
	    }
	   \Session::put('flights_list_id',$flights_list_id);

	    foreach ($hotels as $key => $value)
        {

        	$p = $value->price / $exchange_rate;
	   		$item = new Item();
	    	$item->setName($value->name) // item name
	        	->setCurrency('USD')
	        	->setQuantity(1)
	       		->setPrice($p); // unit price
	       	array_push($items, $item);
	       	$hotel_price = $hotel_price + (float)$p;
	       	array_push($hotels_list_id, array(
	       		'id' => $value->id));
	    }

	    \Session::put('hotels_list_id',$hotels_list_id);
	    foreach ($cars as $key => $value)
        {
        	$p = $value->price / $exchange_rate;
	   		$item = new Item();
	    	$item->setName($value->vehicle) // item name
	        	->setCurrency('USD')
	        	->setQuantity(1)
	       		->setPrice($p); // unit price
	       	array_push($items, $item);
	       	$car_price = $car_price + (float)$p;
	       	array_push($cars_list_id, array(
	       		'id' => $value->id));
	    }
	    \Session::put('cars_list_id',$cars_list_id);
	     $price = ($flight_price + $hotel_price + $car_price);
	    // add item to list
	    $item_list = new ItemList();
	    $item_list->setItems($items);	
	    $amount = new Amount();
	    $amount->setCurrency('USD')
	        ->setTotal($price);

	    $transaction = new Transaction();
	    $transaction->setAmount($amount)
	        ->setItemList($item_list)
	        ->setDescription('Your transaction description');

	    return $this->Payment($transaction, 'payment.status.tour');
	}

	public function payFlights($flights)
	{

		$exchange_rate = \Currency::conv($from = 'USD', $to = 'VND', $value = 1, $decimals = 2);
 		$flight_price = 0;
 		$items = array();
 		$flights_list_id = array();
		foreach ($flights as $key => $value)
        {
	   		$item = new Item();
	    	$item->setName($value['origin_place'] . "-" . $value['destination_place']) // item name
	        	->setCurrency('USD')
	        	->setQuantity(1)
	       		->setPrice($value['price'] / $exchange_rate); // unit price
	       	array_push($items, $item);
	       	$flight_price = $flight_price + (int)$value['price'];
	       	array_push($flights_list_id, array(
	       		'id' => $value['id']));
	    }
	   \Session::put('hotels_list_id',array());
	   \Session::put('cars_list_id',array());
	   \Session::put('flights_list_id',$flights_list_id);
	   $price = $flight_price / $exchange_rate;
	    // add item to list
	    $item_list = new ItemList();
	    $item_list->setItems($items);	
	    $amount = new Amount();
	    $amount->setCurrency('USD')
	        ->setTotal($price);

	    $transaction = new Transaction();
	    $transaction->setAmount($amount)
	        ->setItemList($item_list)
	        ->setDescription('Your transaction description');

	    return $this->Payment($transaction, 'payment.status.tour');

	}

	public function payHotels($hotels)
	{
		$exchange_rate = \Currency::conv($from = 'USD', $to = 'VND', $value = 1, $decimals = 2);
		$hotel_price = 0;
 		$items = array();
 		$hotels_list_id = array();

 		foreach ($hotels as $key => $value)
        {

        	$p = $value->price / $exchange_rate;
	   		$item = new Item();
	    	$item->setName($value->name) // item name
	        	->setCurrency('USD')
	        	->setQuantity(1)
	       		->setPrice($p); // unit price
	       	array_push($items, $item);
	       	$hotel_price = $hotel_price + (float)$p;
	       	array_push($hotels_list_id, array(
	       		'id' => $value->id));
	    }
	   \Session::put('cars_list_id',array());
	   \Session::put('flights_list_id',array());
	    \Session::put('hotels_list_id',$hotels_list_id);

	    $price = $hotel_price;
	    // add item to list
	    $item_list = new ItemList();
	    $item_list->setItems($items);	
	    $amount = new Amount();
	    $amount->setCurrency('USD')
	        ->setTotal($price);

	    $transaction = new Transaction();
	    $transaction->setAmount($amount)
	        ->setItemList($item_list)
	        ->setDescription('Your transaction description');

	    return $this->Payment($transaction, 'payment.status.tour');


	}

	public function payCars($cars)
	{
		$exchange_rate = \Currency::conv($from = 'USD', $to = 'VND', $value = 1, $decimals = 2);
		$car_price = 0;
 		$items = array();
 		$cars_list_id = array();

 		foreach ($cars as $key => $value)
        {
        	$p = $value->price / $exchange_rate;
	   		$item = new Item();
	    	$item->setName($value->vehicle) // item name
	        	->setCurrency('USD')
	        	->setQuantity(1)
	       		->setPrice($p); // unit price
	       	array_push($items, $item);
	       	$car_price = $car_price + (float)$p;
	       	array_push($cars_list_id, array(
	       		'id' => $value->id));
	    }
	    \Session::put('cars_list_id',$cars_list_id);
	   \Session::put('flights_list_id',array());
	    \Session::put('hotels_list_id',array());

	    $price = $car_price;
	    // add item to list
	    $item_list = new ItemList();
	    $item_list->setItems($items);	
	    $amount = new Amount();
	    $amount->setCurrency('USD')
	        ->setTotal($price);

	    $transaction = new Transaction();
	    $transaction->setAmount($amount)
	        ->setItemList($item_list)
	        ->setDescription('Your transaction description');

	    return $this->Payment($transaction, 'payment.status.tour');


	}

	public function saveTourPayment()
	{
		$this->getPaymentStatus();

	   // echo '<pre>';print_r($this->paymentResult);echo '</pre>';//exit; // DEBUG RESULT, remove it later
	    if ($this->paymentResult->getState() == 'approved') { // payment made
	    	// Store payment	    	
	    	$this->storePayment();
	    	// Store Flight if payment is success
	    	$flights_list_id = \Session::get('flights_list_id');
 			$hotels_list_id = \Session::get('hotels_list_id');
 			$cars_list_id = \Session::get('cars_list_id');
 			$paypal_payment_id = \Session::get('paypal_payment_id');
 			if ($flights_list_id != null)
 			{
		    	foreach ($flights_list_id as $key => $value) 
		    	{
		    		DB::table('flight_round_trip')->where('id',$value['id'])
		    							->update(['payment_id' => $paypal_payment_id]);
		    	}
		    }
	    	if ($hotels_list_id != null)
	    	{
		    	foreach ($hotels_list_id as $key => $value) 
		    	{
		    		DB::table('hotels')->where('id',$value['id'])
		    							->update(['payment_id' => $paypal_payment_id]);
		    	}
		    }
		    if ($cars_list_id != null)
		    {
		    	foreach ($cars_list_id as $key => $value) {
		    		DB::table('cars')->where('id',$value['id'])
		    							->update(['payment_id' => $paypal_payment_id]);
		    	}
		    }
	    	\Session::forget('flights_list_id');
 			\Session::forget('hotels_list_id');
 			\Session::forget('cars_list_id');
 			\Session::forget('paypal_payment_id');
	        $tourId = \Session::get('tourID'); 

	        return redirect('report/'.$tourId)
	            ->with('success', 'Payment success');
	    }
	    return \Redirect::route('home');
	}

	
	public function saveFlightPayment()
	{
		$this->getPaymentStatus();

	   // echo '<pre>';print_r($this->paymentResult);echo '</pre>';//exit; // DEBUG RESULT, remove it later
	    if ($this->paymentResult->getState() == 'approved') { // payment made
	    	// Store payment	    	
	    	$this->storePayment();
	    	// Store Flight if payment is success
	    	$this->bookingService->postBookingFlight();

	        $tourId = \Session::get('tourID'); 

	        $this->forgetSession('flightDetails');

	        return redirect('report/'.$tourId)
	            ->with('success', 'Payment success');
	    }
	    return \Redirect::route('home');
	}

	public function saveHotelPayment()
	{
		$this->getPaymentStatus();

	   // echo '<pre>';print_r($this->paymentResult);echo '</pre>';//exit; // DEBUG RESULT, remove it later
	    if ($this->paymentResult->getState() == 'approved') { // payment made
	    	// Store payment	    	
	    	$this->storePayment();
	    	// Store Flight if payment is success
	    	$this->bookingService->postBookingHotel();

	        $tourId = \Session::get('tourID'); 

	        $this->forgetSession('hotelDetails');

	        return redirect('report/'.$tourId)
	            ->with('success', 'Payment success');
	    }
	    return \Redirect::route('home');
	}

	public function saveCarPayment()
	{
		$this->getPaymentStatus();

	   // echo '<pre>';print_r($this->paymentResult);echo '</pre>';//exit; // DEBUG RESULT, remove it later
	    if ($this->paymentResult->getState() == 'approved') { // payment made
	    	// Store payment	    	
	    	$this->storePayment();
	    	// Store Flight if payment is success
	    	$this->bookingService->postBookingCar();

	        $tourId = \Session::get('tourID'); 

	        $this->forgetSession('carDetails');

	        return redirect('report/'.$tourId)
	            ->with('success', 'Payment success');
	    }
	    return \Redirect::route('home');
	}

	public function Payment($transaction, $redirect_target)
	{
		$payer = new Payer();
	    $payer->setPaymentMethod('paypal');

	    $redirect_urls = new RedirectUrls();
	    $redirect_urls->setReturnUrl(\URL::route($redirect_target))
	        ->setCancelUrl(\URL::route('home'));

	    $payment = new Payment();
	    $payment->setIntent('Sale')
	        ->setPayer($payer)
	        ->setRedirectUrls($redirect_urls)
	        ->setTransactions(array($transaction));

	    try {
	        $payment->create($this->_api_context);
	    } catch (\PayPal\Exception\PPConnectionException $ex) {
	        if (\Config::get('app.debug')) {
	            echo "Exception: " . $ex->getMessage() . PHP_EOL;
	            $err_data = json_decode($ex->getData(), true);
	            exit;
	        } else {
	            die('Some error occur, sorry for inconvenient');
	        }
	    }

	    foreach($payment->getLinks() as $link) {
	        if($link->getRel() == 'approval_url') {
	            $redirect_url = $link->getHref();
	            break;
	        }
	    }

	    // add payment ID to session
	    if(isset($redirect_url)) {
	        // redirect to paypal
	       return redirect($redirect_url);
	    }

	   return \Redirect::route('original.route')
	       ->with('error', 'Unknown error occurred');
	}

	public function getPaymentStatus()
	{
	    // Get the payment ID before session clear
	    $payment_id = Input::get('paymentId'); 
	    \Session::put('paypal_payment_id', $payment_id);
	    // clear the session payment ID
	    if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
	        return \Redirect::route('original.route')
	            ->with('error', 'Payment failed');
	    }

	    $payment = Payment::get($payment_id, $this->_api_context);
	    // PaymentExecution object includes information necessary 
	    // to execute a PayPal account payment. 
	    // The payer_id is added to the request query parameters
	    // when the user is redirected from paypal back to your site
	    $execution = new PaymentExecution();
	    $execution->setPayerId(Input::get('PayerID'));
	    
	    //Execute the payment
	    $this->paymentResult = $payment->execute($execution, $this->_api_context);
	}

	public function storePayment()
	{
		$payer = $this->paymentResult->getPayer()->getPayerInfo();
		$amount = $this->paymentResult->getTransactions()[0]->getRelatedResources()[0]->getSale()->getAmount();

		DB::table('payments')->insert(
			[
				'paypal_id' => \Session::get('paypal_payment_id'),
				'payer_name' => $payer->getFirstName().' '.$payer->getMiddleName().' '.$payer->getLastName(),
				'payer_email' => $payer->getEmail(),
				'amount_total' => $amount->getTotal(),
				'amount_currency' => $amount->getCurrency(),
				'created_at' => date("Y-m-d H:i:s",strtotime($this->paymentResult->getCreateTime())),
				'updated_at' => date("Y-m-d H:i:s",strtotime($this->paymentResult->getUpdateTime())),
				'user_id' => Auth::user()->id
			]);
	}
	
	public function paymentAll($tourId)
	{
		\Session::put('tourID',$tourId);
		$flights = $this->flightPaymentByTour($tourId);
		$hotels = $this->hotelPaymentByTour($tourId);
		$cars = $this->carPaymentByTour($tourId);
		
		return $this->postTourPayment($flights,$hotels,$cars);
		//return $this->payFlights($flights);
		//return $this->payHotels($hotels);

	}
	public function flightPaymentByTour($tourId)
    {
    	$flight_round = DB::table('flight_round_trip')
    					->select('id','price')
    					->where('tour_id',$tourId)
    					->wherenull('payment_id')
    					->get()
    					->toArray();
    	$flightsPayment = $this->responseData($flight_round);

    	return $flightsPayment;
    }

    public function flightPaymentById($id)
    {
    	$flight_round = DB::table('flight_round_trip')
    					->select('id','price')
    					->where('id',$id)
    					->wherenull('payment_id')
    					->get()
    					->toArray();
    	$flightsPayment = $this->responseData($flight_round);

    	return $this->payFlights($flightsPayment);
    }

    public function responseData($flight_round)
    {
    	$flightsPayment = array();
    	foreach ($flight_round as $key => $value)
    	{
    		$flight_place  = DB::table('flights')
    					->select('origin_place','destination_place')
    					->where('round_trip_id',$value->id)
    					->where('type', 'Outbound')
    					->orderBy('index')
    					->get()
    					->toArray();
    		array_push($flightsPayment, array(
    			'id' => $value->id,
    			'origin_place' => $flight_place[0]->origin_place,
    			'destination_place' => $flight_place[count($flight_place) - 1]->destination_place,
    			'price' => $value->price
    			));
   		}
   		return $flightsPayment;
    }

    public function hotelPaymentByTour($tourId)
    {
   		$hotelsPayment = DB::table('hotels')
   						->select('id','name','price')
   						->where('tour_id',$tourId)
   						->wherenull('payment_id')
   						->get()
   						->toArray();
   		return $hotelsPayment;
    }


    public function hotelPaymentById($id)
    {
   		$hotelsPayment = DB::table('hotels')
   						->select('id','name','price')
   						->where('id',$id)
   						->wherenull('payment_id')
   						->get()
   						->toArray();
   		return $this->payHotels($hotelsPayment);
    }

    public function carPaymentByTour($tourId)
    {
    	
   		$carsPayment = DB::table('cars')
   						->select('id','vehicle','price')
   						->where('tour_id',$tourId)
   						->wherenull('payment_id')
   						->get()
   						->toArray();
   		return $carsPayment;
    }

    public function carPaymentById($id)
    {
    	
   		$carsPayment = DB::table('cars')
   						->select('id','vehicle','price')
   						->where('id',$id)
   						->wherenull('payment_id')
   						->get()
   						->toArray();
   		return $this->payCars($carsPayment);

    }

	// store user info for booking. get it when payment success, or forget it when user cancelled, payment fail
	public function storeSession($request)
	{
		\Session::put('user_name', $request->full_name);
		\Session::put('gender', $request->gender);

		if(isset($request->birthday))
			\Session::put('birthday', $request->birthday);
		
		\Session::put('user_phone', $request->phone);
		\Session::put('user_email', $request->email);
		\Session::put('address',$request->address);
		\Session::put('tourID', Cache::get('tourId'));
	}

	public function forgetSession($details)
	{
        \Session::forget($details);
        \Session::forget('user_name');
        \Session::forget('gender');
        \Session::forget('birthday');
        \Session::forget('user_phone');
        \Session::forget('user_email');
        \Session::forget('paypal_payment_id');
        \Session::forget('tourID');
	}

}
