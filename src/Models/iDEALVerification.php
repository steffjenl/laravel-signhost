<?php
namespace Signhost\Models;


class iDEALVerification
{
    public $Iban; // String
    public $AccountHolderName; // String
    public $AccountHolderCity; // String

    function __construct($type, $iban = null) {
        parent::__construct($type);
        $this->Iban = $iban;
    }
}