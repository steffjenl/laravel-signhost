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
     * Signhost.com Environment
     *
     */
    'returnArray' => env('SIGNHOST_RETURNARRAY','false'),

    /*
     * Request timeout
     */
    'requestTimeout' => env('SIGNHOST_REQUEST_TIMEOUT',300),
];
