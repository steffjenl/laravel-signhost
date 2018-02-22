<?php
namespace Signhost\Models;


class FormSets
{
    public $FormSets; // Array of String

    function __construct($formSets) {
        $this->FormSets = $formSets;
    }
}