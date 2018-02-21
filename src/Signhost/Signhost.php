<?php

namespace Signhost;

use Signhost\Exception\SignhostException;

/**
 * Class Signhost
 *
 * @package   laravel-signhost
 * @author    Stephan Eizinga <stephan.eizinga@gmail.com>
 */
class Signhost
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
    public function __construct($appName, $appKey, $apiKey, $sharedSecret = null, $environment = 'production') {
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
    private function execute($endpoint, $methode, $data = null, $filecontent = null, $headers = [])
    {
        $ch = curl_init($this->rootUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        // Verify SSL connection is required
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
        // Set Authorisation headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($this->headers,$headers));
        // Set methode actions
        $ch = $this->setExecuteMethode($ch, $methode,$data,$filecontent);
        // execute curl command
        $response = curl_exec($ch);
        // check http response code
        if ($this->checkHTTPStatusCode(curl_getinfo($ch, CURLINFO_HTTP_CODE),$response) === false) {
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
        if ($methode == 'DELETE')
        {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        }
        elseif ((empty($data) && empty($file)) && $methode == 'PUT')
        {
            curl_setopt($curl, CURLOPT_PUT, 1);
        }
        elseif ((!empty($data) && empty($file)) && $methode == 'PUT')
        {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
        elseif ((empty($data) && !empty($file)) && $methode == 'PUT')
        {
            curl_setopt($curl, CURLOPT_PUT, 1);
            curl_setopt($curl, CURLOPT_INFILE, $file['handler']);
            curl_setopt($curl, CURLOPT_INFILESIZE, $file['size']);
        }
        elseif ($methode == 'POST')
        {
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
        $firstChar = substr($statusCode,0,1);
        if ($firstChar == '2')
        {
            return true;
        }
        elseif ($firstChar == '4')
        {
            // set empty message
            $message = 'Unknown error';
            // decode message from json string
            $object = json_decode($response);
            // when there is a message throw a message.
            if (!empty($object->Message))
            {
                $message = $object->Message;
            }
            throw new SignhostException($message);
        }
        return false;
    }

    /**
     * @param $transaction
     * @return mixed
     * @throws SignHostException
     */
    public function CreateTransaction($transaction) {
        $response = $this->execute("/transaction", "POST",$transaction);
        return json_decode($response);
    }

    /**
     * @param $transactionId
     * @return mixed
     * @throws SignHostException
     */
    public function GetTransaction($transactionId) {
        $response = $this->execute("/transaction/" . $transactionId, "GET");
        return json_decode($response);
    }

    /**
     * @param $transactionId
     * @return mixed
     * @throws SignHostException
     */
    public function DeleteTransaction($transactionId) {
        $response = $this->execute("/transaction/" . $transactionId, "DELETE");
        return json_decode($response);
    }

    /**
     * @param $transactionId
     * @return mixed
     * @throws SignHostException
     */
    public function StartTransaction($transactionId) {
        $response = $this->execute("/transaction/" . $transactionId . "/start", "PUT");
        return json_decode($response);
    }

    /**
     * @param $transactionId
     * @param $fileId
     * @param $filePath
     * @return mixed
     * @throws SignHostException
     */
    public function AddOrReplaceFile($transactionId, $fileId, $filePath) {
        $checksum_file = base64_encode(pack('H*', hash_file('sha256', $filePath)));
        $headers = ["Digest: SHA256=" . $checksum_file];

        // open file handler
        $fh = fopen($filePath, 'r');

        // combine handler and size in one array
        $file = [
            'handler' => $fh,
            'size' => filesize($filePath)
        ];

        // execute command to signhost server
        $response = $this->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "PUT", null, $file, $headers);

        // close file handler
        fclose($fh);
        return json_decode($response);
    }

    /**
     * @param string $transactionId
     * @param string $fileId
     * @param string $fileContent
     * @return mixed
     * @throws SignHostException
     */
    public function AddOrReplaceFileContent($transactionId, $fileId, $fileContent) {
        $checksum_file = base64_encode(pack('H*', hash('sha256', $fileContent)));
        $headers = ["Digest: SHA256=" . $checksum_file];

        // open temp file for curl
        $fh = fopen('php://temp/maxmemory:256000', 'w');
        if (!$fh) {
            die('could not open temp memory data');
        }
        fwrite($fh, $fileContent);
        fseek($fh, 0);

        // combine handler and size in one array
        $file = [
            'handler' => $fh,
            'size' => strlen($fileContent)
        ];

        $response = $this->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "PUT", null, $file, $headers);
        // close file handler
        fclose($fh);
        return json_decode($response);
    }

    /**
     * @param $transactionId
     * @param $fileId
     * @param $metadata
     * @return mixed
     * @throws SignHostException
     */
    public function AddOrReplaceMetadata($transactionId, $fileId, $metadata) {
        $response = $this->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "PUT", $metadata);
        return json_decode($response);
    }

    /**
     * @param $transactionId
     * @return stream
     * @throws SignHostException
     */
    public function GetReceipt($transactionId) {
        $response = $this->execute("/file/receipt/" . $transactionId, "GET");
        return $response;
        // Returns binary stream
    }

    /**
     * @param $transactionId
     * @param $fileId
     * @return stream
     * @throws SignHostException
     */
    public function GetDocument($transactionId, $fileId) {
        $response = $this->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "GET");
        return $response;
        // Returns binary stream
    }

    /**
     * @param $masterTransactionId
     * @param $fileId
     * @param $status
     * @param $remoteChecksum
     * @return bool
     */
    public function ValidateChecksum($masterTransactionId, $fileId, $status, $remoteChecksum) {
        $localChecksum = sha1($masterTransactionId . "|" . $fileId . "|" . $status . "|" . $this->SharedSecret);

        if (strlen($localChecksum) !== strlen($remoteChecksum)) {
            return false;
        }

        return hash_equals($remoteChecksum, $localChecksum);
    }
}
