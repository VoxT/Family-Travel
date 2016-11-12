<?php

namespace App\Skyscanner\Transport;

use Exception;
use BadFunctionCallException;
use UnexpectedValueException;
use RuntimeException;
use Katzgrau;
use Psr\Log\LogLevel;
use App\Skyscanner\Utils\NetworkUtils;



/**
 * Class Transport
 * @package Skyscanner\Transport
 */
class Transport
{

    const API_HOST = 'http://partners.api.skyscanner.net';

    const STRICT = 'strict';
    const GRACEFUL = 'graceful';
    const IGNORE = 'ignore';

    const GET = 'get';
    const POST = 'post';
    const PUT = 'put';

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $marketServiceUrl;

    /**
     * @var string
     */
    protected $locationAutosuggestUrl;

    /**
     * @var array
     */
    protected $locationAutosuggestParams;

    protected $response_format;

    /**
     * @var string
     */
//    protected static $responseFormat;

    public function setResponseFormat($response_format)
    {
        $this->response_format = $response_format;
    }

    public function getResponseFormat()
    {
        return $this->response_format;
    }

    /**
     * @param string $apiKey
     * @param string $responseFormat
     */
    public function __construct($apiKey, $responseFormat = 'json')
    {
//        self::$responseFormat = strtolower($responseFormat);
        $this->setResponseFormat($responseFormat);

        if (!$apiKey) {
            throw new BadFunctionCallException('API Key must be specified.');
        }
        $this->apiKey = $apiKey;
        $this->marketServiceUrl = self::API_HOST . '/apiservices/reference/v1.0/countries';
        $this->locationAutosuggestUrl = self::API_HOST . '/apiservices/autosuggest/v1.0';
        $this->locationAutosuggestParams = array('market', 'currency', 'locale', 'query');
    }

    /**
     * @param string $serviceUrl
     * @param string $method
     * @param null $headers
     * @param null $data
     * @param null $callback
     * @param string $errors
     * @param array $params
     * @return mixed
     */
    protected function makeRequest(
        $serviceUrl,
        $method = self::GET,
        $headers = null,
        $data = null,
        $callback = null,
        $errors = self::STRICT,
        array $params = []
    ) {
        $timeout = 30;
        $errorModes = array(self::STRICT, self::GRACEFUL, self::IGNORE);
        $errorMode = $errors;

        if (!in_array($errorMode, $errorModes)) {
            throw new UnexpectedValueException('Possible values for errors argument are: ' . implode(", ", $errorModes));
        }

        if ($callback == null) {
            $callback = array('self', 'defaultRespCallback');
        }

        // echo "strpos: " . strpos('apikey', strtolower($serviceUrl));
//        if (strpos(strtolower($serviceUrl), 'apikey') == false) {
//            echo "API key not found in: " . $serviceUrl;
        if (strpos($serviceUrl, 'apikey') === false) {
            $params['apiKey'] = $this->apiKey;
        }
            
//        }
        if (count($params) > 0 ) {
            if (strpos($serviceUrl, 'apikey') === false)
                $serviceUrl .= '?' . http_build_query($params);
            else
                $serviceUrl .= '&' . http_build_query($params);
        }
        // if ($callback == array('self', 'getPollURL')) {
        //     unset($params['apiKey']);
        // }
        // use our own httpRequest function if HttpRequest class is not available.
        $r = NetworkUtils::httpRequest($serviceUrl, $headers, $method, $data);
        
        if('HTTP/1.1 200'== substr($r,0,12)||'HTTP/1.1 201'== substr($r,0,12)||'HTTP/1.1 302'== substr($r,0,12)){
             return call_user_func($callback, $r);
        }
        else
            return false; 
    }

    /**
     * @param $market
     *
     * @return mixed
     */
    public function getMarkets($market)
    {
        $serviceUrl = "{$this->marketServiceUrl}/{$market}";
        return $this->makeRequest($serviceUrl, self::GET, $this->sessionHeaders());
    }

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function locationAutosuggest(array $params = [])
    {
        $paramsPath = self::constructParams($params, $this->locationAutosuggestParams);
        $serviceUrl = "{$this->locationAutosuggestUrl}/{$paramsPath}";
        return $this->makeRequest($serviceUrl);
    }

    /**
     *
     */
    public function createSession()
    {
        throw new NotImplementedException();
    }

