<?php
return array(
    // set your paypal credential
    'client_id' => 'Ab5i5QHB_w9LypNlkMak3O_KLMQEWrBeYSBiWHhF0q7vJHpS_mnqXXsUgIXPqduW1_iRloMR9zdleCov',
    'secret' => 'EAok6X7-s91Lma9MctGoUuMijDrmdssanoO7Ch9xnZuv_13IjRijRXIoECDMJMkhFNHgDEDGp6h_gNEO',
    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',
        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);