<?php
namespace Signhost\Models;


class Signer
{
    /**
     * @return null
     */
    public function getSendSignRequestMessage()
    {
        return $this->SendSignRequestMessage;
    }

    /**
     * @param null $SendSignRequestMessage
     * @return Signer
     */
    public function setSendSignRequestMessage($SendSignRequestMessage)
    {
        $this->SendSignRequestMessage = $SendSignRequestMessage;

        return $this;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param null $Id
     * @return Signer
     */
    public function setId($Id)
    {
        $this->Id = $Id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param mixed $Email
     * @return Signer
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return null
     */
    public function getMobile()
    {
        return $this->Mobile;
    }

    /**
     * @param null $Mobile
     * @return Signer
     */
    public function setMobile($Mobile)
    {
        $this->Mobile = $Mobile;

        return $this;
    }

    /**
     * @return null
     */
    public function getBSN()
    {
        return $this->BSN;
    }

    /**
     * @param null $BSN
     * @return Signer
     */
    public function setBSN($BSN)
    {
        $this->BSN = $BSN;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequireScribble(): bool
    {
        return $this->RequireScribble;
    }

    /**
     * @param bool $RequireScribble
     * @return Signer
     */
    public function setRequireScribble(bool $RequireScribble): Signer
    {
        $this->RequireScribble = $RequireScribble;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequireSmsVerification(): bool
    {
        return $this->RequireSmsVerification;
    }

    /**
     * @param bool $RequireSmsVerification
     * @return Signer
     */
    public function setRequireSmsVerification(bool $RequireSmsVerification): Signer
    {
        $this->RequireSmsVerification = $RequireSmsVerification;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequireDigidVerification(): bool
    {
        return $this->RequireDigidVerification;
    }

    /**
     * @param bool $RequireDigidVerification
     * @return Signer
     */
    public function setRequireDigidVerification(bool $RequireDigidVerification): Signer
    {
        $this->RequireDigidVerification = $RequireDigidVerification;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequireKennisnetVerification(): bool
    {
        return $this->RequireKennisnetVerification;
    }

    /**
     * @param bool $RequireKennisnetVerification
     * @return Signer
     */
    public function setRequireKennisnetVerification(bool $RequireKennisnetVerification): Signer
    {
        $this->RequireKennisnetVerification = $RequireKennisnetVerification;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequireSurfnetVerification(): bool
    {
        return $this->RequireSurfnetVerification;
    }

    /**
     * @param bool $RequireSurfnetVerification
     * @return Signer
     */
    public function setRequireSurfnetVerification(bool $RequireSurfnetVerification): Signer
    {
        $this->RequireSurfnetVerification = $RequireSurfnetVerification;

        return $this;
    }

    /**
     * @return array
     */
    public function getVerifications(): array
    {
        return $this->Verifications;
    }

    /**
     * @param array $Verifications
     * @return Signer
     */
    public function setVerifications(array $Verifications): Signer
    {
        $this->Verifications = $Verifications;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSendSignRequest(): bool
    {
        return $this->SendSignRequest;
    }

    /**
     * @param bool $SendSignRequest
     * @return Signer
     */
    public function setSendSignRequest(bool $SendSignRequest): Signer
    {
        $this->SendSignRequest = $SendSignRequest;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSignRequestMessage()
    {
        return $this->SignRequestMessage;
    }

    /**
     * @param mixed $SignRequestMessage
     * @return Signer
     */
    public function setSignRequestMessage($SignRequestMessage)
    {
        $this->SignRequestMessage = $SignRequestMessage;

        return $this;
    }

    /**
     * @return null
     */
    public function getSendSignConfirmation()
    {
        return $this->SendSignConfirmation;
    }

    /**
     * @param null $SendSignConfirmation
     * @return Signer
     */
    public function setSendSignConfirmation($SendSignConfirmation)
    {
        $this->SendSignConfirmation = $SendSignConfirmation;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->Language;
    }

    /**
     * @param string $Language
     * @return Signer
     */
    public function setLanguage(string $Language): Signer
    {
        $this->Language = $Language;

        return $this;
    }

    /**
     * @return null
     */
    public function getScribbleName()
    {
        return $this->ScribbleName;
    }

    /**
     * @param null $ScribbleName
     * @return Signer
     */
    public function setScribbleName($ScribbleName)
    {
        $this->ScribbleName = $ScribbleName;

        return $this;
    }

    /**
     * @return bool
     */
    public function isScribbleNameFixed(): bool
    {
        return $this->ScribbleNameFixed;
    }

    /**
     * @param bool $ScribbleNameFixed
     * @return Signer
     */
    public function setScribbleNameFixed(bool $ScribbleNameFixed): Signer
    {
        $this->ScribbleNameFixed = $ScribbleNameFixed;

        return $this;
    }

    /**
     * @return int
     */
    public function getDaysToRemind(): int
    {
        return $this->DaysToRemind;
    }

    /**
     * @param int $DaysToRemind
     * @return Signer
     */
    public function setDaysToRemind(int $DaysToRemind): Signer
    {
        $this->DaysToRemind = $DaysToRemind;

        return $this;
    }

    /**
     * @return null
     */
    public function getExpires()
    {
        return $this->Expires;
    }

    /**
     * @param null $Expires
     * @return Signer
     */
    public function setExpires($Expires)
    {
        $this->Expires = $Expires;

        return $this;
    }

    /**
     * @return null
     */
    public function getReference()
    {
        return $this->Reference;
    }

    /**
     * @param null $Reference
     * @return Signer
     */
    public function setReference($Reference)
    {
        $this->Reference = $Reference;

        return $this;
    }

    /**
     * @return string
     */
    public function getReturnUrl(): string
    {
        return $this->ReturnUrl;
    }

    /**
     * @param string $ReturnUrl
     * @return Signer
     */
    public function setReturnUrl(string $ReturnUrl): Signer
    {
        $this->ReturnUrl = $ReturnUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActivities()
    {
        return $this->Activities;
    }

    /**
     * @param mixed $Activities
     * @return Signer
     */
    public function setActivities($Activities)
    {
        $this->Activities = $Activities;

        return $this;
    }

    /**
     * @return null
     */
    public function getContext()
    {
        return $this->Context;
    }

    /**
     * @param null $Context
     * @return Signer
     */
    public function setContext($Context)
    {
        $this->Context = $Context;

        return $this;
    }
    public $Id; // String
    public $Email; // String
    public $Mobile; // String
    public $BSN; // String
    public $RequireScribble; // Boolean
    public $RequireSmsVerification; // Boolean
    public $RequireDigidVerification; // Boolean
    public $RequireKennisnetVerification; // Boolean
    public $RequireSurfnetVerification; // Boolean
    public $Verifications; // Array of Verification
    public $SendSignRequest; // Boolean
    public $SignRequestMessage; // String
    public $SendSignConfirmation; // Boolean
    public $Language; // String (enum)
    public $ScribbleName; // String
    public $ScribbleNameFixed; // Boolean
    public $DaysToRemind; // Integer
    public $Expires; // String
    public $Reference; // String
    public $ReturnUrl; // String
    public $Activities; // Array of Activity
    public $Context; // Any object

    function __construct(
        $email,
        $id = null,
        $mobile = null,
        $bsn = null,
        $requireScribble = false,
        $requireSmsVerification = false,
        $requireDigidVerification = false,
        $requireKennisnetVerification = false,
        $requireSurfnetVerification = false,
        $verifications = array(),
        $sendSignRequest = false,
        $signRequestMessage = null,
        $sendSignConfirmation = null,
        $language = "nl-NL",
        $scribbleName = null,
        $scribbleNameFixed = false,
        $daysToRemind = 7,
        $expires = null,
        $reference = null,
        $returnUrl = "https://signhost.com",
        $context = null) {
        $this->Id = $id;
        $this->Email = $email;
        $this->Mobile = $mobile;
        $this->BSN = $bsn;
        $this->RequireScribble = $requireScribble;
        $this->RequireSmsVerification = $requireSmsVerification;
        $this->RequireDigidVerification = $requireDigidVerification;
        $this->RequireKennisnetVerification = $requireKennisnetVerification;
        $this->RequireSurfnetVerification = $requireSurfnetVerification;
        $this->Verifications = $verifications;
        $this->SendSignRequest = $sendSignRequest;
        $this->SignRequestMessage = $signRequestMessage;
        $this->SendSignConfirmation = $sendSignConfirmation;
        $this->Language = $language;
        $this->ScribbleName = $scribbleName;
        $this->ScribbleNameFixed = $scribbleNameFixed;
        $this->DaysToRemind = $daysToRemind;
        $this->Expires = $expires;
        $this->Reference = $reference;
        $this->ReturnUrl = $returnUrl;
        $this->Context = $context;
    }
}