    /**
     * @param string $pollUrl
     * @param float $initialDelay
     * @param int $delay
     * @param int $tries
     * @param string $errors
     * @param array $params
     * @return mixed|null
     * @throws ExceededRetriesException
     */
    public function poll(
        $pollUrl,
        $initialDelay = null,   // float
        $delay = 1,
        $tries = 10,
        $errors = self::STRICT,
        array $params = []
    ) {
        $initialDelay = ($initialDelay == null) ? 2.0 : $initialDelay;
        sleep($initialDelay);
        $pollResponse = null;

        for ($n = 0; $n < $tries; $n++) {
            $pollResponse = $this->makeRequest(
                $pollUrl,
                self::GET,
                null,
                null,
                null,
                $errors,
                $params
            );
            if ($pollResponse && $this->isPollComplete($pollResponse)) {
                return $pollResponse;
            } else {
                sleep($delay);
            }
        }

        if (self::STRICT == $errors) {
            throw new ExceededRetriesException("Failed to poll within {$tries} tries.");
        } else {
            return $pollResponse;
        }
    }

    /**
     * @param $pollResp
     *
     * @return bool
     */
    public function isPollComplete($pollResp)
    {
        if (!$pollResp->parsed) {
            return false;
        }

        $successList = array('UpdatesComplete', True, 'COMPLETE');
        
        $status = isset($pollResp->parsed->Status) ? $pollResp->parsed->Status : $pollResp->parsed->status;
        if (!$status) {
            throw new RuntimeException('Unable to get poll response status.');
        }
        if(($status === 'UpdatesComplete')|| ($status ==='COMPLETE')|| ($status === True))
             return true;
         else
            return false;
    }

    /**
     * @param string $errors
     * @param array $params
     * @return mixed|null
     * @throws ExceededRetriesException
     */
    public function getResult($errors = self::STRICT, array $params = [], array $addParams = [])
    {
        return $this->poll($this->createSession($params), null, 1, 10, $errors, $addParams);
    }
    public function getResultHotelDetails($errors = self::STRICT, $sessionKey, array $addParams = [])
    {
        return $this->poll($this->createHotelDetails($sessionKey,$addParams), null, 1, 10, $errors);
    }

    public function getResultWithSession($errors = self::STRICT, $sessionKey, array $addParams = [])
    {
        return $this->poll($sessionKey, null, 2, 10, $errors, $addParams);
    }
    /**
     * @param $params
     * @param $requiredKeys
     * @param null $optKeys
     * @return string
     */
    public static function constructParams($params, $requiredKeys, $optKeys = null)
    {
        $params_list = array();
        foreach($requiredKeys as $requiredKey) {
            if (!array_key_exists($requiredKey, $params)) {
                print("\n$requiredKey does not exist");
                throw new BadFunctionCallException("'Missing expected request parameter: $requiredKey");
            } else {
                $params_list[] = $params[$requiredKey];
            }
        }
        // TODO: optKeys
        if (is_array($optKeys)) {
            foreach($optKeys as $optKey) {
                $params_list[] = $params[$optKey];
            }
        }
        return implode($params_list, "/");
    }

    /**
     * @return array
     */
    public function sessionHeaders()
    {
        $headers = $this->headers();
        $headers[] = 'content-type: application/x-www-form-urlencoded';
        return $headers;
    }

    /**
     * @return array
     */
    public function headers()
    {
        return array("accept: application/" . $this->getResponseFormat());
    }

    /**
     * @param $resp
     * @return object
     */
    public function defaultRespCallback($resp)
    {
        return self::parseResp($resp, $this->getResponseFormat());
    }

    /**
     * @param $resp
     * @param $responseFormat
     *
     * @return object
     *
     * @throws BadJSONException
     */
    public static function parseResp($resp, $responseFormat)
    {
        if ($responseFormat == 'json') {
            $resp = NetworkUtils::getJSONStr($resp);

            $jsonObj = json_decode($resp);

            $respObj = array();
            $respObj['parsed'] = $jsonObj;
            return (object) $respObj;
        } else if ($responseFormat == 'xml') {
            // TODO: handle XML
        }
    }

    /**
     * @param $resp
     * @param $error
     * @param $mode
     *
     * @return mixed
     */
    public static function withErrorHandling($resp, $error, $mode)
    {
        echo "=================Trying with error handling...";
        // TODO
        return json_decode($resp);
    }

    /**
     * @param $resp
     *
     * @return mixed
     */
    public static function getPollURL($resp)
    {
        $headers = NetworkUtils::getHeaders($resp);
        return $headers['Location'];
    }
}
