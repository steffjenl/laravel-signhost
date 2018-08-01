<?php
namespace Signhost\Models;


class iDINVerification
{
    /**
     * @return mixed
     */
    public function getAccountHolderName()
    {
        return $this->AccountHolderName;
    }

    /**
     * @param mixed $AccountHolderName
     * @return iDINVerification
     */
    public function setAccountHolderName($AccountHolderName)
    {
        $this->AccountHolderName = $AccountHolderName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccountHolderAddress1()
    {
        return $this->AccountHolderAddress1;
    }

    /**
     * @param mixed $AccountHolderAddress1
     * @return iDINVerification
     */
    public function setAccountHolderAddress1($AccountHolderAddress1)
    {
        $this->AccountHolderAddress1 = $AccountHolderAddress1;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccountHolderAddress2()
    {
        return $this->AccountHolderAddress2;
    }

    /**
     * @param mixed $AccountHolderAddress2
     * @return iDINVerification
     */
    public function setAccountHolderAddress2($AccountHolderAddress2)
    {
        $this->AccountHolderAddress2 = $AccountHolderAddress2;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccountHolderDateOfBirth()
    {
        return $this->AccountHolderDateOfBirth;
    }

    /**
     * @param mixed $AccountHolderDateOfBirth
     * @return iDINVerification
     */
    public function setAccountHolderDateOfBirth($AccountHolderDateOfBirth)
    {
        $this->AccountHolderDateOfBirth = $AccountHolderDateOfBirth;

        return $this;
    }
    public $AccountHolderName; // String
    public $AccountHolderAddress1; // String
    public $AccountHolderAddress2; // String
    public $AccountHolderDateOfBirth; // String

    function __construct($type) {
        parent::__construct($type);
    }
}