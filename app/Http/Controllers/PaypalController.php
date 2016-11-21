<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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


class PaypalController extends Controller
{
    private $_api_context;
    private $result;

    public function __construct()
    {
        // setup PayPal api context
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function postFlightPayment($flight_details)
	{
        $input = $flight_details['input'];
        $flights = $flight_details['flight'];

	    $item = new Item();
	    $item->setName($flights->Outbound->overall->originName.' - '.$flights->Outbound->overall->destinationName) // item name
	        ->setCurrency('USD')
	        ->setQuantity(1)
	        ->setPrice($flights->Price); // unit price

	    // add item to list
	    $item_list = new ItemList();
	    $item_list->setItems(array($item));
	    $amount = new Amount();
	    $amount->setCurrency('USD')
	        ->setTotal($flights->Price);

	    $transaction = new Transaction();
	    $transaction->setAmount($amount)
	        ->setItemList($item_list)
	        ->setDescription('Your transaction description');

	    return $this->Payment($transaction,'payment.status.flight');
	    
	}

	public function saveFlightPayment()
	{
		$this->getPaymentStatus();

	    //echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT, remove it later
	    if ($this->result>getState() == 'approved') { // payment made
	    	$tourId = \Session::get('tourID'); \Session::forget('tourID');
	        return redirect('report'.$tourId)
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
	    $payment_id = Input::get('paymentId'); //\Session::get('paypal_payment_id');
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
	    $this->result = $payment->execute($execution, $this->_api_context);
	}

}
