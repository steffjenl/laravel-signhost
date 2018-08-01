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

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     * @return FormSetField
     */
    public function setType($Type)
    {
        $this->Type = $Type;

        return $this;
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->Value;
    }

    /**
     * @param null $Value
     * @return FormSetField
     */
    public function setValue($Value)
    {
        $this->Value = $Value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->Location;
    }

    /**
     * @param mixed $Location
     * @return FormSetField
     */
    public function setLocation($Location)
    {
        $this->Location = $Location;

        return $this;
    }
}