<?php
namespace Signhost\Models;


class Activity
{
    public $Id; // String
    public $Code; // Integer (enum)
    public $Info;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     * @return Activity
     */
    public function setId($Id)
    {
        $this->Id = $Id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->Code;
    }

    /**
     * @param mixed $Code
     * @return Activity
     */
    public function setCode($Code)
    {
        $this->Code = $Code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->Info;
    }

    /**
     * @param mixed $Info
     * @return Activity
     */
    public function setInfo($Info)
    {
        $this->Info = $Info;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedDateTime()
    {
        return $this->CreatedDateTime;
    }

    /**
     * @param mixed $CreatedDateTime
     * @return Activity
     */
    public function setCreatedDateTime($CreatedDateTime)
    {
        $this->CreatedDateTime = $CreatedDateTime;

        return $this;
    } // String
    public $CreatedDateTime; // String
}