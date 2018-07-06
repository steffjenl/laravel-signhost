<?php
namespace Signhost\Models;


class iDINVerification
{
    public $AccountHolderName; // String
    public $AccountHolderAddress1; // String
    public $AccountHolderAddress2; // String
    public $AccountHolderDateOfBirth; // String

    function __construct($type) {
        parent::__construct($type);
    }
}