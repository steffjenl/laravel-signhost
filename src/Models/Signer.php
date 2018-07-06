<?php
namespace Signhost\Models;


class Signer
{
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
        $this->SendSignRequestMessage = $signRequestMessage;
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