<?php
namespace Signhost\Models;


class Verification
{
    public $Type;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     * @return Verification
     */
    public function setType($Type)
    {
        $this->Type = $Type;

        return $this;
    } // String (enum)

    function __construct($type) {
        $this->Type = $type;
    }
}