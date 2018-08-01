<?php
namespace Signhost\Models;


class FormSets
{
    public $FormSets;

    /**
     * @return mixed
     */
    public function getFormSets()
    {
        return $this->FormSets;
    }

    /**
     * @param mixed $FormSets
     * @return FormSets
     */
    public function setFormSets($FormSets)
    {
        $this->FormSets = $FormSets;

        return $this;
    } // Array of String

    function __construct($formSets) {
        $this->FormSets = $formSets;
    }
}