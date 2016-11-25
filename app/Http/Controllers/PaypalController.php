<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

	// store user info for booking. get it when payment success, or forget it when user cancelled, payment fail
	public function storeSession($request)
	{
		\Session::put('user_name', $request->full_name);
		\Session::put('user_phone', $request->phone);
		\Session::put('user_email', $request->email);
		\Session::put('address',$request->address);
		\Session::put('tourID', $request->tourId);
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
