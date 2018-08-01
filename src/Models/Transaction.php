<?php
namespace Signhost\Models;


/**
 * Class Transaction
 * @package Signhost\Models
 */
class Transaction
{
    /**
     * @var string
     */
    public $Id; // String
    /**
     * @var
     */
    public $Files; // Map of <String,FileEntry>
    /**
     * @var bool
     */
    public $Seal;
    /**
     * @var array
     */
    public $Signers;
    /**
     * @var array
     */
    public $Receivers;
    /**
     * @var string
     */
    public $Reference;
    /**
     * @var string
     */
    public $PostbackUrl;
    /**
     * @var int
     */
    public $SignRequestMode;
    /**
     * @var int
     */
    public $DaysToExpire;
    /**
     * @var bool
     */
    public $SendEmailNotifications;
    /**
     * @var integer(enum)
     */
    public $Status;
    /**
     * @var mixed
     */
    public $Context;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->Id;
    }

    /**
     * @param string $Id
     * @return Transaction
     */
    public function setId(string $Id): Transaction
    {
        $this->Id = $Id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->Files;
    }

    /**
     * @param mixed $Files
     * @return Transaction
     */
    public function setFiles($Files)
    {
        $this->Files = $Files;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSeal(): bool
    {
        return $this->Seal;
    }

    /**
     * @param bool $Seal
     * @return Transaction
     */
    public function setSeal(bool $Seal): Transaction
    {
        $this->Seal = $Seal;

        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->Reference;
    }

    /**
     * @param string $Reference
     * @return Transaction
     */
    public function setReference(string $Reference): Transaction
    {
        $this->Reference = $Reference;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostbackUrl(): string
    {
        return $this->PostbackUrl;
    }

    /**
     * @param string $PostbackUrl
     * @return Transaction
     */
    public function setPostbackUrl(string $PostbackUrl): Transaction
    {
        $this->PostbackUrl = $PostbackUrl;

        return $this;
    }

    /**
     * @return int
     */
    public function getSignRequestMode(): int
    {
        return $this->SignRequestMode;
    }

    /**
     * @param int $SignRequestMode
     * @return Transaction
     */
    public function setSignRequestMode(int $SignRequestMode): Transaction
    {
        $this->SignRequestMode = $SignRequestMode;

        return $this;
    }

    /**
     * @return int
     */
    public function getDaysToExpire(): int
    {
        return $this->DaysToExpire;
    }

    /**
     * @param int $DaysToExpire
     * @return Transaction
     */
    public function setDaysToExpire(int $DaysToExpire): Transaction
    {
        $this->DaysToExpire = $DaysToExpire;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSendEmailNotifications(): bool
    {
        return $this->SendEmailNotifications;
    }

    /**
     * @param bool $SendEmailNotifications
     * @return Transaction
     */
    public function setSendEmailNotifications(bool $SendEmailNotifications): Transaction
    {
        $this->SendEmailNotifications = $SendEmailNotifications;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->Status;
    }

    /**
     * @param int $Status
     * @return Transaction
     */
    public function setStatus(int $Status): Transaction
    {
        $this->Status = $Status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContext()
    {
        return $this->Context;
    }

    /**
     * @param mixed $Context
     * @return Transaction
     */
    public function setContext($Context)
    {
        $this->Context = $Context;

        return $this;
    }

    /**
     * Transaction constructor.
     * @param bool $seal
     * @param array $signers
     * @param array $receivers
     * @param null $reference
     * @param null $postbackUrl
     * @param int $signRequestMode
     * @param int $daysToExpire
     * @param bool $sendEmailNotifications
     * @param null $context
     */
    function __construct(
        $seal = false,
        $signers = [],
        $receivers = [],
        $reference = null,
        $postbackUrl = null,
        $signRequestMode = 2,
        $daysToExpire = 60,
        $sendEmailNotifications = false,
        $context = null) {
        $this->Seal = $seal;
        $this->Signers = $signers;
        $this->Receivers = $receivers;
        $this->Reference = $reference;
        $this->PostbackUrl = $postbackUrl;
        $this->SignRequestMode = $signRequestMode;
        $this->DaysToExpire = $daysToExpire;
        $this->SendEmailNotifications = $sendEmailNotifications;
        $this->Context = $context;
    }

    public function setSigner(Signer $signer)
    {
        $this->Signers[] = $signer;
        return $this;
    }

    public function setReceiver(Receiver $receiver)
    {
        $this->Receivers[] = $receiver;
        return $this;
    }
}