<?php
namespace Signhost\Models;


class Link
{
    public $Rel;

    /**
     * @return mixed
     */
    public function getRel()
    {
        return $this->Rel;
    }

    /**
     * @param mixed $Rel
     * @return Link
     */
    public function setRel($Rel)
    {
        $this->Rel = $Rel;

        return $this;
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
     * @return Link
     */
    public function setType($Type)
    {
        $this->Type = $Type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->Link;
    }

    /**
     * @param mixed $Link
     * @return Link
     */
    public function setLink($Link)
    {
        $this->Link = $Link;

        return $this;
    } // String (enum)
    public $Type; // String
    public $Link; // String
}