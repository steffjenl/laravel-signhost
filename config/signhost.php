<?php

return [
    /*
     * Signhost.com AppName
     *
     */
    'appname' => env('SIGNHOST_APPNAME'),

    /*
     * Signhost.com AppName
     *
     */
    'appkey' => env('SIGNHOST_APPKEY'),

    /*
     * Signhost.com ApiKey
     *
     */
    'apikey' => env('SIGNHOST_APIKEY'),

    /*
     * Signhost.com SharedSecret
     *
     */
    'sharedsecret' => env('SIGNHOST_SHAREDSECRET'),

    /*
     * Defines whether to return arrays or objects
     */
    'returnArray' => env('SIGNHOST_RETURNARRAY','false'),

    /*
     * Request timeout
     */
    'requestTimeout' => env('SIGNHOST_REQUEST_TIMEOUT',300),
];
