<?php

namespace Signhost;

use Signhost\Exception\SignhostException;
use ParagonIE\Certainty\RemoteFetch;

/**
 * Class SignhostClient
 *
 * @package   laravel-signhost
 * @author    Stephan Eizinga <stephan.eizinga@gmail.com>
 */
class SignhostClient
{
    /**
     * @var string $rootUrl
     */
    private $rootUrl = 'https://api.signhost.com/api';
    /**
     * @var array $headers
     */
    private $headers;
    /**
     * @var array $sharedSecret
     */
    private $sharedSecret;

    /**
     * SignHost constructor.
     * @param string $appName
     * @param string $appKey
     * @param string $apiKey
     * @param string $sharedSecret
     * @param string $environment
     */
    public function __construct($appName, $appKey, $apiKey, $sharedSecret = null, $environment = 'production')
    {
        $this->sharedSecret = $sharedSecret;
        $this->headers = [
            "Content-Type: application/json",
            "Application: APPKey " . $appName . " " . $appKey,
            "Authorization: APIKey " . $apiKey,
        ];
    }

    /**
     * @param $endpoint
     * @param $methode
     * @param null $data
     * @param null $filecontent
     * @param array $headers
     * @return mixed
     * @throws SignHostException
     */
    public function execute($endpoint, $methode, $data = null, $filecontent = null, $headers = [])
    {
        $ch = curl_init($this->rootUrl . $endpoint);
        // get latest cabundle
        $latestBundle = (new RemoteFetch())->getLatestBundle();
        //
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        // Verify SSL connection is required
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CAINFO, $latestBundle->getFilePath());
        // Set Authorisation headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($this->headers, $headers));
        // Set methode actions
        $ch = $this->setExecuteMethode($ch, $methode, $data, $filecontent);
        // execute curl command
        $response = curl_exec($ch);
        // check http response code
        if ($this->checkHTTPStatusCode(curl_getinfo($ch, CURLINFO_HTTP_CODE), $response) === false) {
            throw new SignhostException("Internal Server Error on endpoint " . $endpoint);
        }

        return $response;
    }

    /**
     * @param $curl
     * @param string $methode
     * @param mixed $data
     * @param mixed $file
     * @return mixed
     */
    private function setExecuteMethode($curl, $methode, $data = null, $file = null)
    {
        if ($methode == 'DELETE') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        } else if ((empty($data) && empty($file)) && $methode == 'PUT') {
            curl_setopt($curl, CURLOPT_PUT, 1);
        } else if ((!empty($data) && empty($file)) && $methode == 'PUT') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        } else if ((empty($data) && !empty($file)) && $methode == 'PUT') {
            curl_setopt($curl, CURLOPT_PUT, 1);
            curl_setopt($curl, CURLOPT_INFILE, $file['handler']);
            curl_setopt($curl, CURLOPT_INFILESIZE, $file['size']);
        } else if ($methode == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        return $curl;
    }

    /**
     * @param string $statusCode
     * @param string $response
     * @return bool
     * @throws SignHostException
     */
    private function checkHTTPStatusCode($statusCode, $response)
    {
        $firstChar = substr($statusCode, 0, 1);
        if ($firstChar == '2') {
            return true;
        } else if ($firstChar == '4') {
            // set empty message
            $message = 'Unknown error';
            // decode message from json string
            $object = json_decode($response);
            // when there is a message throw a message.
            if (!empty($object->Message)) {
                $message = $object->Message;
            }
            throw new SignhostException($message);
        }

        return false;
    }
}
