<?php

namespace Signhost;

use Signhost\Exception\SignhostException;
use function curl_setopt;
use function curl_init;
use function curl_exec;
use function curl_getinfo;
use function fopen;
use function fclose;
use function array_replace;
use function array_merge;
use function json_decode;
use function json_encode;
use function filesize;
use function substr;
use function base64_encode;
use function pack;
use function hash_file;

/**
 * Class SignhostClient
 *
 * @package   laravel-signhost
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 */
class SignhostClient
{
    const OPT_CAINFOPATH = 'ca-info-path';
    const OPT_URL        = 'url';
    const OPT_TIMEOUT    = 'timeout';

    private static $KNOWN_OPTIONS = [
        self::OPT_CAINFOPATH,
        self::OPT_URL,
        self::OPT_TIMEOUT
    ];

    /**
     * @var string $rootUrl
     */
    private $rootUrl = 'https://api.signhost.com/api';
    /**
     * @var array $headers
     */
    private $headers;

    private $options = [];

    /**
     * @var string $caInfoPath
     */
    private $caInfoPath;

    /**
     * @var bool $ignoreStatusCode
     */
    private $ignoreStatusCode = false;
    /**
     * @var array
     */
    private $requestOptions;

    /**
     * @return bool
     */
    public function isIgnoreStatusCode(): bool
    {
        return $this->ignoreStatusCode;
    }

    public function setIgnoreStatusCode(bool $ignoreStatusCode): void
    {
        $this->ignoreStatusCode = $ignoreStatusCode;
    }

    /**
     * @param string $caInfoPath
     * @return SignhostClient
     */
    public function setCaInfoPath($caInfoPath): self
    {
        $this->requestOptions[self::OPT_CAINFOPATH] = $caInfoPath;
        return $this;
    }


    public function __construct(
        string $appName,
        string $appKey,
        string $apiKey,
        array $requestOptions = []
    ) {
        $this->headers = [
            'Content-Type: application/json',
            "Application: APPKey $appName $appKey",
            "Authorization: APIKey $apiKey",
        ];

        $this->requestOptions = $requestOptions;
        foreach ($this->requestOptions as $optionName => $value) {
            if (!in_array($optionName, self::$KNOWN_OPTIONS)) {
                throw new \InvalidArgumentException("Unknown request option: $optionName");
            }
        }
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

        $targetUrl = $this->requestOptions[self::OPT_URL] ?? $this->rootUrl;

        // Initialize a cURL session
        $ch = curl_init($targetUrl . $endpoint);
        // Set methode actions
        $ch = $this->setExecuteMethode($ch, $method, $data, $filePath);
        // when $filePath is set we must open the file for curl
        if (isset($filePath)) {
            // open file handler
            $fh = fopen($filePath, 'rb');
            // bind file handler and curl handler
            curl_setopt($ch, CURLOPT_INFILE, $fh);
            // calculate file Checksum
            $fileChecksum = $this->calculateFileChecksum($filePath);
            // replace Content-Type header with application/pdf
            $headers = array_replace($headers, [0 => "Content-Type: application/pdf"]);
            // merge filechecksum with other headers
            $headers = array_merge($headers, ["Digest: SHA256=" . $fileChecksum]);
        }
        // Set default curl options for better security and performance
        $ch = $this->setDefaultCurlOptions($ch);
        // Set Authorisation headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // execute curl command
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new SignhostException(
                'Request to Signhost failed: ' . curl_error($ch),
                0
            );
        }
        
        // when $fh is set for file upload we must close it for free up memory and remove any lock
        if (isset($fh)) {
            // close file handler
            fclose($fh);
        }

        $this->assertSuccessfulResponse(curl_getinfo($ch, CURLINFO_HTTP_CODE), $response);

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
        // Tell curl what timeout to use
        if (isset($this->requestOptions[self::OPT_TIMEOUT])) {
            curl_setopt($curl,CURLOPT_TIMEOUT, $this->requestOptions[self::OPT_TIMEOUT]);
        }

        // Tell curl where to find the root CA's we trust.
        if (isset($this->requestOptions[self::OPT_CAINFOPATH])) {
            curl_setopt($curl, CURLOPT_CAINFO, $this->requestOptions[self::OPT_CAINFOPATH]);
        }

        // We want the response returned from curl_exec()
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // Don't reuse connections
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);

        // Make sure the x509 certificate presented is valid
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);

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
     * @throws SignHostException
     */
    private function assertSuccessfulResponse($statusCode, $response)
    {
        if ($statusCode < 400) {
            return;
        }

        if ($statusCode >= 400 && $statusCode <= 499) {
            // decode message from json string
            $object = json_decode($response, false);
            $message = $object->Message ?? 'Unknown error';

            throw new SignhostException(
                "Response: $statusCode - $message",
                $statusCode
            );
        }

        if ($statusCode > 500 && $statusCode <= 599) {
            throw new SignhostException(
                "Response: $statusCode - Internal Server Error on Signhost.com server.",
                $statusCode
            );
        }
    }

    /**
     * Calculate hash checksum for file upload
     *
     * @param $filePath
     * @return string
     */
    private function calculateFileChecksum($filePath)
    {
        return base64_encode(pack('H*', hash_file('sha256', $filePath)));
    }
}
