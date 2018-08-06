<?php
namespace Signhost;

use Signhost\Exception\SignhostException;

/**
 * Class Signhost
 *
 * @package   laravel-signhost
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 */
class Signhost
{
    /**
     * @var SignhostClient $client
     */
    private $client;

    /**
     * @var bool $returnArray
     */
    private $returnArray;

    /**
     * Signhost constructor.
     *
     * @param $appName
     * @param $appKey
     * @param $apiKey
     * @param null $sharedSecret
     * @param string $environment
     */
    public function __construct($appName, $appKey, $apiKey, $sharedSecret = null, $environment = 'production')
    {
        $this->client = new SignhostClient($appName, $appKey, $apiKey, $sharedSecret, $environment);
        // must we return array of objects?
        $this->returnArray = config('signhost.returnArray', false);
    }

    /**
     * createTransaction
     *
     * @param $transaction
     * @return mixed
     * @throws SignHostException
     */
    public function createTransaction($transaction)
    {
        $response = $this->client->execute("/transaction", "POST", $transaction);

        return json_decode($response,$this->returnArray);
    }

    /**
     * getTransaction
     *
     * @param $transactionId
     * @return mixed
     * @throws SignHostException
     */
    public function GetTransaction($transactionId)
    {
        $response = $this->client->execute("/transaction/" . $transactionId, "GET");

        return json_decode($response,$this->returnArray);
    }

    /**
     * deleteTransaction
     *
     * @param $transactionId
     * @return mixed
     * @throws SignHostException
     */
    public function DeleteTransaction($transactionId)
    {
        $response = $this->client->execute("/transaction/" . $transactionId, "DELETE");

        return json_decode($response,$this->returnArray);
    }

    /**
     * startTransaction
     *
     * @param $transactionId
     * @return mixed
     * @throws SignHostException
     */
    public function StartTransaction($transactionId)
    {
        $response = $this->client->execute("/transaction/" . $transactionId . "/start", "PUT");

        return json_decode($response,$this->returnArray);
    }

    /**
     * addOrReplaceFile
     *
     * @param $transactionId
     * @param $fileId
     * @param $filePath
     * @return mixed
     * @throws SignHostException
     */
    public function AddOrReplaceFile($transactionId, $fileId, $filePath)
    {
        // execute command to signhost server
        $response = $this->client->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "PUT", null, $filePath);

        return json_decode($response,$this->returnArray);
    }

    /**
     * addOrReplaceMetadata
     *
     * @param $transactionId
     * @param $fileId
     * @param $metadata
     * @return mixed
     * @throws SignHostException
     */
    public function AddOrReplaceMetadata($transactionId, $fileId, $metadata)
    {
        $response = $this->client->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "PUT", $metadata);

        return json_decode($response,$this->returnArray);
    }

    /**
     * getReceipt
     *
     * @param $transactionId
     * @return stream
     * @throws SignHostException
     */
    public function getReceipt($transactionId)
    {
        $response = $this->client->execute("/file/receipt/" . $transactionId, "GET");

        return $response;
    }

    /**
     * getDocument
     *
     * @param $transactionId
     * @param $fileId
     * @return stream
     * @throws SignHostException
     */
    public function getDocument($transactionId, $fileId)
    {
        $response = $this->client->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "GET");

        return $response;
    }

    /**
     * validateChecksum
     *
     * @param $masterTransactionId
     * @param $fileId
     * @param $status
     * @param $remoteChecksum
     * @return bool
     */
    public function validateChecksum($masterTransactionId, $fileId, $status, $remoteChecksum)
    {
        $localChecksum = sha1($masterTransactionId . "|" . $fileId . "|" . $status . "|" . $this->SharedSecret);

        if (strlen($localChecksum) !== strlen($remoteChecksum)) {
            return false;
        }

        return hash_equals($remoteChecksum, $localChecksum);
    }

    /**
     * setIgnoreStatusCode
     *
     * @param $ignoreStatusCode
     * @return SignHost
     */
    public function setIgnoreStatusCode($ignoreStatusCode)
    {
        $this->client->setIgnoreStatusCode($ignoreStatusCode);
        return $this;
    }

    /**
     * setCaInfoPath
     *
     * @param $filePath
     * @return SignHost
     */
    public function setCaInfoPath($filePath)
    {
        $this->client->setCaInfoPath($filePath);
        return $this;
    }
}
