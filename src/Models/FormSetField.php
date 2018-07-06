<?php
namespace Signhost\Models;


class FormSetField
{
    public $Type; // String (enum)
    public $Value; // String
    public $Location; // Location

    function __construct($type, $location, $value = null) {
        $this->Type = $type;
        $this->Location = $location;
        $this->Value = $value;
    }
}