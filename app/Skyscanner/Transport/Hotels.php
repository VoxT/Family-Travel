<?php

namespace App\Skyscanner\Transport;

/**
 * Class Hotels
 * @package Skyscanner\Transport
 * @author * *
 */
class Hotels extends Transport
{
    /**
     * @var string
     */
    private $pricingSessionUrl;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->pricingSessionUrl = self::API_HOST . '/apiservices/hotels/liveprices/v3';
        parent::__construct($apiKey);
    }

    /**
     * @param array $params
     *
     * @return string
     */
    public function createSession(array $params = [])
    {
        $reqParams = array(
            'market',
            'currency',
            'locale',
            'entityid',
            'checkindate',
            'checkoutdate',
            'guests',
            'rooms'
        );
        $paramsPath = self::constructParams($params, $reqParams);
        $serviceUrl = "{$this->pricingSessionUrl}/{$paramsPath}";
        $callback = array('self', 'getPollURL');
        $pollPath = $this->makeRequest(
            $serviceUrl,
            self::GET,
            null,
            null,
            $callback,
            self::STRICT,
            $params
        );

        return self::API_HOST . $pollPath;
    }
    public function createHotelDetails($sessionKey,array $addParams = [])
    {
        $callback = array('self', 'getPollURL');
        $pollPath = $this->makeRequest(
            $sessionKey,
            self::GET,
            null,
            null,
            $callback,
            self::STRICT,
            $addParams
        );
        return self::API_HOST . $pollPath;
    }
}

