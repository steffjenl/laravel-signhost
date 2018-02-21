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
     * @var SignhostClient $headers
     */
    private $client;

    public function __construct($appName, $appKey, $apiKey, $sharedSecret = null, $environment = 'production')
    {
        $this->client = new SignhostClient($appName, $appKey, $apiKey, $sharedSecret, $environment);
    }

    /**
     * @param $transaction
     * @return mixed
     * @throws SignHostException
     */
    public function CreateTransaction($transaction)
    {
        $response = $this->client->execute("/transaction", "POST", $transaction);

        return json_decode($response);
    }

    /**
     * @param $transactionId
     * @return mixed
     * @throws SignHostException
     */
    public function GetTransaction($transactionId)
    {
        $response = $this->client->execute("/transaction/" . $transactionId, "GET");

        return json_decode($response);
    }

    /**
     * @param $transactionId
     * @return mixed
     * @throws SignHostException
     */
    public function DeleteTransaction($transactionId)
    {
        $response = $this->client->execute("/transaction/" . $transactionId, "DELETE");

        return json_decode($response);
    }

    /**
     * @param $transactionId
     * @return mixed
     * @throws SignHostException
     */
    public function StartTransaction($transactionId)
    {
        $response = $this->client->execute("/transaction/" . $transactionId . "/start", "PUT");

        return json_decode($response);
    }

    /**
     * @param $transactionId
     * @param $fileId
     * @param $filePath
     * @return mixed
     * @throws SignHostException
     */
    public function AddOrReplaceFile($transactionId, $fileId, $filePath)
    {
        $checksum_file = base64_encode(pack('H*', hash_file('sha256', $filePath)));
        $headers = ["Digest: SHA256=" . $checksum_file];

        // open file handler
        $fh = fopen($filePath, 'r');

        // combine handler and size in one array
        $file = [
            'handler' => $fh,
            'size'    => filesize($filePath),
        ];

        // execute command to signhost server
        $response = $this->client->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "PUT", null, $file, $headers);

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
    public function AddOrReplaceFileContent($transactionId, $fileId, $fileContent)
    {
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
            'size'    => strlen($fileContent),
        ];

        $response = $this->client->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "PUT", null, $file, $headers);
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
    public function AddOrReplaceMetadata($transactionId, $fileId, $metadata)
    {
        $response = $this->client->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "PUT", $metadata);

        return json_decode($response);
    }

    /**
     * @param $transactionId
     * @return stream
     * @throws SignHostException
     */
    public function GetReceipt($transactionId)
    {
        $response = $this->client->execute("/file/receipt/" . $transactionId, "GET");

        return $response;
    }

    /**
     * @param $transactionId
     * @param $fileId
     * @return stream
     * @throws SignHostException
     */
    public function GetDocument($transactionId, $fileId)
    {
        $response = $this->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "GET");

        return $response;
    }

    /**
     * @param $masterTransactionId
     * @param $fileId
     * @param $status
     * @param $remoteChecksum
     * @return bool
     */
    public function ValidateChecksum($masterTransactionId, $fileId, $status, $remoteChecksum)
    {
        $localChecksum = sha1($masterTransactionId . "|" . $fileId . "|" . $status . "|" . $this->SharedSecret);

        if (strlen($localChecksum) !== strlen($remoteChecksum)) {
            return false;
        }

        return hash_equals($remoteChecksum, $localChecksum);
    }
}
