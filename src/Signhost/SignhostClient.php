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
     *
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
     * Execute function
     *
     * @param $endpoint
     * @param $method
     * @param null $data
     * @param null $filePath
     * @param array $headers
     * @return mixed
     * @throws SignHostException
     */
    public function execute($endpoint, $method, $data = null, $filePath = null, $headers = [])
    {
        // get defailt headers
        $headers = $this->headers;
        // Initialize a cURL session
        $ch = curl_init($this->rootUrl . $endpoint);
        // Set methode actions
        $ch = $this->setExecuteMethode($ch, $method, $data, $filePath);
        // when $filePath is set we must open the file for curl
        if (isset($filePath))
        {
            // open file handler
            $fh = fopen($filePath, 'r');
            // bind file handler and curl handler
            curl_setopt($ch, CURLOPT_INFILE, $fh);
            // calculate file Checksum
            $fileChecksum = $this->calculateFileChecsum($filePath);
            // replace Content-Type header with application/pdf
            $headers = array_replace($headers,[0 => "Content-Type: application/pdf"]);
            // merge filechecksum with other headers
            $headers = array_merge($headers,["Digest: SHA256=" . $fileChecksum]);
        }
        // Set default curl options for better security and performance
        $ch = $this->setDefaultCurlOptions($ch);
        // Set Authorisation headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // execute curl command
        $response = curl_exec($ch);
        // when $fh is set for file upload we must close it for free up memory and remove any lock
        if (isset($fh))
        {
            // close file handler
            fclose($fh);
        }
        // check http response code
        $this->checkHTTPStatusCode(curl_getinfo($ch, CURLINFO_HTTP_CODE), $response);
        // return response
        return $response;
    }

    /**
     * setDefaultCurlOptions will set default secure curl options
     *
     * @param $curl
     * @return mixed
     */
    private function setDefaultCurlOptions($curl)
    {
        // get latest cabundle
        $latestBundle = (new RemoteFetch())->getLatestBundle();
        //
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
        // Verify SSL connection is required
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_CAINFO, $latestBundle->getFilePath());

        return $curl;
    }

    /**
     * setExecuteMethode will set curl options
     *
     * @param $curl
     * @param string $method
     * @param mixed $data
     * @param mixed $filePath
     * @return mixed
     */
    private function setExecuteMethode($curl, $method, $data = null, $filePath = null)
    {
        if ($method == 'DELETE') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        } else if ((empty($data) && empty($file)) && $method == 'PUT') {
            curl_setopt($curl, CURLOPT_PUT, 1);
        } else if ((!empty($data) && empty($file)) && $method == 'PUT') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        } else if ((empty($data) && !empty($file)) && $method == 'PUT') {
            curl_setopt($curl, CURLOPT_PUT, 1);
            curl_setopt($curl, CURLOPT_INFILESIZE, filesize($filePath));
        } else if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        return $curl;
    }

    /**
     * Check http status code for errors
     *
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
            throw new SignhostException("Signhost reports:" . $message);
        } else if ($firstChar == '5') {
            throw new SignhostException("Signhost reports:" . "Internal Server Error on signhost server.");
        }

        return false;
    }

    /**
     * Calculate hash checksum for file upload
     * 
     * @param $filePath
     * @return string
     */
    private function calculateFileChecsum($filePath)
    {
        return base64_encode(pack('H*', hash_file('sha256', $filePath)));
    }
}