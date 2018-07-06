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