<?php /** @noinspection PhpUnused */

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
     * @var SignhostClient
     */
    private $client;

    /**
     * @var string Defines the secret that can be used to verify file hashes
     */
    private $sharedSecret;

    /**
     * Determines whether the action method returns an array. They return objects when false.
     * @var bool $shouldReturnArray
     */
    private $shouldReturnArray;

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
     * @throws SignhostException
     */
    private function performRequest($method, $url, $data = null, $filePath = null)
    {
        $response = $this->client->performRequest($url, $method, $data, $filePath);

        $result = @json_decode($response, $this->shouldReturnArray);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new SignhostException('Invalid JSON returned: '. json_last_error_msg());
        }

        return $result;
    }

    /**
     * Returns the response directly (should be a Binary/PDF)
     * @param $method
     * @param $url
     * @param null $data
     * @param null $filePath
     * @return mixed
     * @throws SignhostException
     */
    private function performBinaryRequest($method, $url, $data = null, $filePath = null)
    {
        $response = $this->client->performRequest($url, $method, $data, $filePath);
        return $response;
    }

    /**
     * @throws SignHostException
     */
    public function createTransaction($transaction)
    {
        return $this->performRequest(
            'POST',
            '/transaction',
            $transaction
        );
    }

    /**
     * @throws SignHostException
     */
    public function getTransaction($transactionId)
    {
        return $this->performRequest('GET', '/transaction/' . $transactionId);
    }

    /**
     * @throws SignHostException
     */
    public function deleteTransaction($transactionId)
    {
        return $this->performRequest('DELETE', '/transaction/' . $transactionId);
    }

    /**
     * @throws SignHostException
     */
    public function startTransaction($transactionId)
    {
        $response = $this->client->performRequest("/transaction/" . $transactionId . "/start", "PUT");

        return json_decode($response,$this->shouldReturnArray);
    }

    /**
     * @throws SignHostException
     */
    public function addOrReplaceFile($transactionId, $fileId, $filePath)
    {
        return $this->performRequest(
            'PUT',
            "/transaction/$transactionId/file/" . rawurlencode($fileId),
            null,
            $filePath
        );
    }

    /**
     * @throws SignHostException
     */
    public function addOrReplaceMetadata($transactionId, $fileId, $metadata)
    {
        return $this->performRequest(
            'PUT',
            "/transaction/$transactionId/file/" . rawurlencode($fileId),
            $metadata
        );
    }

    /**
     * @throws SignHostException
     */
    public function getReceipt($transactionId)
    {
        return $this->performBinaryRequest(
            'GET',
            "/file/receipt/$transactionId"
        );
    }

    /**
     * @throws SignHostException
     */
    public function getDocument($transactionId, $fileId)
    {
        return $this->performBinaryRequest(
            'GET',
            "/transaction/$transactionId/file/" . rawurlencode($fileId)
        );
    }

    public function validateChecksum(
        string $masterTransactionId,
        string $fileId,
        string $status,
        string $remoteChecksum
    ): bool {
        $localChecksum = sha1("$masterTransactionId|$fileId|$status|{$this->sharedSecret}");
        return hash_equals($localChecksum, $remoteChecksum);
    }
}
