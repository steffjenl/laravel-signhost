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
     * Determines whether the action method returns an array. They return objects when false.
     * @var bool $shouldReturnArray
     */
    private $shouldReturnArray;

    /**
     * @var string
     */
    private $sharedSecret;

    /**
     * Signhost constructor.
     */
    public function __construct(
        SignhostClient $client,
        string $sharedSecret,
        bool $shouldReturnArray
    ) {
        $this->client            = $client;
        $this->sharedSecret      = $sharedSecret;
        $this->shouldReturnArray = $shouldReturnArray;
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

        return json_decode($response,$this->shouldReturnArray);
    }

    /**
     * getTransaction
     *
     * @param $transactionId
     * @return mixed
     * @throws SignHostException
     */
    public function getTransaction($transactionId)
    {
        $response = $this->client->execute("/transaction/" . $transactionId, "GET");

        return json_decode($response,$this->shouldReturnArray);
    }

    /**
     * deleteTransaction
     *
     * @param $transactionId
     * @return mixed
     * @throws SignHostException
     */
    public function deleteTransaction($transactionId)
    {
        $response = $this->client->execute("/transaction/" . $transactionId, "DELETE");

        return json_decode($response,$this->shouldReturnArray);
    }

    /**
     * startTransaction
     *
     * @param $transactionId
     * @return mixed
     * @throws SignHostException
     */
    public function startTransaction($transactionId)
    {
        $response = $this->client->execute("/transaction/" . $transactionId . "/start", "PUT");

        return json_decode($response,$this->shouldReturnArray);
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
    public function addOrReplaceFile($transactionId, $fileId, $filePath)
    {
        // execute command to signhost server
        $response = $this->client->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "PUT", null, $filePath);

        return json_decode($response,$this->shouldReturnArray);
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
    public function addOrReplaceMetadata($transactionId, $fileId, $metadata)
    {
        $response = $this->client->execute("/transaction/" . $transactionId . "/file/" . rawurlencode($fileId), "PUT", $metadata);

        return json_decode($response,$this->shouldReturnArray);
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
        $localChecksum = sha1("$masterTransactionId|$fileId|$status|{$this->sharedSecret}");

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
