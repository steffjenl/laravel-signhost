<?php
namespace Signhost\Models;


class Receiver
{
    public $Name; // String
    public $Email; // String
    public $Language; // String (enum)
    public $Message; // String
    public $Reference; // String
    public $Context; // Any object

    function __construct(
        $name,
        $email,
        $message,
        $language = "nl-NL",
        $reference = null,
        $context = null) {
        $this->Name = $name;
        $this->Email = $email;
        $this->Language = $language;
        $this->Message = $message;
        $this->Reference = $reference;
        $this->Context = $context;
    }
}