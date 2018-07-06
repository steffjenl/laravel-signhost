<?php
namespace Signhost\Models;


class Verification
{
    public $Type; // String (enum)

    function __construct($type) {
        $this->Type = $type;
    }
}