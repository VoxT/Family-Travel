<?php
// 1. Autoload the SDK Package. This will include all the files and classes to your autoloader
require __DIR__  . '/vendor/autoload.php';
// 2. Provide your Secret Key. Replace the given one with your app clientId, and Secret
// https://developer.paypal.com/webapps/developer/applications/myapps
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'Ab5i5QHB_w9LypNlkMak3O_KLMQEWrBeYSBiWHhF0q7vJHpS_mnqXXsUgIXPqduW1_iRloMR9zdleCov',     // ClientID
        'EAok6X7-s91Lma9MctGoUuMijDrmdssanoO7Ch9xnZuv_13IjRijRXIoECDMJMkhFNHgDEDGp6h_gNEO'      // ClientSecret
    )
);

// Step 2.1 : Between Step 2 and Step 3
$apiContext->setConfig(
  array(
    'log.LogEnabled' => true,
    'log.FileName' => 'PayPal.log',
    'log.LogLevel' => 'DEBUG'
  )
);

// 3. Lets try to save a credit card to Vault using Vault API mentioned here
// https://developer.paypal.com/webapps/developer/docs/api/#store-a-credit-card
$creditCard = new \PayPal\Api\CreditCard();
$creditCard->setType("visa")
    ->setNumber("4417119669820331")
    ->setExpireMonth("11")
    ->setExpireYear("2019")
    ->setCvv2("012")
    ->setFirstName("Joe")
    ->setLastName("Shopper");
// 4. Make a Create Call and Print the Card
try {
    $creditCard->create($apiContext);
    echo $creditCard;
}
catch (\PayPal\Exception\PayPalConnectionException $ex) {
    // This will print the detailed information on the exception. 
    //REALLY HELPFUL FOR DEBUGGING
    echo $ex->getData();
}